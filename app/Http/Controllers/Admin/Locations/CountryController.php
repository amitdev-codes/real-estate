<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Requests\Locations\StoreCountryRequest;
use App\Http\Requests\Locations\UpdateCountryRequest;
use App\Models\master\Country;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;

class CountryController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'countries';
        $this->abilityName = 'countries';
        $this->routeName = 'admin.countries';
        $this->dataRouteName = 'admin.countries.data';
        $this->redirectRouteName = 'admin.countries.index';
        $this->model = Country::class;
        $this->modelName = 'country';
        $this->with = [];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'code', 'title' => 'Code', 'searchable' => true, 'type' => 'text'],
        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'code' => $record->code,
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return [];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            Country::create($request->validated());
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        return $this->handleRequest($request, function () use ($request, $country) {
            $country->update($request->validated());
        });
    }
}
