<?php

namespace Modules\Agency\Http\Controllers;


use Inertia\Inertia;
use App\Models\master\City;
use App\Models\master\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\Property;
use Modules\Agency\Http\Requests\UpdateAgencyRequest;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $stats=[];
        $agency=Agency::where('id',Auth::user()->id)->first();
        $agents=Agent::where('agency_id',Auth::user()->id)->get();
        $statusCounts = $agents->groupBy('status')->map->count();
        $totalProperties = Property::whereIn('agent_id', $agents->pluck('id'))->count();

        return Inertia::render('Agency::dashboard', [
            'data' => [
                'agency_name' => $agency->name,
                'agency_id' => $agency->agency_id,
                'total_agents' => $agents->count(),
                'total_properties' =>  $totalProperties,
                'approved_agents' => $statusCounts['active'] ?? 0,
                'pending_agents' => $statusCounts['pending'] ?? 0,
                'rejected_agents' => $statusCounts['suspended'] ?? 0,
            ],
        ]);
    }

    public function index()
    {
        return view('agency::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agency::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('agency::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('agency::edit');
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(UpdateAgencyRequest $request, Agency $agency)
{
    $validatedData = $request->validated();

    // Separate agency-specific fields from address fields
    $agencyData = array_diff_key($validatedData, array_flip([
        'state', 'city', 'street', 'building_number', 'postal_code', 'latitude', 'longitude'
    ]));
    $addressData = array_intersect_key($validatedData, array_flip([
        'state', 'city', 'street', 'building_number', 'postal_code', 'latitude', 'longitude'
    ]));

    // Add addressable fields (only needed for create)
    $addressData['addressable_id'] = $agency->id;
    $addressData['addressable_type'] = get_class($agency);

    // Query state and city names from their respective tables
    $stateId = $addressData['state'] ?? null;
    $cityId = $addressData['city'] ?? null;

    // Assuming you have State and City models
    $stateName = $stateId ? State::find($stateId)?->name : null;
    $cityName = $cityId ? City::find($cityId)?->name : null;

    // Replace state and city IDs with names in addressData
    $addressData['state'] = $stateName;
    $addressData['city'] = $cityName;

    // Cast latitude and longitude to float
    $addressData['latitude'] = isset($addressData['latitude']) ? (float) $addressData['latitude'] : null;
    $addressData['longitude'] = isset($addressData['longitude']) ? (float) $addressData['longitude'] : null;
    // Update agency data
    $agency->update($agencyData);

    // Prepare address data for update (exclude addressable fields)
    $addressDataForUpdate = array_diff_key($addressData, array_flip(['addressable_id', 'addressable_type']));
    // Update or create address
    try {
        if ($agency->address) {
            $address = $agency->address->fresh();
            $address->update($addressDataForUpdate);
        } else {
            $agency->address()->create($addressData);
        }
    } catch (\Exception $e) {
        dd('Error: ' . $e->getMessage());
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $agency->clearMediaCollection('agency');
        $agency->addMediaFromRequest('image')
            ->usingName('agency_profile')
            ->usingFileName('profile_' . time() . '.' . $request->image->extension())
            ->toMediaCollection('agency');
    }

    // Load relationships
    $agency->load('media', 'address');

    return redirect()->route('agency.profileOverview')->with('success', 'Profile updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
