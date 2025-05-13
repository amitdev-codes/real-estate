<?php

namespace Modules\Notifications\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Agency\Models\Agency;
use Modules\Agent\Models\Agent;
use Modules\Notifications\Models\Notification;
use Modules\Notifications\Models\NotificationGroup;
use Modules\Notifications\Models\NotificationSubGroup;
use Modules\Property\Models\Property;
use Spatie\Permission\Models\Role;

class NotificationSeeder extends Seeder
{
    protected $roleMap = [
        'guest' => 'Guest',
        'user' => 'User',
        'agent' => 'Agent',
        'admin' => 'Admin',
        'superadmin' => 'SuperAdmin',
        'agency' => 'Agency',
    ];

    protected function getRole(string $roleName): ?Role
    {
        $standardName = $this->roleMap[strtolower($roleName)] ?? $roleName;

        return Role::where('name', $standardName)->first();
    }

    public function run(): void
    {
        // Get necessary data
        $users = User::all();
        $properties = Property::all();
        $groups = NotificationGroup::all();
        $subGroups = NotificationSubGroup::all();

        // Get roles
        $roles = collect([
            $this->getRole('guest'),
            $this->getRole('user'),
            $this->getRole('agent'),
            $this->getRole('admin'),
            $this->getRole('superadmin'),
            $this->getRole('agency'),
        ])->filter();

        // Sample morphable models with role mapping
        $morphableTypes = [
            User::class => [
                'models' => User::all(),
                'roles' => ['User', 'Admin', 'SuperAdmin'],
            ],
            Agent::class => [
                'models' => Agent::all(),
                'roles' => ['Agent'],
            ],
            Agency::class => [
                'models' => Agency::all(),
                'roles' => ['Agency'],
            ],
        ];

        // Create 50 sample notifications
        for ($i = 0; $i < 50; $i++) {
            // Select random role
            $role = $roles->random();

            // Select appropriate morphable type based on role
            $validMorphTypes = array_filter($morphableTypes, function ($type) use ($role) {
                return in_array($role->name, $type['roles']);
            });

            $morphType = ! empty($validMorphTypes) ? array_rand($validMorphTypes) : null;
            $morphModel = null;

            if ($morphType && ! empty($validMorphTypes[$morphType]['models'])) {
                $morphModels = $validMorphTypes[$morphType]['models'];
                $morphModel = $morphModels->isNotEmpty() ? $morphModels->random() : null;
            }

            // Random property
            $property = $properties->random();

            // Random groups and subgroups
            $group = $groups->random();
            $relevantSubGroups = $subGroups->where('notification_group_id', $group->id);
            $selectedSubGroup = $relevantSubGroups->random();

            // Get a random user with the selected role
            $receiver = User::role($role->name)->inRandomOrder()->first();

            // Randomly set read_at and replied_at
            $readAt = fake()->boolean(50) ? now() : null;
            $repliedAt = fake()->boolean(20) ? now() : null;
            $repliedBy = $repliedAt ? 1 : null;

            Notification::create([
                'message' => "Sample message for {$role->name}",
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber(),
                'postcode' => fake()->postcode(),
                'notification_group_id' => $group->id,
                'notification_sub_group_ids' => json_encode([$selectedSubGroup->id]), // Encode as JSON
                'property_id' => $property->id,
                'notifiable_type' => $morphModel ? $morphType : 'App\Models\User',
                'notifiable_id' => $morphModel ? $morphModel->id : '1',
                'data' => json_encode([ // Encode as JSON
                    'browser' => fake()->userAgent(),
                    'ip' => fake()->ipv4(),
                    'source' => fake()->randomElement(['website', 'mobile_app', 'portal', 'direct']),
                    'role_name' => $role->name, // Store original role name for reference
                ]),
                'read_at' => $readAt,
                'reply' => $repliedAt ? fake()->sentence() : null,
                'replied_at' => $repliedAt,
                'replied_by' => $repliedBy,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create urgent notifications for Agents
        $urgentMessages = [
            'URGENT: Building inspection required immediately.',
            'URGENT: Tenant reported gas leak.',
            'URGENT: Property security breach reported.',
            'URGENT: Council compliance issue.',
            'URGENT: Insurance claim requires documentation.',
        ];

        $agentRole = $this->getRole('agent');

        foreach ($urgentMessages as $message) {
            $agent = Agent::inRandomOrder()->first();

            if ($agentRole && $agent) {
                Notification::create([
                    'message' => $message,
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'email' => fake()->email(),
                    'phone' => fake()->phoneNumber(),
                    'postcode' => fake()->postcode(),
                    'notification_group_id' => $groups->where('slug', 'assistance')->first()->id,
                    'notification_sub_group_ids' => json_encode([$subGroups->where('slug', 'property-enquiry')->first()->id]), // Encode as JSON
                    'property_id' => $properties->random()->id,
                    'notifiable_type' => Agent::class,
                    'notifiable_id' => $agent->id,
                    'data' => json_encode([ // Encode as JSON
                        'priority' => 'high',
                        'requires_immediate_action' => true,
                        'source' => 'system_alert',
                        'role_name' => $agentRole->name,
                    ]),
                    'created_at' => now()->subHours(rand(1, 24)),
                    'updated_at' => now()->subHours(rand(1, 24)),
                ]);
            }
        }

        // Create system notifications for Admin/SuperAdmin
        $systemMessages = [
            'System maintenance scheduled.',
            'New property listing guidelines updated.',
            'Contact information update required.',
            'Photography updates needed for listings.',
            'Monthly performance reports available.',
        ];

        $adminRole = $this->getRole('admin');

        foreach ($systemMessages as $message) {
            $admin = User::role('Admin')->inRandomOrder()->first();

            if ($adminRole && $admin) {
                Notification::create([
                    'message' => $message,
                    'notification_group_id' => $groups->where('slug', 'miscellaneous')->first()->id,
                    'notifiable_type' => User::class,
                    'notifiable_id' => $admin->id,
                    'data' => json_encode([ // Encode as JSON
                        'type' => 'system_notification',
                        'source' => 'system',
                        'auto_generated' => true,
                        'role_name' => $adminRole->name,
                    ]),
                    'created_at' => now()->subDays(rand(1, 7)),
                    'updated_at' => now()->subDays(rand(1, 7)),
                ]);
            }
        }
    }
}
