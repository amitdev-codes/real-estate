<?php

namespace Modules\Agent\Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $image_files = File::files(base_path('__misc/dummy_images/users'));
        $agency_ids = Agency::pluck('id')->toArray();
        $agentRole = Role::findByName('Agent');
        $agencies=Agency::all();

                // Create a specific user with email 'agent@dreamestate.com'
        $specificUser = User::create(['name' => 'Dream Estate Agent','email' => 'agent@dreamestate.com','mobile_no' => $faker->numerify('##########'),'password' => bcrypt('password')]);
        $specificUser->assignRole($agentRole);

                // Create the corresponding agent entry for the specific user
        Agent::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'short_description' => $faker->sentence,
            'description' => $faker->paragraph,
            'user_id' => $specificUser->id,
            'agency_id' => 1, // Assigning to agency_id = 1
            'license_number' => $faker->unique()->numerify('LIC########'),
            'email' => $specificUser->email,
            'website' => $faker->url,
            'phone' => $specificUser->mobile_no,
            'status' => 'pending',
            'specializations' => json_encode(['Residential', 'Commercial']),
            'primary_area' => $faker->city,
            'additional_areas' => json_encode([$faker->city, $faker->city]),
            'experience' => $faker->numberBetween(1, 20),
        ]);

                // Create address for the specific agent
        $agent = Agent::where('user_id', $specificUser->id)->first(); // Retrieve the created agent

        $agent->address()->create([
            'building_number' => $faker->buildingNumber(),
            'street' => $faker->streetName(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'country' => $faker->country(),
            'postal_code' => $faker->postcode(),
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
            ]);

                // Create meta content for the specific agent
        $agent->metaContent()->create(['seo_title' => $specificUser->name,'seo_description' => $faker->sentence,'seo_indexing' => $faker->boolean(75)]);

        $this->createPersonalInformation($specificUser, $faker);
            for ($i = 0; $i < 60; $i++) {
                // Create a new user
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'mobile_no' => $faker->numerify('##########'),
                    'password' => bcrypt('password'),
                ]);
                $user->assignRole($agentRole);

                // Create a corresponding agent entry
                $agency = $agencies->random(); // Assign random agency
                $agent=Agent::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'short_description' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'user_id' => $user->id,
                    'agency_id' => $agency->id,
                    'license_number' => $faker->unique()->numerify('LIC########'),
                    'email' => $user->email,
                    'website' => $faker->url,
                    'phone' => $user->mobile_no,
                    'status' => 'pending',
                    'specializations' => json_encode(['Residential', 'Commercial']),
                    'primary_area' => $faker->city,
                    'additional_areas' => json_encode([$faker->city, $faker->city]),
                    'experience' => $faker->numberBetween(1, 20),
                ]);

                $agent->address()->create([
                    'building_number' => $faker->buildingNumber(),
                    'street' => $faker->streetName(),
                    'city' => $faker->city(),
                    'state' => $faker->state(),
                    'country' => $faker->country(),
                    'postal_code' => $faker->postcode(),
                    'latitude' => $faker->latitude(),
                    'longitude' => $faker->longitude(),
                ]);

                $agent->metaContent()->create([
                    'seo_title' => $user->name,
                    'seo_description' => $faker->sentence,
                    'seo_indexing' => $faker->boolean(75),
                ]);
                $this->createPersonalInformation($user, $faker);
            }
    }
    private function createPersonalInformation($user, $faker): void
    {
        $user->personalInformation()->create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'date_of_birth' => $faker->date('Y-m-d', '2000-01-01'),
            'website' => $faker->url,
            'business_phone_number' => $faker->phoneNumber,
            'business_email' => $faker->unique()->safeEmail,
            'bio' => $faker->paragraphs(3, true),
        ]);
    }
}
