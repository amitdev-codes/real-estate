<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// database/seeders/NotificationTemplateSeeder.php
class NotificationTemplateSeeder extends Seeder
{
    public function run()
    {
        NotificationTemplate::create([
            'type' => 'agent_status_update',
            'title' => 'Agent Status Update',
            'template' => 'Agent {{name}} has requested a status update. Please review.'
        ]);

        NotificationTemplate::create([
            'type' => 'agent_rejected',
            'title' => 'Agent Status Rejected',
            'template' => 'Your agent application for {{name}} has been rejected. Reason: {{remarks}}'
        ]);
    }
}
