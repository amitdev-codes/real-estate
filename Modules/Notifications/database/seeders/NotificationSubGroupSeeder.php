<?php
namespace Modules\Notifications\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notifications\Models\NotificationGroup;
use Modules\Notifications\Models\NotificationSubGroup;

class NotificationSubGroupSeeder extends Seeder
{
    public function run(): void
    {
        // Structure for all groups and their subgroups
        $groupSubgroups = [
            'enquiry' => [
                [
                    'name' => 'Property Enquiry',
                    'slug' => 'property-enquiry',
                    'icon' => 'mdi mdi-home-question',
                    'order' => 1,
                ],
                [
                    'name' => 'Rent Enquiry',
                    'slug' => 'rent-enquiry',
                    'icon' => 'mdi mdi-key-variant',
                    'order' => 2,
                ],
                [
                    'name' => 'Sale Enquiry',
                    'slug' => 'sale-enquiry',
                    'icon' => 'mdi mdi-currency-usd',
                    'order' => 3,
                ],
                [
                    'name' => 'Building Enquiry',
                    'slug' => 'building-enquiry',
                    'icon' => 'mdi mdi-office-building',
                    'order' => 4,
                ],
                [
                    'name' => 'Land Enquiry',
                    'slug' => 'land-enquiry',
                    'icon' => 'mdi mdi-map-marker',
                    'order' => 5,
                ],
                [
                    'name' => 'Price Guide',
                    'slug' => 'price-guide',
                    'icon' => 'mdi mdi-cash',
                    'order' => 6,
                ],
                [
                    'name' => 'Completion Date',
                    'slug' => 'completion-date',
                    'icon' => 'mdi mdi-calendar-check',
                    'order' => 7,
                ],
                [
                    'name' => 'Floor Plan',
                    'slug' => 'floor-plan',
                    'icon' => 'mdi mdi-floor-plan',
                    'order' => 8,
                ],
            ],
            'inspection' => [
                [
                    'name' => 'Property Inspection',
                    'slug' => 'property-inspection',
                    'icon' => 'mdi mdi-eye',
                    'order' => 1,
                ],
                [
                    'name' => 'Building Inspection',
                    'slug' => 'building-inspection',
                    'icon' => 'mdi mdi-hammer',
                    'order' => 2,
                ],
                [
                    'name' => 'Pest Inspection',
                    'slug' => 'pest-inspection',
                    'icon' => 'mdi mdi-bug',
                    'order' => 3,
                ],
                [
                    'name' => 'Final Inspection',
                    'slug' => 'final-inspection',
                    'icon' => 'mdi mdi-check-circle',
                    'order' => 4,
                ],
                [
                    'name' => 'Maintenance Inspection',
                    'slug' => 'maintenance-inspection',
                    'icon' => 'mdi mdi-tools',
                    'order' => 5,
                ],
            ],
            'contracts' => [
                [
                    'name' => 'Lease Agreement',
                    'slug' => 'lease-agreement',
                    'icon' => 'mdi mdi-file-document-edit',
                    'order' => 1,
                ],
                [
                    'name' => 'Sale Contract',
                    'slug' => 'sale-contract',
                    'icon' => 'mdi mdi-file-sign',
                    'order' => 2,
                ],
                [
                    'name' => 'Terms Update',
                    'slug' => 'terms-update',
                    'icon' => 'mdi mdi-file-refresh',
                    'order' => 3,
                ],
                [
                    'name' => 'Contract Extension',
                    'slug' => 'contract-extension',
                    'icon' => 'mdi mdi-file-plus',
                    'order' => 4,
                ],
                [
                    'name' => 'Contract Termination',
                    'slug' => 'contract-termination',
                    'icon' => 'mdi mdi-file-remove',
                    'order' => 5,
                ],
            ],
            'assistance' => [
                [
                    'name' => 'Technical Support',
                    'slug' => 'technical-support',
                    'icon' => 'mdi mdi-desktop-mac-dashboard',
                    'order' => 1,
                ],
                [
                    'name' => 'Maintenance Request',
                    'slug' => 'maintenance-request',
                    'icon' => 'mdi mdi-hammer-wrench',
                    'order' => 2,
                ],
                [
                    'name' => 'Emergency Assistance',
                    'slug' => 'emergency-assistance',
                    'icon' => 'mdi mdi-alert',
                    'order' => 3,
                ],
                [
                    'name' => 'General Help',
                    'slug' => 'general-help',
                    'icon' => 'mdi mdi-help-circle',
                    'order' => 4,
                ],
                [
                    'name' => 'Payment Assistance',
                    'slug' => 'payment-assistance',
                    'icon' => 'mdi mdi-credit-card-clock',
                    'order' => 5,
                ],
            ],
            'miscellaneous' => [
                [
                    'name' => 'System Updates',
                    'slug' => 'system-updates',
                    'icon' => 'mdi mdi-update',
                    'order' => 1,
                ],
                [
                    'name' => 'Announcements',
                    'slug' => 'announcements',
                    'icon' => 'mdi mdi-bullhorn',
                    'order' => 2,
                ],
                [
                    'name' => 'Feedback',
                    'slug' => 'feedback',
                    'icon' => 'mdi mdi-message-text',
                    'order' => 3,
                ],
                [
                    'name' => 'Reports',
                    'slug' => 'reports',
                    'icon' => 'mdi mdi-file-chart',
                    'order' => 4,
                ],
                [
                    'name' => 'Other',
                    'slug' => 'other',
                    'icon' => 'mdi mdi-dots-horizontal',
                    'order' => 5,
                ],
            ],
        ];

        // Create subgroups for each group
        foreach ($groupSubgroups as $groupSlug => $subgroups) {
            $group = NotificationGroup::where('slug', $groupSlug)->first();

            if ($group) {
                foreach ($subgroups as $subgroup) {
                    NotificationSubGroup::create([
                        'notification_group_id' => $group->id,
                        'name' => $subgroup['name'],
                        'slug' => $subgroup['slug'],
                        'icon' => $subgroup['icon'],
                        'order' => $subgroup['order'],
                    ]);
                }
            }
        }
    }
}
