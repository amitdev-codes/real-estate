<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Http\Requests\UserManagement\StoreRoleRequest;
use App\Http\Requests\UserManagement\UpdateRoleRequest;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseResourceController
{
    use BulkDeletableTrait, HandlesExceptions, Searchable;

    public function __construct(ResponseService $responseService)
    {
        $this->resourceName = 'roles';
        $this->redirectRouteName = 'admin.roles.index';
        $this->abilityName = 'roles';
        $this->routeName = 'admin.roles';
        $this->dataRouteName = 'admin.roles.data';
        $this->model = Role::class;
        $this->with = ['permissions'];
        $this->formType = 'form'; // Specifically set to form for roles
        parent::__construct($responseService);

        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'permissions', 'title' => 'Permissions'],
        ];

        // Define searchable columns

    }

    protected function formPath()
    {
        return [
            'path' => 'backend/pages/user-management/roles/create-edit',
            'props' => [
                'permissions' => Permission::all()->map(function ($permission) {
                    return [
                        'name' => $permission->name,
                        'selected' => false, // Add a selected state
                    ];
                }),
            ],
        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        return $records->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->implode(', '),
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return ['permissions' => Permission::get()];
    }

    public function create(Request $request)
    {
        $formPath = $this->formPath();

        return Inertia::render($formPath['path'], $formPath['props']);
    }

    public function edit(Request $request, $model)
    {
        $this->authorizeAction('edit roles');
        $role = $model instanceof Role ? $model : Role::findOrFail($model);
        $formPath = $this->formPath();

        return Inertia::render($formPath['path'], array_merge($formPath['props'], [
            'role' => $role->load('permissions'),
        ]));
    }

    public function store(StoreRoleRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            return DB::transaction(function () use ($request) {
                $validated = $request->validated();

                // Create role
                $role = Role::create(['name' => $validated['name']]);

                // Assign permissions if provided
                if (! empty($validated['permissions'])) {
                    try {
                        $role->givePermissionTo($validated['permissions']);
                    } catch (\Exception $e) {
                        \Log::error('Error assigning permissions: '.$e->getMessage());
                        throw new \Exception('Failed to assign permissions');
                    }
                }

                return $role;
            });
        });
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        return $this->handleRequest($request, function () use ($request, $role) {
            return DB::transaction(function () use ($request, $role) {
                $validated = $request->validated();

                // Update role name
                $role->update([
                    'name' => $validated['name'],
                ]);

                // Sync permissions
                if (! empty($validated['permissions'])) {
                    $role->syncPermissions($validated['permissions']);
                } else {
                    $role->permissions()->detach();
                }

                return $role;
            });
        });
    }
}
