<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Controllers\Controller;
use App\Models\PropertyLengthUnit;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Modules\Agency\Models\Agency;
use Modules\Property\Http\Requests\StoreProjectRequest;
use Modules\Property\Http\Requests\UpdateProjectRequest;
use Modules\Property\Models\Project;
use Modules\Property\Models\ProjectStatus;
use Modules\Property\Models\PropertyDeveloper;
use Modules\Property\Models\PropertyFeature;
use Modules\Property\Models\PropertyType;

class ProjectController extends BaseResourceController
{


    use BulkDeletableTrait, HandlesExceptions, Searchable;


    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'projects';
        $this->abilityName = 'projects';
        $this->routeName = 'admin.projects';
        $this->redirectRouteName = 'admin.projects.index';
        $this->dataRouteName = 'admin.projects.data';
        $this->model = Project::class;
        $this->with = [];
        $this->formType = 'form';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'project_status_id', 'title' => 'Project Status', 'searchable' => true, 'type' => 'text'],
            ['data' => 'lowest_price', 'title' => 'Lowest Price', 'searchable' => true, 'type' => 'text'],
            ['data' => 'max_price', 'title' => 'Max Price', 'searchable' => true, 'type' => 'text'],
            ['data' => 'project_finish_date', 'title' => 'Finish Date', 'searchable' => true, 'type' => 'date'],
            ['data' => 'is_featured', 'title' => 'Featured', 'searchable' => false, 'type' => 'text'],
        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        return $records->map(function ($record) {

            return [
                'id' => $record->id,
                'name' => $record->name,
                'lowest_price' => $record->lowest_price,
                'max_price' => $record->max_price,
                'project_status_id' => $record->projectStatus?->name,
                'project_finish_date' => $record->project_finish_date,
                'is_featured' => $record->is_featured ? 'Yes' : 'No',
            ];
        });
    }

    protected function formPath()
    {
        return [
            'path' => 'Property::project/project-form',
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
                'projectStatus' => ProjectStatus::all()->map(function ($status) {
                    return [
                        'id' => $status->id,
                        'name' => $status->name,
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
                'propertyDevelopers' => PropertyDeveloper::all()->map(function ($developer) {
                    return [
                        'id' => $developer->id,
                        'name' => $developer->developer_name,
                        'selected' => false, // Add a selected state
                    ];
                }),
            ],
        ];
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $developerFields = [
            'developer_name',
            'developer_email',
            'developer_phone',
            'developer_website',
        ];

        $developerAddressFields = [
            'country',
            'state',
            'city',
            'street',
            'building_number',
            'postal_code',
            'latitude',
            'longitude',
        ];

        $seoFields = [
            'seo_title',
            'seo_description',
            'seo_indexing',
        ];


        $developerData = array_intersect_key($validated, array_flip($developerFields));

        $addressData = array_intersect_key($validated, array_flip($developerAddressFields));

        $seoData = array_intersect_key($validated, array_flip($seoFields));

        $other_fields = ['property_types'];

        $projectData = array_diff_key($validated, array_flip(array_merge($developerFields, $developerAddressFields, $seoFields, $other_fields)));

        DB::beginTransaction();

        try {

            if (empty($projectData['developer_id'])) {
                $developer = PropertyDeveloper::create($developerData);
                $developer->address()->create($addressData);
                $projectData['developer_id'] = $developer->id;
            }

            $project = Project::create($projectData);

            $project->propertyTypes()->sync($validated['property_types']);
            $metaContent = $project->metaContent()->create($seoData);

            if ($request->has('hero_image') && !empty($request->input('hero_image')['tmp'])) {
                $project->addMedia(Storage::path('temp/' . $request->input('hero_image')['tmp']))->toMediaCollection('hero_image');
            }

            if ($request->has('image_360') && !empty($request->input('image_360')['tmp'])) {
                $project->addMedia(Storage::path('temp/' . $request->input('image_360')['tmp']))->toMediaCollection('image_360');
            }

            if ($request->has('floor_plan_images') && !empty($request->input('floor_plan_images'))) {
                foreach ($request->input('floor_plan_images', []) as $file) {
                    if (is_array($file)) {
                        $project->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('floor_plan_images');
                    }
                }
            }
            if ($request->has('project_gallery') && !empty($request->input('project_gallery'))) {
                foreach ($request->input('project_gallery', []) as $file) {
                    if (is_array($file)) {
                        $project->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('gallery');
                    }
                }
            }
            if ($request->has('seo_image') && !empty($request->input('seo_image')['tmp'])) {
                $metaContent->addMedia(Storage::path('temp/' . $request->input('seo_image')['tmp']))->toMediaCollection('images');
            }

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            $errorMessage = "An error occurred: {$e->getMessage()}";

            dd($errorMessage);

            return redirect()->route('admin.projects.index')->with([
                'error' => $errorMessage,
                'toastr' => [
                    'type' => 'error',
                    'message' => $errorMessage,
                ],
            ]);
        }

        return redirect()->route('admin.projects.index')->with([
            'success' => 'Project created successfully',
            'toastr' => [
                'type' => 'success',
                'message' => 'Project created successfully',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $model)
    {
        $this->authorizeAction('edit projects');
        $project = $model instanceof Project ? $model : Project::with('metaContent', 'propertyTypes','developer.address','agency' )->findOrFail($model);
        $formPath = $this->formPath();

        $agencies = Agency::all()->map(function ($agency) use($project) {
            return [
                'id' => $agency->id,
                'name' => $agency->name,
                'selected' => $project->agency_id == $agency->id,
            ];
            });

        return Inertia::render($formPath['path'], array_merge($formPath['props'], [
            'project' => $project,
            'agencies' => $agencies,
        ]));

    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        
        $developerFields = [
            'developer_name',
            'developer_email',
            'developer_phone',
            'developer_website',
        ];

        $developerAddressFields = [
            'country',
            'state',
            'city',
            'street',
            'building_number',
            'postal_code',
            'latitude',
            'longitude',
        ];

        $seoFields = [
            'seo_title',
            'seo_description',
            'seo_indexing',
        ];

        $developerData = array_intersect_key($validated, array_flip($developerFields));

        $addressData = array_intersect_key($validated, array_flip($developerAddressFields));

        $seoData = array_intersect_key($validated, array_flip($seoFields));

        $other_fields = ['property_types'];

        $projectData = array_diff_key($validated, array_flip(array_merge($developerFields, $developerAddressFields, $seoFields, $other_fields)));

        DB::beginTransaction();

        try {

            // if ($project->developer) {
            //     $project->developer->update($developerData);
            //     $project->developer->address()->update($addressData);
            // } else {
            //     $developer = PropertyDeveloper::create($developerData);
            //     $developer->address()->create($addressData);
            //     $projectData['developer_id'] = $developer->id;
            // }

            if (empty($projectData['developer_id'])) {
                $developer = PropertyDeveloper::create($developerData);
                $developer->address()->create($addressData);
                $projectData['developer_id'] = $developer->id;
            }

            $project->update($projectData);
            $project->propertyTypes()->sync($validated['property_types']);
            $metaContent = $project->metaContent()->updateOrCreate([], $seoData);

            if ($request->has('hero_image') && !empty($request->input('hero_image')['tmp'])) {
                $project->addMedia(Storage::path('temp/' . $request->input('hero_image')['tmp']))->toMediaCollection('hero_image');
            }

            if ($request->has('image_360') && !empty($request->input('image_360')['tmp'])) {
                $project->addMedia(Storage::path('temp/' . $request->input('image_360')['tmp']))->toMediaCollection('image_360');
            }

            if ($request->has('floor_plan_images') && !empty($request->input('floor_plan_images'))) {
                foreach ($request->input('floor_plan_images', []) as $file) {
                    if (is_array($file)) {
                        $project->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('floor_plan_images');
                    }
                }
            }
            if ($request->has('project_gallery') && !empty($request->input('project_gallery'))) {
                foreach ($request->input('project_gallery', []) as $file) {
                    if (is_array($file)) {
                        $project->addMedia(Storage::path('temp/' . $file['tmp']))->toMediaCollection('gallery');
                    }
                }
            }
            if ($request->has('seo_image') && !empty($request->input('seo_image')['tmp'])) {
                $metaContent->addMedia(Storage::path('temp/' . $request->input('seo_image')['tmp']))->toMediaCollection('images');
            }

            DB::commit();

        } catch (Exception $e) {
            $errorMessage = "An error occurred: {$e->getMessage()}";

            return redirect()->route('admin.projects.index')->with([
                'error' => $errorMessage,
                'toastr' => [
                    'type' => 'error',
                    'message' => $errorMessage,
                ],
            ]);
        }

        return redirect()->route('admin.projects.index')->with([
            'success' => 'Project created successfully',
            'toastr' => [
                'type' => 'success',
                'message' => 'Project created successfully',
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

            return true;
        });
    }

    public function getDevelopers(Request $request)
    {
        $developerId = $request->input('developer_id');
        $developer = PropertyDeveloper::with(['address'])->where('id', $developerId)->first()->toArray();

        return response()->json([
            'developer' => $developer,
            'message' => 'Developer retrieved successfully.',
        ]);

        // return Inertia::render('Property::project/project-form',  [
        //     'developer' => $developer,
        // ]);
    }
}
