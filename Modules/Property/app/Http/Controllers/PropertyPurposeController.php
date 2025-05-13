<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HandlesExceptions;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Http\Requests\StorePropertyPurposeRequest;
use Modules\Property\Http\Requests\UpdatePropertyPurposeRequest;
use Modules\Property\Models\PropertyPurpose;

class PropertyPurposeController extends Controller
{
    use HandlesExceptions;

    public function index()
    {
        return inertia('Property::property-purpose/index',
            [
                'purposes' => PropertyPurpose::all()
        ]);
    }

    public function store(StorePropertyPurposeRequest $request): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request) {
            PropertyPurpose::create($request->validated());
            return redirect()
                ->route('admin.property-purposes.index')
                ->with('success', 'Property purpose created successfully.');
        }, 'admin.property-purposes.index');
    }

    public function update(UpdatePropertyPurposeRequest $request, PropertyPurpose $property_purpose): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request, $property_purpose) {
            $property_purpose->update($request->validated());

            return redirect()
                ->route('admin.property-purposes.index')
                ->with('success', 'Property purpose updated successfully.');
            }, 'admin.property-purposes.index');
    }

    public function destroy(PropertyPurpose $property_purpose)
    {
        return $this->handleExceptions(function () use ($property_purpose) {
            $property_purpose->deleteOrFail();
            return redirect()->back()->with('success', 'Property purpose deleted');
        }, 'admin.property-purposes.index');
    }

}
