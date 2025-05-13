<?php

namespace Modules\Agency\Http\Controllers;

use Inertia\Inertia;
use App\Models\master\City;
use App\Models\master\State;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Traits\HasDropzoneMedia;
use Modules\Agency\Models\Agency;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileOverviewController extends Controller
{
    use HasDropzoneMedia;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userInformation = Agency::with('user', 'media', 'address')->where('user_id', Auth::id())->first();
    
        $data = null;
        if ($userInformation) {
            // Fetch all states and cities for dropdowns
            $states = State::all()->map(function ($state) {
                return ['value' => $state->id, 'label' => $state->name];
            })->toArray();
    
            $cities = City::all()->map(function ($city) {
                return ['value' => $city->id, 'label' => $city->name];
            })->toArray();
    
            // Map state and city names back to IDs for form defaults
            $stateId = $userInformation->address && $userInformation->address->state
                ? State::where('name', $userInformation->address->state)->first()?->id
                : null;
            $cityId = $userInformation->address && $userInformation->address->city
                ? City::where('name', $userInformation->address->city)->first()?->id
                : null;
    
            $data = [
                'id' => $userInformation->id,
                'model' => 'agency',
                'role' => 'Agency',
                'email' => $userInformation->email,
                'name' => $userInformation->name ?? '',
                'phone' => $userInformation->phone,
                'registered_agency_number' => $userInformation->registered_agency_number,
                'short_description' => $userInformation->short_description,
                'description' => $userInformation->description,
                'website' => $userInformation->website,
                'status' => $userInformation->status,
                'media_url' => $userInformation->thumb_url,
                'previewUrl' => $userInformation->preview_url,
                // Address fields
                'address' => $userInformation->address ? [
                    'state' => $stateId,              // ID for dropdown
                    'city' => $cityId,                // ID for dropdown
                    'street' => $userInformation->address->street,
                    'building_number' => $userInformation->address->building_number,
                    'postal_code' => $userInformation->address->postal_code,
                    'latitude' => $userInformation->address->latitude,
                    'longitude' => $userInformation->address->longitude,
                    'state_name' => $userInformation->address->state,  // Name for display
                    'city_name' => $userInformation->address->city,    // Name for display
                ] : null,
            ];
    
            return Inertia::render('Agency::profileOverview/index', [
                'data' => $data,
                'states' => $states,  // Pass states for dropdown
                'cities' => $cities,  // Pass cities for dropdown
            ]);
        }
    
        return Inertia::render('Agency::profileOverview/index', [
            'data' => $data,
        ]);
    }
    public function getTestimonials()
    {
        $agent = Agency::where('user_id', Auth::id())->first();
        if (! $agent) {
            return response()->json(['error' => 'Agency not found'], 404);
        }
        $testimonials = $agent->getMediaItems('agency_testimonials');
        return response()->json($testimonials);
    }

}
