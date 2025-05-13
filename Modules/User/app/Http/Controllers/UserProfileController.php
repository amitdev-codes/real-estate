<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\master\City;
use App\Models\master\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Modules\User\Models\User;

class UserProfileController extends Controller
{
    public function show()
    {
        $id = auth()->id();
        $user = User::with(['address'])->find($id);
        $states = State::all();
        $cities = City::all();

        // dd($user);

        return Inertia::render('User::profile/view', [
            'data' => array_merge($user->toArray(), [
                'media' => $user->getMediaWithUrls('users'),
            ]),
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'mobile_no' => 'required|string|max:20',
            'building_number' => 'required|string|max:255',
            'states' => 'required|exists:states,id', // Ensure the state exists in the states table
            'cities' => 'required|exists:cities,id', // Ensure the city exists in the cities table
            'postal_code' => 'required|string|max:20',
        ]);

        // Get the authenticated user
        $user = User::find(auth()->id());

        // Update user data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->mobile_no = $validatedData['mobile_no'];

        // Save the user
        $user->save();

        // Handle image upload using Spatie Media Library
        if ($request->hasFile('image')) {
            $user->clearMediaCollection('images'); // Clear existing images in the collection
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }

        // Save address data in the addresses table (polymorphic relationship)
        $address = $user->address ?? new Address; // Use existing address or create a new one
        $address->city = $validatedData['cities'];
        $address->state = $validatedData['states'];
        $address->postal_code = $validatedData['postal_code'];
        $address->building_number = $validatedData['building_number'];
        $user->address()->save($address);

        // Return a success response
        return Inertia::render('User::profile/view', [
            'message' => 'Profile updated successfully!',
            'data' => $user->load(['address', 'media']), // Load related data
            'states' => State::all(), // Re-fetch states if needed
            'cities' => City::all(), // Re-fetch cities if needed
        ]);
    }

    public function changePassword()
    {
        return Inertia::render('User::profile/accountSecurity');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);
        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }
        // Get the authenticated user
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::logout();

        return redirect()->route('login')->with('success', 'Your password has been updated successfully. Please log in again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
