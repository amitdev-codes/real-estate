<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HandlesExceptions;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Http\Requests\StorePropertyFacilityRequest;
use Modules\Property\Http\Requests\UpdatePropertyFacilityRequest;
use Modules\Property\Models\NearbyFacility;

class NearbyFacilityController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyFacilityRequest $request): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request) {
            NearbyFacility::create($request->validated());
            return redirect()
                ->route('admin.nearby-facilities.index')
                ->with('success', 'Nearby facility created successfully.');
        }, 'admin.nearby-facilities.index');
    }

    public function update(UpdatePropertyFacilityRequest $request, NearbyFacility $nearby_facility): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request, $nearby_facility) {
            $nearby_facility->update($request->validated());

            return redirect()
                ->route('admin.nearby-facilities.index')
                ->with('success', 'Nearby feature updated successfully.');
        }, 'admin.nearby-facilities.index');
    }

    public function destroy(NearbyFacility $nearby_facility)
    {
        return $this->handleExceptions(function () use ($nearby_facility) {
            $nearby_facility->deleteOrFail();
            return redirect()->back()->with('success', 'Nearby facility deleted');
        }, 'admin.nearby-facilities.index');
    }
}
