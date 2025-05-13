<?php

namespace Modules\Agent\Http\Controllers;

use Inertia\Inertia;
use App\Traits\Searchable;
use App\Models\master\City;
use App\Models\master\State;
use Illuminate\Http\Request;
use App\Models\master\Country;
use Modules\Agent\Models\Agent;
use App\Constants\StatusClasses;
use App\Services\ResponseService;
use App\Traits\HandlesExceptions;
use App\Models\PropertyLengthUnit;
use App\Traits\BulkDeletableTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Property\Models\Project;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\Property;
use Modules\Property\Models\PropertyType;
use Modules\Property\Models\NearbyFacility;
use Modules\Property\Models\PropertyStatus;
use Modules\Property\Models\PropertyFeature;
use Modules\Property\Models\PropertyPurpose;
use Modules\Property\Models\PropertyCategory;
use App\Http\Controllers\Admin\BaseResourceController;

class PropertyController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'properties';
        $this->redirectRouteName = 'agent.properties.index';
        $this->abilityName = 'properties';
        $this->routeName = 'properties';
        $this->dataRouteName = 'agent.properties.data';
        $this->model = Property::class;
        $this->with = ['media', 'propertyStatus']; // Added relationships
        $this->formType = 'form';
        $this->viewType = 'form';
        parent::__construct($responseService);
        $this->columns = [
            [
                'data' => 'image',
                'title' => 'Image',
                'searchable' => false,
                'orderable' => false,
                'type' => 'image',
                'width' => '100px', // Add width for responsive handling
            ],
            [
                'data' => 'title',
                'title' => 'Title',
                'searchable' => true,
                'type' => 'text',
                'width' => '200px',
            ],
            [
                'data' => 'area',
                'title' => 'Area (sq ft)',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'base_price',
                'title' => 'Base Price',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'offer_price',
                'title' => 'Offer Price',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'property_status_id',
                'title' => 'Property Status',
                'searchable' => true,
                'type' => 'select',
                'options' => PropertyStatus::all()->map(function ($status) {
                    return ['id' => $status->id, 'name' => $status->name];
                }),
            ],
        ];
    }

    protected function formPath()
    {
        return [
            'path' => 'Agent::properties/create-edit',
            'props' => [
                'countries' => Country::get(['id', 'name'])->map(function ($country) {
                    return [
                        'value' => $country->id,
                        'label' => $country->name,
                    ];
                }),
                'cities' => City::get(['id', 'name'])->map(function ($city) {
                    return [
                        'value' => $city->id,
                        'label' => $city->name,
                    ];
                }),
                'states' => State::get(['id', 'name'])->map(function ($state) {
                    return [
                        'value' => $state->id,
                        'label' => $state->name,
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
                'agents' => Agent::all()->map(function ($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->first_name.' '.$agent->last_name,
                        'selected' => false, // Add a selected state
                    ];
                }),
                'agent' =>  auth()->user()->agent,
            ],
        ];
    }
    protected function prepareCustomViewData($record)
{
    // Override this method in specific resource controllers
    // to prepare custom view data
    return $record->toArray();
}


    protected function mapRecords($records, $exportType=null)
    {
        $mappedData = [];
        return $records->map(function ($record) use ($exportType) {
            $mappedData = [
                'id' => $record->id,
                'image' => $this->getPropertyImage($record),
                'title' => $record->title,
                'agency_id' => $record->agent->agency->name ?? 'N/A',
                'area' => number_format($record->area).' sq ft',
                'property_purpose_id' => $record->propertyPurpose->name ?? 'N/A',
                'base_price' => number_format($record->base_price),
                'offer_price' => number_format($record->offer_price),
                'publish_end_date' => $record->publish_end_date,
                'property_status_id' => $record->propertyStatus->name ?? 'N/A',
            ];

            if (isset($exportType['type'])) {
                if ($record->propertyStatus) {
                    $mappedData['property_status_id'] = $record->propertyStatus->name;
                }
                if ($record->propertyPurpose) {
                    $mappedData['property_purpose_id'] = $record->propertyPurpose->name;
                }
                if (isset($exportType['type']) && $exportType['type'] === 'pdf') {
                    $mappedData['image'] = $record->getFirstMedia('images')
                        ? $record->getFirstMedia('images')->getUrl('thumb')
                        : asset('static/images/bg/01.jpg');
                } else {
                    $mappedData['image'] = $this->getPropertyImage($record);
                }
            } else {
                if ($record->propertyStatus) {
                    $mappedData['property_status_id'] = sprintf(
                        '<span class="%s">%s</span>',
                        StatusClasses::getClass($record->property_status_id) ?? 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full',
                        $record->propertyStatus->name
                    );
                }
                if ($record->propertyPurpose) {
                    $mappedData['property_purpose_id'] = sprintf(
                        '<span class="%s">%s</span>',
                        StatusClasses::getClass($record->propertyPurpose->id) ?? 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full',
                        $record->propertyPurpose->name
                    );
                }
            }
            return $mappedData;
        })->toArray();
    }

    protected function getPropertyImage($record)
    {
        $media = $record->getFirstMedia('images');
        if ($media) {
            return sprintf(
                '<img src="%s" alt="%s" class="w-16 h-16 object-cover rounded-lg shadow-sm">',
                $media->getUrl('thumb'),
                htmlspecialchars($record->title)
            );
        }

        return sprintf(
            '<img src="%s" alt="Default Image" class="w-16 h-16 object-cover rounded-lg shadow-sm">',
            asset('static/images/bg/01.jpg')
        );
    }

    protected function getAdditionalIndexData()
    {
        return [];
    }


    public function edit(Request $request,$model)
    {
        $this->authorizeAction('edit properties');
        $user = auth()->user();

        if ($user->hasRole('Agent') && $user->agent->status !== 'active') {
            abort(403, 'You are not an active agent.');  // Permission error
        }

        if ($user->hasRole('Agency') && $user->agent->status !== 'active') {
            abort(403, 'You are not an active agency.');  // Permission error
        }
        $property = $model instanceof Property ? $model : Property::with('address', 'metaContent', 'nearbyFacilities', 'propertyTypes')->findOrFail($model);
        $categories = PropertyCategory::with('children')
        ->whereHas('children') // Ensure the category has child categories
        ->get();
        $formPath = $this->formPath();
        return Inertia::render($formPath['path'], array_merge($formPath['props'], [
            'property' => $property,
            'categories' => $categories,
        ]));
    }

}
