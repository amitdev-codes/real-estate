<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HandlesExceptions;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Http\Requests\StorePropertyFacilityRequest;
use Modules\Property\Http\Requests\UpdatePropertyFacilityRequest;
use Modules\Property\Models\NearbyFacility;

class PropertyFactilityController extends Controller
{
    use HandlesExceptions;

    public function index()
    {
        $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
        $icons = json_decode(file_get_contents($icon_path), true);

        return inertia('Property::property-facility/index',
            [
                'facilities' => NearbyFacility::all(),
                'icons'=> $icons,
            ]);
    }

    public function store(StorePropertyFacilityRequest $request): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request) {
            NearbyFacility::create($request->validated());
            return redirect()
                ->route('admin.property-facilities.index')
                ->with('success', 'Property facility created successfully.');
        }, 'admin.property-facilities.index');
    }

    public function update(UpdatePropertyFacilityRequest $request, NearbyFacility $property_facility): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request, $property_facility) {
            $property_facility->update($request->validated());

            return redirect()
                ->route('admin.property-facilities.index')
                ->with('success', 'Property feature updated successfully.');
        }, 'admin.property-facilities.index');
    }

    public function destroy(NearbyFacility $property_facility)
    {
        return $this->handleExceptions(function () use ($property_facility) {
            $property_facility->deleteOrFail();
            return redirect()->back()->with('success', 'Property feature deleted');
        }, 'admin.property-facilities.index');
    }
}
