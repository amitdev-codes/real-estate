<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\NotificationGroup;
use Spatie\Permission\Models\Role;
use App\Services\NotificationService;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $notificationService = app(NotificationService::class);
        $admin = Role::where('name', 'Admin')->first();

        // Generate inquiries from agents
        $inquiryMessages = [
            'New property inquiry received',
            'Client requesting property details',
            'Showing request for property'
        ];

        foreach (range(1, 5) as $index) {
            $notificationService->createNotification(
                'agent-inquiries',
                'inquiry',
                $admin,
                $faker->randomElement($inquiryMessages),
                $faker->paragraph,
                ['property_id' => $faker->numberBetween(1, 100)]
            );
        }

        // Generate contract notifications from agencies
        $contractMessages = [
            'New contract pending approval',
            'Contract updated by agency',
            'Contract review requested'
        ];

        foreach (range(1, 3) as $index) {
            $notificationService->createNotification(
                'agency-contracts',
                'contract',
                $admin,
                $faker->randomElement($contractMessages),
                $faker->paragraph,
                ['contract_id' => $faker->numberBetween(1, 50)]
            );
        }

        // Generate inspection notifications from users
        $inspectionMessages = [
            'Inspection scheduled',
            'Inspection report available',
            'Property inspection request'
        ];

        foreach (range(1, 4) as $index) {
            $notificationService->createNotification(
                'property-inspections',
                'inspection',
                $admin,
                $faker->randomElement($inspectionMessages),
                $faker->paragraph,
                ['inspection_id' => $faker->numberBetween(1, 30)]
            );
        }
    }
}
