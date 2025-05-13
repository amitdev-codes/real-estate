<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\Property;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{


    public function view(Request $request): Response
    {
        $user = Auth::user()->load('address', 'personalInformation', 'agent','agency');
        // $personalInformation=$user->personalInformation();
        $personalInformation=[];

    

        if($user->hasRole('Agency')){
            $agency=$user->agency;
            $personalInformation['website']=$agency->website;
            $personalInformation['bio']=$agency->description;
        }
        if($user->hasRole('Agent')){
            $agent=$user->agent;
            $personalInformation['website']=$agent->website;
        $personalInformation['bio']=$agent->bio;
        }
        if($user->hasRole('User')){
            $agent=$user->agent;
            $personalInformation['website']=$user->personalInformation->website;
            $personalInformation['bio']=$user->personalInformation->bio;
            $formattedDateOfBirth = $user->personalInformation->formatted_date_of_birth??null;
        
        }

        $properties = Property::query()
            ->when($user->hasRole('SuperAdmin'), function ($query) {
                return $query->with(['agent', 'media']);
            })
            ->when($user->hasRole('Agent'), function ($query) use ($user) {
                return $query->where('agent_id', $user->agent->id)
                            ->with(['media']);
            })
            ->when($user->hasRole('Agency'), function ($query) use ($user) {
                // Get the IDs of agents associated with the agency
                $agentIds = $user->agency->agents()->pluck('id');
                // dd($agentIds,$user);
                
                // Filter properties based on the agent IDs
                return $query->whereIn('agent_id', $agentIds)
                            ->with(['media']);
            })
            ->paginate(10);


        // Debugging: Log the properties to verify data


        return Inertia::render('backend/pages/user-profile/profile', [
            'userdata' => $user,
            'address' => $user->address,
            'personalInformation' => $personalInformation,
            'formattedDateOfBirth' => $formattedDateOfBirth??null,
            'status' => session('status'),
            'properties' => $properties->items(),
            'pagination' => [
                'current_page' => $properties->currentPage(),
                'last_page' => $properties->lastPage(),
                'per_page' => $properties->perPage(),
            ],
        ]);
    }

    public function edit(Request $request): Response
    {
        $user = Auth::user()->load('address', 'personalInformation', 'agent');
        return Inertia::render('backend/pages/user-profile/profile-setting', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'userdata'=>$user,
            'address' => $user->address,
            'personalInformation' => $user->personalInformation,
        ]);
    }

    // /**
    //  * Update the user's profile information.
    //  */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }
    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('success', 'profile-updated');
    // }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user()->load('address', 'personalInformation', 'agent','agency');

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'banner_image' => 'nullable|image|max:2048', // 2MB max
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // Update Users table
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        // Update or Create PersonalInformation
        $personalInfo = $user->personalInformation ?? new PersonalInformation();
        $personalInfo->informable_id = $user->id;
        $personalInfo->informable_type = get_class($user);
        $personalInfo->first_name = $validated['first_name'];
        $personalInfo->last_name = $validated['last_name'];
        // $personalInfo->occupation = $validated['occupation'];
        $personalInfo->bio = $validated['description'];
        $personalInfo->business_phone_number = $validated['phone'];
        $personalInfo->website = $validated['website'];
        $personalInfo->save();

        // Update or Create Address
        // $address = $user->address ?? new Address();
        // $address->addressable_id = $user->id;
        // $address->addressable_type = get_class($user);
        // $address->save();

        // Handle banner_image upload
        if ($request->hasFile('banner_image')) {
            $user->addMedia($request->file('banner_image'))
                ->toMediaCollection('banner_image');
        }

        // Handle profile_image upload
        if ($request->hasFile('profile_image')) {
            $user->addMedia($request->file('profile_image'))
                ->toMediaCollection('profile_image');
        }

        return redirect()->back()->with('status', 'Profile updated successfully');
    }

}
