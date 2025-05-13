<?php

namespace Database\Seeders;

use App\Models\master\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->delete();
        $states = [
            ['name' => 'Australian Capital Territory', 'code' => 'ACT', 'country_id' => 13],
            ['name' => 'New South Wales', 'code' => 'NSW', 'country_id' => 13],
            ['name' => 'Northern Territory', 'code' => 'NT', 'country_id' => 13],
            ['name' => 'Queensland', 'code' => 'QLD', 'country_id' => 13],
            ['name' => 'South Australia', 'code' => 'SA', 'country_id' => 13],
            ['name' => 'Tasmania', 'code' => 'TAS', 'country_id' => 13],
            ['name' => 'Victoria', 'code' => 'VIC', 'country_id' => 13],
            ['name' => 'Western Australia', 'code' => 'WA', 'country_id' => 13],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
