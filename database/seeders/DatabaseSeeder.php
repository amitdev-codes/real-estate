<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Agency\Database\Seeders\AgencyDatabaseSeeder;
use Modules\Agent\Database\Seeders\AgentDatabaseSeeder;
use Modules\Notifications\Database\Seeders\NotificationsDatabaseSeeder;
use Modules\Property\Database\Seeders\PropertyDatabaseSeeder;
use Modules\Shortlist\Database\Seeders\ShortlistDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PropertyLengthUnitSeeder::class);
        $this->call(AgencyDatabaseSeeder::class);
        $this->call(AgentDatabaseSeeder::class);

        // Property Module Seeder
        $this->call(PropertyDatabaseSeeder::class);
        $this->call(NotificationTemplateSeeder::class);
        $this->call(NotificationsDatabaseSeeder::class);
        $this->call(ShortlistDatabaseSeeder::class);
    }
}
