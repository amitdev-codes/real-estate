<?php

namespace App\Http\Controllers\Admin\Locations;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Requests\Locations\StoreStateRequest;
use App\Http\Requests\Locations\UpdateStateRequest;
use App\Models\master\Country;
use App\Models\master\State;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;

class StateController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'states';
        $this->abilityName = 'states';
        $this->modelName = 'state';
        $this->routeName = 'admin.states';
        $this->dataRouteName = 'admin.states.data';
        $this->redirectRouteName = 'admin.states.index';
        $this->model = State::class;
        $this->with = ['Country'];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'code', 'title' => 'Code', 'searchable' => true, 'type' => 'text'],
            ['data' => 'country_id', 'title' => 'Country', 'searchable' => true, 'type' => 'select', 'options' => Country::all()],
        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        return $records->map(function ($record) {
            return [
                'id' => $record->id,
                'name' => $record->name,
                'code' => $record->code,
                'country_id' => $record->Country->name,
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return ['countries' => Country::all()];
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            State::create($request->validated());
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state)
    {
        return $this->handleRequest($request, function () use ($request, $state) {
            $state->update($request->validated());
        });
    }
}
