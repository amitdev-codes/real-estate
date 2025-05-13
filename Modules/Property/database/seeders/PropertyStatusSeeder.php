<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\PropertyStatus;

class PropertyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        $statuses = [
            [
                'name' => 'Not Available',
                'description' => "Project's properties are not available right now.",
                'is_active' => true,
            ],
            [
                'name' => 'Preparing for Sales',
                'description' => "Project's properties will be available for sales soon.",
                'is_active' => true,
            ],
            [
                'name'=> 'Selling',
                'description' => "Project's properties are currently being sold.",
                'is_active' => true,
            ],
            [
                'name'=> 'Sold',
                'description' => "Project's properties have been sold.",
                'is_active' => true,
            ],
            [
                'name'=> 'Renting',
                'description' => "Project's properties are currently being rented.",
                'is_active' => true,
            ],
            [
                'name'=> 'Rented',
                'description' => "Project's properties are rented out.",
                'is_active' => true,
            ],
            [
                'name'=> 'On Hold',
                'description' => "Project's properties are on hold.",
                'is_active' => true,
            ],
            [
                'name'=> 'Building',
                'description' => "Project's properties are currently being built.",
                'is_active' => true,
            ]
        ];

        foreach ($statuses as $status) {
            PropertyStatus::create($status);
        }
    }
}
