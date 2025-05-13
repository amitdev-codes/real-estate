<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Requests\UserManagement\StorePermissionRequest;
use App\Http\Requests\UserManagement\UpdatePermissionRequest;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'permissions';
        $this->redirectRouteName = 'admin.permissions.index';
        $this->abilityName = 'permissions';
        $this->routeName = 'admin.permissions';
        $this->modelName = 'permission';
        $this->dataRouteName = 'admin.permissions.data';
        $this->model = Permission::class;
        $this->with = [];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
        ];
    }

    protected function mapRecords($records, $exportType = null)
    {
        return $records->map(function ($permission) {
            return [
                'id' => $permission->id,
                'name' => $permission->name,
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return [];
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            $validated = $request->validated();
            $resourceName = $validated['name'];
            $defaultPermissions = ['view', 'create', 'edit', 'delete'];

            foreach ($defaultPermissions as $action) {
                $permissionName = "{$action} {$resourceName}";
                if (! Permission::where('name', $permissionName)->exists()) {
                    Permission::create(['name' => $permissionName]);
                }
            }
            // Permission::create($validated);
        });
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        return $this->handleRequest($request, function () use ($request, $permission) {
            $validated = $request->validated();
            $permission->update($validated);
        });
    }
}
