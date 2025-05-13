<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $property_types = [
            [
                'name' => 'House',
                'slug' => 'house',
                'icon' => 'home',
                'description' => 'A standalone residential building.',
                'order_no' => 1,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Duplex',
                'slug' => 'duplex',
                'icon' => 'home-modern',
                'description' => 'A residential building divided into two separate units.',
                'order_no' => 2,
                'is_active' => true,
                'parent_id' => 1,
            ],
            [
                'name' => 'Full Furnished Duplex',
                'slug' => 'full-furnished-duplex',
                'icon' => 'sofa',
                'description' => 'A duplex that is fully equipped with furniture and appliances.',
                'order_no' => 3,
                'is_active' => true,
                'parent_id' => 2,
            ],
            [
                'name' => 'Semi Furnished Duplex',
                'slug' => 'semi-furnished-duplex',
                'icon' => 'sofa-outline',
                'description' => 'A duplex that is partially equipped with furniture and appliances.',
                'order_no' => 4,
                'is_active' => true,
                'parent_id' => 2,
            ],
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'icon' => 'home-city',
                'description' => 'A luxurious standalone house, often with a garden.',
                'order_no' => 5,
                'is_active' => true,
                'parent_id' => 1,
            ],
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'icon' => 'office-building',
                'description' => 'A residential unit in a building with multiple units.',
                'order_no' => 6,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Penthouse',
                'slug' => 'penthouse',
                'icon' => 'home-roof',
                'description' => 'A luxury apartment on the top floor of a building.',
                'order_no' => 7,
                'is_active' => true,
                'parent_id' => 6,
            ],
            [
                'name' => 'Studio',
                'slug' => 'studio',
                'icon' => 'palette',
                'description' => 'A small apartment with an open floor plan.',
                'order_no' => 8,
                'is_active' => true,
                'parent_id' => 6,
            ],
            [
                'name' => 'Land',
                'slug' => 'land',
                'icon' => 'map',
                'description' => 'A parcel of land available for purchase or development.',
                'order_no' => 9,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'New Land',
                'slug' => 'new-land',
                'icon' => 'map-outline',
                'description' => 'Recently available land for purchase.',
                'order_no' => 10,
                'is_active' => true,
                'parent_id' => 9,
            ],
            [
                'name' => 'Development Site',
                'slug' => 'development-site',
                'icon' => 'crane',
                'description' => 'Land designated for construction and development.',
                'order_no' => 11,
                'is_active' => true,
                'parent_id' => 9,
            ],
            [
                'name' => 'Vacant Land',
                'slug' => 'vacant-land',
                'icon' => 'map-marker',
                'description' => 'Unused or empty land available for sale.',
                'order_no' => 12,
                'is_active' => true,
                'parent_id' => 9,
            ],
            [
                'name' => 'Factory',
                'slug' => 'factory',
                'icon' => 'factory',
                'description' => 'A building or site used for industrial production.',
                'order_no' => 13,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'icon' => 'bed-outline',
                'description' => 'A commercial establishment offering lodging and amenities.',
                'order_no' => 14,
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'icon' => 'silverware-fork-knife',
                'description' => 'An establishment where meals are prepared and served to customers.',
                'order_no' => 15,
                'is_active' => true,
                'parent_id' => null,
            ],
        ];

        foreach ($property_types as $type) {
            PropertyType::create($type);
        }
    }
}
