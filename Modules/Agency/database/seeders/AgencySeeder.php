<?php

namespace Modules\Agency\Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\Agency\Models\Agency;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        $faker = Faker::create();
        $image_files = File::files(base_path('__misc/dummy_images/exterior'));
        $agencyRole = Role::findByName('Agency');

        $specificUser = User::create([
            'name' => 'Dream Estate Agency',
            'email' => 'agency@dreamestate.com',
            'mobile_no' => $faker->numerify('##########'),
            'password' => bcrypt('password'),
        ]);
        $specificUser->assignRole($agencyRole);

        // Create the corresponding agency entry for the specific user
        $specificAgency = Agency::create([
            'id' => 1, // Explicitly set ID to 1
            'name' => $specificUser->name,
            'slug' => Str::slug($specificUser->name),
            'short_description' => $faker->realText(200),
            'description' => $faker->paragraphs(5, true),
            'phone' => $specificUser->mobile_no,
            'registered_agency_number'=>$faker->randomNumber(5),
            'email' => $specificUser->email,
            'user_id' => $specificUser->id,
            'website' => $faker->url,
            'created_by_id' => $specificUser->id,
            'modified_by_id' => $specificUser->id,
            'status' => 'pending',
        ]);

        // Create address for the specific agency
        $specificAgency->address()->create([
            'building_number' => $faker->buildingNumber(),
            'street' => $faker->streetName(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'country' => $faker->country(),
            'postal_code' => $faker->postcode(),
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
        ]);

        // Create meta content for the specific agency
        $specificAgency->metaContent()->create([
            'seo_title' => $specificUser->name,
            'seo_description' => $faker->realText(200),
            'seo_indexing' => $faker->boolean(75),
        ]);

        for ($i = 0; $i < 60; $i++) {
            // Create a new user
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'mobile_no' => $faker->numerify('##########'),
                'password' => bcrypt('password'),
            ]);
            $user->assignRole($agencyRole);
            $short_description=$faker->realText(200);

            $agency = Agency::create([
                'name' => $user->name,
                'slug' => Str::slug($user->name),
                'short_description' => $short_description,
                'description' => $faker->paragraphs(5, true),
                'phone' => $user->mobile_no,
                'email' => $user->email,
                'user_id' => $user->id,
                'website' => $faker->url,
                'registered_agency_number' => $faker->randomNumber(5),
                'created_by_id' => $user->id,
                'modified_by_id' => $user->id,
                'status' => 'pending',
            ]);

            $agency->address()->create([
                'building_number' => $faker->buildingNumber(),
                'street' => $faker->streetName(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'country' => $faker->country(),
                'postal_code' => $faker->postcode(),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
            ]);

            $agency->metaContent()->create([
                'seo_title' => $user->name,
                'seo_description' => $short_description,
                'seo_indexing' => $faker->boolean(75) ,
            ]);

            // $random_image_file = $faker->randomElement($image_files);
            // $agency->addMedia($random_image_file->getPathname())->preservingOriginal()->toMediaCollection('agents');
        }

    }
}
