<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        // Define roles
        $roles = [
            'SuperAdmin' => ['name' => 'SuperAdmin', 'email' => 'superadmin@dreamestate.com'],
            'Admin' => ['name' => 'Admin', 'email' => 'admin@dreamestate.com'],
            'User' => [
                ['name' => 'testUser', 'email' => 'testUser@dreamestate.com', 'mobile_no' => '253699874558'],
                ['name' => 'testUser5', 'email' => 'testUser55@dreamestate.com', 'mobile_no' => '253699836558'],
                ['name' => 'testUser66', 'email' => 'testUser66@dreamestate.com', 'mobile_no' => '253699874898'],
                ['name' => 'testUser8', 'email' => 'tstuser8@dreamestate.com', 'mobile_no' => '363699874898'],
            ],
        ];
        
        // Create SuperAdmin and Admin users
        foreach (['SuperAdmin', 'Admin'] as $roleName) {
            $user = User::create([
                'name' => $roles[$roleName]['name'],
                'email' => $roles[$roleName]['email'],
                'mobile_no' => '253699874558',
                'password' => bcrypt('password')
            ]);
            
            $user->assignRole(Role::findByName($roleName));
            
            // Create address for admin users too
            $this->createAddress($user, $faker);
            $this->createPersonalInformation($user, $faker);
        }
        
        // Create regular users
        foreach ($roles['User'] as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'mobile_no' => $userData['mobile_no'],
                'password' => bcrypt('password')
            ]);
            
            $user->assignRole(Role::findByName('User'));
            
            // Create address for each user
            $this->createAddress($user, $faker);
            $this->createPersonalInformation($user, $faker);
        }
        
        // You can add Agent and Agency role users here if needed
        // Example:
        // $this->createUsersWithRole('Agent', 5, $faker);
        // $this->createUsersWithRole('Agency', 3, $faker);
    }
    
    /**
     * Create an address for a user
     */
    private function createAddress($user, $faker): void
    {
        $user->address()->create([
            'building_number' => $faker->buildingNumber(),
            'street' => $faker->streetName(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'country' => $faker->country(),
            'postal_code' => $faker->postcode(),
            'latitude' => $faker->latitude($min = -90, $max = 90),
            'longitude' => $faker->longitude($min = -180, $max = 180),
        ]);
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
    
    /**
     * Create multiple users with the same role
     */
    private function createUsersWithRole($roleName, $count, $faker): void
    {
        for ($i = 0; $i < $count; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'mobile_no' => $faker->numerify('##########'),
                'password' => bcrypt('password')
            ]);
            
            $user->assignRole(Role::findByName($roleName));
            $this->createAddress($user, $faker);
            $this->createPersonalInformation($user, $faker);
        }
    }
}