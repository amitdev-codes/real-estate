<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\PropertyFeature;

class PropertyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        $features = [
            [
                "name" => "Swimming Pool",
                "icon" => "pool",
                "slug" => "swimming-pool",
                "description" => "A refreshing swimming pool for leisure and fitness activities.",
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                "name" => "Gym",
                "icon" => "dumbbell",
                "slug" => "gym",
                "description" => "A fully equipped gym to keep you fit and healthy.",
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                "name" => "CCTV",
                "icon" => "cctv",
                "slug" => "cctv",
                "description" => "Advanced CCTV systems for enhanced security.",
                'order_no' => 3,
                'is_active' => true,
            ],
            [
                "name" => "Parking",
                "icon" => "parking",
                "slug" => "parking",
                "description" => "Secure parking spaces for your vehicles.",
                'order_no' => 4,
                'is_active' => true,
            ],
            [
                "name" => "Security",
                "icon" => "security",
                "slug" => "security",
                "description" => "24/7 security to ensure your safety and peace of mind.",
                'order_no' => 5,
                'is_active' => true,
            ],
            [
                "name" => "Balcony",
                "icon" => "balcony",
                "slug" => "balcony",
                "description" => "Private balconies with beautiful views.",
                'order_no' => 6,
                'is_active' => true,
            ],
            [
                "name" => "WiFi",
                "icon" => "wifi",
                "slug" => "wifi",
                "description" => "High-speed wireless internet connectivity.",
                'order_no' => 7,
                'is_active' => true,
            ],
            [
                "name" => "Garden",
                "icon" => "flower",
                "slug" => "garden",
                "description" => "Well-maintained gardens to relax and unwind.",
                'order_no' => 8,
                'is_active' => true,
            ],
            [
                "name" => "Central Heating",
                "icon" => "radiator",
                "slug" => "central-heating",
                "description" => "Central heating system for comfortable indoor temperatures.",
                'order_no' => 9,
                'is_active' => true,
            ],
            [
                "name" => "Full Furnished",
                "icon" => "sofa",
                "slug" => "full-furnished",
                "description" => "Fully furnished homes for a hassle-free living experience.",
                'order_no' => 10,
                'is_active' => true,
            ],
            [
                "name" => "Semi Furnished",
                "icon" => "bed",
                "slug" => "semi-furnished",
                "description" => "Semi-furnished homes with essential fittings.",
                'order_no' => 11,
                'is_active' => true,
            ],
            [
                "name" => "Pets Allowed",
                "icon" => "paw",
                "slug" => "pets-allowed",
                "description" => "Pet-friendly environment to accommodate your furry friends.",
                'order_no' => 12,
                'is_active' => true,
            ],
            [
                "name" => "Cafeteria",
                "icon" => "coffee",
                "slug" => "cafeteria",
                "description" => "Cafeteria offering food and beverages for residents.",
                'order_no' => 13,
                'is_active' => true,
            ],
            [
                "name" => "Fitness Center",
                "icon" => "run",
                "slug" => "fitness-center",
                "description" => "Modern fitness center for all your workout needs.",
                'order_no' => 14,
                'is_active' => true,
            ],
            [
                "name" => "Air Conditioning",
                "icon" => "air-conditioner",
                "slug" => "air-conditioning",
                "description" => "Air-conditioned rooms for a pleasant living experience.",
                'order_no' => 15,
                'is_active' => true,
            ],
            [
                "name" => "Spa and Massage",
                "icon" => "spa",
                "slug" => "spa-and-massage",
                "description" => "Luxurious spa and massage services for relaxation.",
                'order_no' => 16,
                'is_active' => true,
            ],
            [
                "name" => "Laundry Room",
                "icon" => "washing-machine",
                "slug" => "laundry-room",
                "description" => "Dedicated laundry room with washing facilities.",
                'order_no' => 17,
                'is_active' => true,
            ],
        ];        

        foreach ($features as $feature) {
            PropertyFeature::create($feature);
        }
    }
}
