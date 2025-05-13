<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Modules\Property\Models\PropertyDeveloper;

class PropertyDeveloperSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_AU');

        foreach (range(1, 20) as $index) {
            $developer = PropertyDeveloper::create([
                'developer_name'    => $faker->company,
                'developer_email'   => $faker->unique()->safeEmail,
                'developer_phone'   => $faker->optional()->phoneNumber,
                'developer_website' => $faker->optional()->url,
            ]);

            $developer->address()->create([
                'building_number' => $faker->optional()->buildingNumber,
                'street'          => $faker->streetAddress,
                'city'            => $faker->city,
                'state'           => $faker->state,
                'country'         => 'Australia',
                'postal_code'     => $faker->postcode,
                'latitude'        => $faker->optional()->latitude(-43.634597, -10.668185),
                'longitude'       => $faker->optional()->longitude(112.921230, 153.638673), 
            ]);
        }
    }
}
