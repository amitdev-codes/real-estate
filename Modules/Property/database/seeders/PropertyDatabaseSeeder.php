<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\NearbyFacility;
use Modules\Property\Models\PropertyType;

class PropertyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PropertyCategorySeeder::class,
            PropertyDeveloperSeeder::class,
            ProjectStatusSeeder::class,
            PropertyStatusSeeder::class,
            PropertyTypeSeeder::class,
            PropertyFeatureSeeder::class,

            NearbyFacilitySeeder::class,
            ProjectSeeder::class,
            PropertySeeder::class,
        ]);
    }
}
