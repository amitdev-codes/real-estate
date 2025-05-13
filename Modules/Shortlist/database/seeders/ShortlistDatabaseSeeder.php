<?php

namespace Modules\Shortlist\Database\Seeders;

use Illuminate\Database\Seeder;

class ShortlistDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ShortlistSeeder::class,
        ]);
    }
}
