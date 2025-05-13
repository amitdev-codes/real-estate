<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationGroupsSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            [
                'name' => 'Agent Inquiries',
                'slug' => 'agent-inquiries',
                'role' => 'agent',
                'type' => 'inquiry',
                'icon' => 'mdi mdi-account-question'
            ],
            [
                'name' => 'Agency Contracts',
                'slug' => 'agency-contracts',
                'role' => 'agency',
                'type' => 'contract',
                'icon' => 'mdi mdi-file-document'
            ],
            [
                'name' => 'Property Inspections',
                'slug' => 'property-inspections',
                'role' => 'user',
                'type' => 'inspection',
                'icon' => 'mdi mdi-home-search'
            ],
        ];

        foreach ($groups as $group) {
            NotificationGroup::create($group);
        }
    }
}
