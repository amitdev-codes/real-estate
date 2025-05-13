<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'SuperAdmin']);
        $admin = Role::create(['name' => 'Admin']);
        $agent = Role::create(['name' => 'Agent']);
        $agency = Role::create(['name' => 'Agency']);
        $user = Role::create(['name' => 'User']);
        $guest = Role::create(['name' => 'Guest']);

        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
            'view activityLogs', 'create activityLogs', 'edit activityLogs', 'delete activityLogs',
            'view systemLogs', 'create systemLogs',  'edit systemLogs', 'delete systemLogs',

            // Property Module Permissions
            'view property statuses', 'create property statuses', 'edit property statuses', 'delete property statuses',
            'view project statuses', 'create project statuses', 'edit project statuses', 'delete project statuses',
            'view property types', 'create property types', 'edit property types', 'delete property types',
            'view property features', 'create property features', 'edit property features', 'delete property features',
            'view nearby facilities', 'create nearby facilities', 'edit nearby facilities', 'delete nearby facilities',
            'view property categories', 'create property categories', 'edit property categories', 'delete property categories',
            'view property developers', 'create property developers', 'edit property developers', 'delete property developers',
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view properties', 'create properties', 'edit properties', 'delete properties',

            // Agency permissions
            'view agencies', 'create agencies', 'edit agencies', 'delete agencies',
            // Agent permissions
            'view agents', 'create agents', 'edit agents', 'delete agents',
            //locations
            'view countries', 'create countries', 'edit countries', 'delete countries',
            'view states', 'create states', 'edit states', 'delete states',
            'view cities', 'create cities', 'edit cities', 'delete cities',
            'view locationImporter', 'create locationImporter', 'edit locationImporter', 'delete locationImporter',
            'view locationExporter', 'create locationExporter', 'edit locationExporter', 'delete locationExporter',
            'view profileOverview', 'create profileOverview', 'edit profileOverview', 'delete profileOverview',
            'view agentsProfile', 'create agentsProfile', 'edit agentsProfile', 'delete agentsProfile',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $superAdmin->givePermissionTo(Permission::all());

        // Assign limited permissions to Admin
        $admin->givePermissionTo(['view users', 'edit users', 'view roles', 'view permissions']);

        $agent->givePermissionTo([
            'view property types', 'create property types', 'edit property types', 'delete property types',
            'view property features', 'create property features', 'edit property features', 'delete property features',
            'view nearby facilities', 'create nearby facilities', 'edit nearby facilities', 'delete nearby facilities',
            'view property developers', 'create property developers', 'edit property developers', 'delete property developers',
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view properties', 'create properties', 'edit properties', 'delete properties',
            'view profileOverview', 'create profileOverview', 'edit profileOverview', 'delete profileOverview',
        ]);

        $agency->givePermissionTo(['view agentsProfile', 'edit agentsProfile', 'view agentsProfile', 'view agentsProfile',       'view profileOverview', 'create profileOverview', 'edit profileOverview', 'delete profileOverview',]);
    }
}
