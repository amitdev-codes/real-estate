<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesExceptions;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Property\Http\Requests\StorePropertyTypeRequest;
use Modules\Property\Http\Requests\UpdatePropertyTypeRequest;
use Modules\Property\Models\PropertyType;

class PropertyTypeController extends Controller
{

    use HandlesExceptions; 

    public function index()
    {
        $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
        $icons = json_decode(file_get_contents($icon_path), true);

        // $property_types = PropertyType::orderBy('order_no', 'asc')->get();

        // foreach($property_types as $types){
        //     dd($types->preview_url);
        // }


        return inertia('Property::property-type/index',
            [
                'propertyTypes' => PropertyType::orderBy('order_no', 'asc')->get(),
                'icons'=> $icons,
            ]);

        // return inertia('Property::property-type/index');
    }

    public function store(StorePropertyTypeRequest $request): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request) {
            // dd($request->has('images.image'), $request->images['image']);
            // dd($request->all());
            $property_type = PropertyType::create($request->validated());      

            if ($request->has('images')) {
                foreach ($request->input('images', []) as $file) {
                    $property_type->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('images');
                }
            }

            return redirect()
                ->route('admin.property-types.index')
                ->with('success', 'Property type created successfully.');
        }, 'admin.property-types.index');
    }

    public function update(UpdatePropertyTypeRequest $request, PropertyType $property_type): RedirectResponse
    {
        return $this->handleExceptions(function () use ($request, $property_type) {
            
            $property_type->update($request->validated());

            if ($request->has('images')) {
                foreach ($request->input('images', []) as $file) {
                    if (is_array($file)) {
                        $property_type->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('images');
                    }
                }
            }
            return redirect()
                ->route('admin.property-types.index')
                ->with('success', 'Property type updated successfully.');

            }, 'admin.property-types.index');
    }

    public function destroy(PropertyType $property_type)
    {
        return $this->handleExceptions(function () use ($property_type) {
            $property_type->deleteOrFail();
            return redirect()->back()->with('success', 'Property type deleted');
        }, 'admin.property-types.index');
    }

    public function updateOrder(Request $request)
    {
        return $this->handleExceptions(function () use ($request) {

            foreach($request->propertyTypes as $property_type){
                PropertyType::where('id', $property_type['id'])->update([
                    'parent_id' => $property_type['parent_id'],
                    'order_no' => $property_type['order_no']
                ]);
            }           

            return redirect()->back()->with('success', 'Property type(s) Updated');
        }, 'admin.property-types.index');
    }

}
