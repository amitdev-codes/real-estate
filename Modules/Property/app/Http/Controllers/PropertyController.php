<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Constants\StatusClasses;
use App\Services\ResponseService;
use App\Traits\HandlesExceptions;
use App\Models\PropertyLengthUnit;
use App\Traits\BulkDeletableTrait;
use Illuminate\Support\Facades\DB;
use Modules\Property\Models\Project;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\Property;
use Illuminate\Support\Facades\Storage;
use Modules\Property\Models\PropertyType;
use Modules\Property\Models\NearbyFacility;
use Modules\Property\Models\PropertyStatus;
use Modules\Property\Models\PropertyFeature;
use Modules\Property\Models\PropertyCategory;
use App\Http\Controllers\Admin\BaseResourceController;
use Modules\Property\Http\Requests\StorePropertyRequest;
use Modules\Property\Http\Requests\UpdatePropertyRequest;

class PropertyController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,Searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'properties';
        $this->redirectRouteName = 'admin.properties.index';  // route after saving
        $this->abilityName = 'properties';
        $this->routeName = 'properties';
        $this->dataRouteName = 'admin.properties.data'; // datatables
        $this->model = Property::class;
        $this->with = ['propertyStatus'];
        $this->formType = 'form';
        parent::__construct($responseService);
        $this->columns = [
            // [
            //     'data' => 'image',
            //     'title' => 'Image',
            //     'searchable' => false,
            //     'orderable' => false,
            //     'type' => 'image',
            //     'width' => '100px',
            // ],
            [
                'data' => 'title',
                'title' => 'Title',
                'searchable' => true,
                'orderable' => true,
                'type' => 'text',
                'width' => '300px',
            ],
            [
                'data' => 'property_status_id',
                'title' => 'Property Status',
                'searchable' => true,
                'width' => '100px',
                'type' => 'select',
                'options' => PropertyStatus::all()->map(function ($status) {
                    return ['id' => $status->id, 'name' => $status->name];
                }),
            ],
            [
                'data' => 'base_price',
                'title' => 'Price',
                'searchable' => true,
                'orderable' => false,
                'type' => 'text'
            ],
            [
                'data' => 'area',
                'title' => 'Area',
                'searchable' => false,
                'type' => 'text'
            ],
            [
                'data' => 'project_id',
                'title' => 'Project',
                'searchable' => true,
                'type' => 'select',
                'options' => Project::all()->map(function ($project) {
                    return ['id' => $project->id, 'name' => $project->name];
                }),
            ],
        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        $mappedData = [];
        return $records->map(function ($record) {
            $mappedData = [
                'id' => $record->id,
                // 'image' => $record->thumb_url,
                'title' => $record->title,
                'base_price' => $record->base_price,
                'area' => $record->area . ' ' . $record->unit->symbol,
                // 'property_purpose_id' => $record->propertyPurpose?->name,
                'project_id' => $record->project?->name,
                'property_status_id' => $record->propertyStatus?->name,
            ];
            return $mappedData;
        })->toArray();
    }

    protected function formPath()
    {
        return [
            'path' => 'Property::property/property-form',
            'props' => [
                'propertyTypes' => PropertyType::all()->map(function ($propertyType) {
                    return [
                        'id' => $propertyType->id,
                        'name' => $propertyType->name,
                        'parent_id'=>$propertyType->parent_id,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'features' => PropertyFeature::all()->map(function ($feature) {
                    return [
                        'id' => $feature->id,
                        'name' => $feature->name,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'facilities' => NearbyFacility::all()->map(function ($facility) {
                    return [
                        'id' => $facility->id,
                        'name' => $facility->name,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'areaUnits' => PropertyLengthUnit::where('type', 'area')->get()->map(function ($unit) {
                    return [
                        'id' => $unit->id,
                        'name' => $unit->name,
                        'symbol' => $unit->symbol,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'lengthUnits' => PropertyLengthUnit::where('type', 'length')->get()->map(function ($unit) {
                    return [
                        'id' => $unit->id,
                        'name' => $unit->name,
                        'symbol' => $unit->symbol,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'propertyStatus' => PropertyStatus::all()->map(function ($status) {
                    return [
                        'id' => $status->id,
                        'name' => $status->name,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'projects' => Project::all()->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'selected' => false, // Add a selected state
                    ];
                }),
                // Change later, if involved with Agency load Agents from that agency, else load current agent
                'agents' => Agent::all()->map(function ($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->first_name.' '.$agent->last_name,
                        'selected' => false, // Add a selected state
                    ];
                })
            ],
        ];
    }


    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $addressFields = [
            "country",
            "state",
            "city",
            "street",
            "building_number",
            "postal_code",
            "latitude",
            "longitude",
        ];

        $seoFields = [
            'seo_title',
            'seo_description',
            'seo_indexing',
        ];

        $addressData = array_intersect_key($validated, array_flip($addressFields));

        $seoData = array_intersect_key($validated, array_flip($seoFields));

        $other_fields = ['property_types', 'facilities_distance' ];

        $propertyData = array_diff_key($validated, array_flip(array_merge($other_fields , $addressFields, $seoFields)));

        DB::beginTransaction();

        // dd($propertyData);
        $user = auth()->user();
        if ($user->hasRole('Agent')) {
            $redirectRoute = 'agent.properties.index';
            $createRedirectRoute = 'agent.properties.create';
        } elseif ($user->hasRole('Agency')) {
            $redirectRoute = 'agency.properties.index';
            $createRedirectRoute = 'agency.properties.create';
        } else {
            $redirectRoute = 'admin.properties.index'; // Default to admin for other roles
            $createRedirectRoute = 'admin.properties.create';
        }

        $propertyData['moderation_status'] = 'pending';
        try {
            $property = Property::create($propertyData);
            $property->propertyTypes()->sync($validated['property_types']);
            $property->address()->create($addressData);
            $metaContent = $property->metaContent()->create($seoData);
            if (!empty($validated['facilities_distance'])) {
                foreach ($validated['facilities_distance'] as $facilityDistance) {
                    $property->nearbyFacilities()->updateOrCreate(
                        ['nearby_facility_id' => $facilityDistance['facility']],
                        [
                            'distance' => $facilityDistance['distance'],
                            'unit_id' => $facilityDistance['unit_id'],
                        ]
                    );
                }
            }

            if ($request->has('hero_image') && !empty($request->input('hero_image')['tmp'])) {
                $property->addMedia(Storage::path('temp/' . $request->input('hero_image')['tmp']))->toMediaCollection('hero_image');
            }

            if ($request->has('image_360') && !empty($request->input('image_360')['tmp'])) {
                $property->addMedia(Storage::path('temp/' . $request->input('image_360')['tmp']))->toMediaCollection('image_360');
            }

            if ($request->has('floor_plan_images') && !empty($request->input('floor_plan_images'))) {
                foreach ($request->input('floor_plan_images', []) as $file) {
                    if (is_array($file)) {
                        $property->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('floor_plan_images');
                    }
                }
            }
            if ($request->has('property_gallery') && !empty($request->input('property_gallery'))) {
                foreach ($request->input('property_gallery', []) as $file) {
                    if (is_array($file)) {
                        $property->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('gallery');
                    }
                }
            }
            if ($request->has('seo_image') && !empty($request->input('seo_image')['tmp'])) {
                $metaContent->addMedia(Storage::path('temp/' . $request->input('seo_image')['tmp']))->toMediaCollection('images');
            }


            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            $errorMessage = "An error occurred: {$e->getMessage()}";
            return redirect()->route($createRedirectRoute)->with([
                'error' => $errorMessage,
                'toastr' => [
                    'type' => 'error',
                    'message' => $errorMessage,
                ],
            ]);
        }

        return redirect()->route($redirectRoute)->with([
            'success' => "Property created successfully.",
            'toastr' => [
                'type' => 'success',
                'message' => "Property processed successfully.",
            ],
        ]);
    }

    public function show($id)
    {
        return inertia('Property::property/show');
    }


    public function edit(Request $request, $model)
    {
        $this->authorizeAction('edit properties');
        $property = $model instanceof Property ? $model : Property::with('address', 'metaContent', 'nearbyFacilities', 'propertyTypes')->findOrFail($model);
        $formPath = $this->formPath();

        // dd($property, $property->thumb_url, $property->preview_url, $property->gallery_preview_url, $property->hero_image_path, $property->image_360_path, $property->floor_plan_image_path, $property->gallery_image_path);
        $categories = $this->getCategories();
        return Inertia::render($formPath['path'], array_merge($formPath['props'], [
            'property' => $property,
            'categories'=>$categories
        ]));
    }

    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $validated = $request->validated();

        $addressFields = [
            "country",
            "state",
            "city",
            "street",
            "building_number",
            "postal_code",
            "latitude",
            "longitude",
        ];

        $seoFields = [
            'seo_title',
            'seo_description',
            'seo_indexing',
        ];

        $addressData = array_intersect_key($validated, array_flip($addressFields));

        // dd($addressData);

        $seoData = array_intersect_key($validated, array_flip($seoFields));

        $other_fields = ['property_types', 'facilities_distance' ];

        $propertyData = array_diff_key($validated, array_flip(array_merge($other_fields , $addressFields, $seoFields)));

        DB::beginTransaction();

        $user = auth()->user();
        if ($user->hasRole('Agent')) {
            $redirectRoute = 'agent.properties.index';
            $editRedirectRoute = 'agent.properties.edit';
        } elseif ($user->hasRole('Agency')) {
            $redirectRoute = 'agency.properties.index';
            $editRedirectRoute = 'agency.properties.edit';
        } else {
            $redirectRoute = 'admin.properties.index'; // Default to admin for other roles
            $editRedirectRoute = 'admin.properties.edit';
        }


        try {

            $property->update($propertyData);
            $property->address()->updateOrCreate([], $addressData);
            $metaContent =$property->metaContent()->updateOrCreate([], $seoData);

            if (!empty($validated['facilities_distance'])) {
                foreach ($validated['facilities_distance'] as $facilityDistance) {
                    $property->nearbyFacilities()->updateOrCreate(
                        ['nearby_facility_id' => $facilityDistance['facility']],
                        [
                            'distance' => $facilityDistance['distance'],
                            'unit_id' => $facilityDistance['unit_id'],
                        ]
                    );
                }
            }


            // dd($request->all());
            if ($request->has('hero_image') && !empty($request->input('hero_image')['tmp'])) {
                $property->addMedia(Storage::path('temp/' . $request->input('hero_image')['tmp']))->toMediaCollection('hero_image');
            }

            if ($request->has('image_360') && !empty($request->input('image_360')['tmp'])) {
                $property->addMedia(Storage::path('temp/' . $request->input('image_360')['tmp']))->toMediaCollection('image_360');
            }

            if ($request->has('floor_plan_images') && !empty($request->input('floor_plan_images'))) {
                foreach ($request->input('floor_plan_images', []) as $file) {
                    if (is_array($file)) {
                        $property->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('floor_plan_images');
                    }
                }
            }
            if ($request->has('property_gallery') && !empty($request->input('property_gallery'))) {
                foreach ($request->input('property_gallery', []) as $file) {
                    if (is_array($file)) {
                        $property->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('gallery');
                    }
                }
            }
            if ($request->has('seo_image') && !empty($request->input('seo_image')['tmp'])) {
                $metaContent->addMedia(Storage::path('temp/' . $request->input('seo_image')['tmp']))->toMediaCollection('images');
            }

            // dd("before commit");

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            $errorMessage = "An error occurred: {$e->getMessage()}";

            dd($errorMessage);

            return redirect()->route($editRedirectRoute, $property)->with([
                'error' => $errorMessage,
                'toastr' => [
                    'type' => 'error',
                    'message' => $errorMessage,
                ],
            ]);
        }

        return redirect()->route($redirectRoute)->with([
            'success' => "Property updated successfully.",
            'toastr' => [
                'type' => 'success',
                'message' => "Property updated successfully.",
            ],
        ]);
    }

    public function destroy( Request $request, $model): RedirectResponse
    {
        $this->authorizeAction('delete '.$this->abilityName);

        $modelClass = $this->model;

        $modelInstance = $modelClass::findOrFail($model);

        return $this->handleRequest($request, function () use ($modelInstance) {

            $modelInstance->delete();

            $modelInstance->address()->delete();

            $modelInstance->metaContent()->delete();

            $modelInstance->nearbyFacilities()->delete();

            return true;
        });
    }

    public function getCategories()
    {
        $categories = PropertyCategory::with('children')
        ->whereHas('children') // Ensure the category has child categories
        ->pluck('name','id')->toArray();

        return $categories;

        //  // Transform the data into the desired structure
        //  $transformedCategories = $categories->mapWithKeys(function ($category) {
        //     return [$category->name => $category->children->pluck('name','id')->toArray()];
        // });

        // return $transformedCategories;
    }
}
