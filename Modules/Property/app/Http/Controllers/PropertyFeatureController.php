<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HandlesExceptions;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Http\Requests\StorePropertyFeatureRequest;
use Modules\Property\Http\Requests\UpdatePropertyFeatureRequest;
use Modules\Property\Models\PropertyFeature;

class PropertyFeatureController extends Controller
{
    use HandlesExceptions;

    public function index()
    {
        $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
        $icons = json_decode(file_get_contents($icon_path), true);

        return inertia('Property::property-feature/index',
            [
                'features' => PropertyFeature::all(),
                'icons'=> $icons,
        ]);
    }

    public function store(StorePropertyFeatureRequest $request): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request) {
            PropertyFeature::create($request->validated());
            return redirect()
                ->route('admin.property-features.index')
                ->with('success', 'Property feature created successfully.');
        }, 'admin.property-features.index');
    }

    public function update(UpdatePropertyFeatureRequest $request, PropertyFeature $property_feature): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request, $property_feature) {
            $property_feature->update($request->validated());

            return redirect()
                ->route('admin.property-features.index')
                ->with('success', 'Property feature updated successfully.');
            }, 'admin.property-features.index');
    }

    public function destroy(PropertyFeature $property_feature)
    {
        return $this->handleExceptions(function () use ($property_feature) {
            $property_feature->deleteOrFail();
            return redirect()->back()->with('success', 'Property feature deleted');
        }, 'admin.property-features.index');
    }

    public function reorder(PropertyFeature $property_feature){
        return $this->handleExceptions(function () use ($property_feature) {
            dd("inside reorder");
        }, 'admin.property-features.index');
    }
}
