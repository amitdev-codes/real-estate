<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\NearbyFacility;

class NearbyFacilitySeeder extends Seeder
{
    public function run(): void
    {
        // $this->call([]);

        $facilities = [
            [
                "name" => "School",
                "icon" => "school",
                "slug" => "school",
                "description" => "A nearby educational institution offering various academic programs.",
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                "name" => "Train Station",
                "icon" => "train",
                "slug" => "train-station",
                "description" => "Convenient access to public transportation via the nearby train station.",
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                "name" => "Hospital",
                "icon" => "hospital",
                "slug" => "hospital",
                "description" => "A nearby hospital offering emergency and medical services.",
                'order_no' => 3,
                'is_active' => true,
            ],
            [
                "name" => "Shopping Mall",
                "icon" => "shopping",
                "slug" => "shopping-mall",
                "description" => "A large retail space offering a variety of stores and dining options.",
                'order_no' => 4,
                'is_active' => true,
            ],
            [
                "name" => "Supermarket",
                "icon" => "cart",
                "slug" => "supermarket",
                "description" => "A nearby supermarket providing fresh groceries and daily essentials.",
                'order_no' => 5,
                'is_active' => true,
            ],
            [
                "name" => "Bank",
                "icon" => "bank",
                "slug" => "bank",
                "description" => "A nearby bank offering financial services, including ATMs and branches.",
                'order_no' => 6,
                'is_active' => true,
            ],
            [
                "name" => "Bus Station",
                "icon" => "bus",
                "slug" => "bus-station",
                "description" => "A public bus station for easy access to local and regional transport routes.",
                'order_no' => 7,
                'is_active' => true,
            ],
            [
                "name" => "Park",
                "icon" => "tree",
                "slug" => "park",
                "description" => "A nearby green park for relaxation, jogging, and outdoor activities.",
                'order_no' => 8,
                'is_active' => true,
            ],
            [
                "name" => "Gas Station",
                "icon" => "gas-station",
                "slug" => "gas-station",
                "description" => "A nearby gas station for refueling vehicles.",
                'order_no' => 9,
                'is_active' => true,
            ],
            [
                "name" => "Pharmacy",
                "icon" => "pill",
                "slug" => "pharmacy",
                "description" => "A pharmacy providing prescription and over-the-counter medication.",
                'order_no' => 10,
                'is_active' => true,
            ],
            [
                "name" => "Airport",
                "icon" => "airplane",
                "slug" => "airport",
                "description" => "A nearby international airport providing domestic and international flights.",
                'order_no' => 11,
                'is_active' => true,
            ],
            [
                "name" => "Cinema",
                "icon" => "filmstrip",
                "slug" => "cinema",
                "description" => "A nearby cinema offering the latest movies in various genres.",
                'order_no' => 12,
                'is_active' => true,
            ],
            [
                "name" => "Restaurant",
                "icon" => "food",
                "slug" => "restaurant",
                "description" => "A nearby restaurant offering a variety of cuisines and dining experiences.",
                'order_no' => 13,
                'is_active' => true,
            ],
            [
                "name" => "Library",
                "icon" => "library",
                "slug" => "library",
                "description" => "A quiet public library offering books, study areas, and events.",
                'order_no' => 14,
                'is_active' => true,
            ],
            [
                "name" => "Fitness Center",
                "icon" => "run",
                "slug" => "fitness-center",
                "description" => "A gym and fitness center offering various workout and fitness programs.",
                'order_no' => 15,
                'is_active' => true,
            ],
            [
                "name" => "Post Office",
                "icon" => "post",
                "slug" => "post-office",
                "description" => "A nearby post office for mailing services and packages.",
                'order_no' => 16,
                'is_active' => true,
            ],
            [
                "name" => "Police Station",
                "icon" => "police",
                "slug" => "police-badge",
                "description" => "A nearby police station ensuring safety and law enforcement.",
                'order_no' => 17,
                'is_active' => true,
            ],
            [
                "name" => "Church",
                "icon" => "church",
                "slug" => "church",
                "description" => "A nearby church offering religious services and community events.",
                'order_no' => 18,
                'is_active' => true,
            ],
            [
                "name" => "Hotel",
                "icon" => "silverware-fork-knife",
                "slug" => "hotel",
                "description" => "A nearby hotel offering accommodation for travelers and guests.",
                'order_no' => 19,
                'is_active' => true,
            ],
            [
                "name" => "University",
                "icon" => "school",
                "slug" => "university",
                "description" => "A nearby university offering higher education and research opportunities.",
                'order_no' => 20,
                'is_active' => true,
            ],
        ];

        // DB::table('nearby_facilities')->insert($facilities);

        foreach ($facilities as $facility){
            NearbyFacility::create($facility);
        }
    }
}
