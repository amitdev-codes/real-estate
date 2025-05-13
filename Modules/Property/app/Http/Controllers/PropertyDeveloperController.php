<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Modules\Property\Models\PropertyDeveloper;

class PropertyDeveloperController extends BaseResourceController
{
    use BulkDeletableTrait, HandlesExceptions, Searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'property-developers'; // route resouce
        $this->modelName = 'propertyDeveloper'; // model name which is defined in models resouce
        $this->abilityName = 'property developers'; // permissions
        $this->routeName = 'admin.property-developers.index'; // index
        $this->redirectRouteName = 'admin.property-developers.index';
        $this->dataRouteName = 'admin.property-developers.data';
        $this->model = PropertyDeveloper::class;
        $this->with = [];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'developer_name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'developer_email', 'title' => 'Email', 'searchable' => true, 'type' => 'text'],
            ['data' => 'developer_phone', 'title' => 'Phone', 'searchable' => true, 'type' => 'text'],
            ['data' => 'developer_website', 'title' => 'Website', 'searchable' => true, 'type' => 'text'],
        ];
    }

    protected function mapRecords($records, $exportType=null)
    {
        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'developer_name' => $record->developer_name,
                'developer_email' => $record->developer_email,
                'developer_phone' => $record->developer_phone,
                'developer_website' => $record->developer_website,
            ];
        });
    }

    public function store(Request $request)
    {
        // return $this->handleRequest($request, function () use ($request) {
        //     Country::create($request->validated());
        // });
    }

    public function update(Request $request, PropertyDeveloper $propertyDeveloper)
    {
        // return $this->handleRequest($request, function () use ($request, $country) {
        //     $country->update($request->validated());
        // });
    }
}
