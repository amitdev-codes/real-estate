<?php

namespace Modules\Notifications\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Notifications\Models\NotificationGroup;
use Modules\Notifications\Models\NotificationSubGroup;


class NotificationGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Enquiry',
                'slug' => 'enquiry',
                'icon' => 'mdi mdi-help-circle',
                'order' => 1,
            ],
            [
                'name' => 'Inspection',
                'slug' => 'inspection',
                'icon' => 'mdi mdi-magnify',
                'order' => 2,
            ],
            [
                'name' => 'Contracts',
                'slug' => 'contracts',
                'icon' => 'mdi mdi-file-document',
                'order' => 3,
            ],
            [
                'name' => 'Assistance',
                'slug' => 'assistance',
                'icon' => ' mdi mdi-account-question',
                'order' => 4,
            ],
            [
                'name' => 'Miscellaneous',
                'slug' => 'miscellaneous',
                'icon' => 'mdi mdi-dots-horizontal',
                'order' => 5,
            ],
        ];

        foreach ($groups as $group) {
            NotificationGroup::create($group);
        }
    }
}
