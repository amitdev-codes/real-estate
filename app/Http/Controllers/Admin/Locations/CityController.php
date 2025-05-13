<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Requests\Locations\StoreCityRequest;
use App\Http\Requests\Locations\UpdateCityRequest;
use App\Models\master\City;
use App\Models\master\State;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;

class CityController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'cities';
        $this->abilityName = 'cities';
        $this->modelName = 'city';
        $this->routeName = 'admin.cities';
        $this->dataRouteName = 'admin.cities.data';
        $this->redirectRouteName = 'admin.cities.index';
        $this->model = City::class;
        $this->with = ['State'];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'code', 'title' => 'Code', 'searchable' => true, 'type' => 'text'],
            ['data' => 'state_id', 'title' => 'State', 'searchable' => true, 'type' => 'select', 'options' => State::all()],
        ];
    }

    protected function mapRecords($records, $exportType = null)
    {
        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'code' => $record->code,
                'state_id' => $record->State->name,
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return ['states' => State::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            City::create($request->validated());
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        return $this->handleRequest($request, function () use ($request, $city) {
            $city->update($request->validated());
        });
    }
}
