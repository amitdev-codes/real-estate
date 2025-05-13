<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Modules\Property\Models\PropertyCategory;

class PropertyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        // Insert parent categories
        $categories = [
            ['id' => 1, 'name' => 'Buy', 'slug' => 'buy', 'description' => null,'order_no' => 1,],
            ['id' => 2, 'name' => 'Rent', 'slug' => 'rent', 'description' => null,'order_no' => 2,],
            ['id' => 3, 'name' => 'Home & Land', 'slug' => 'home-and-land', 'description' => null,'order_no' => 3,],
            ['id' => 4, 'name' => 'Sold', 'slug' => 'sold', 'description' => null,'order_no' => 4,],
            ['id' => 5, 'name' => 'Apartment', 'slug' => 'apartment', 'description' => null,'order_no' => 5,],
            ['id' => 6, 'name' => 'Villa', 'slug' => 'villa', 'description' => null,'order_no' => 6,],
            ['id' => 7, 'name' => 'Condo', 'slug' => 'condo', 'description' => null,'order_no' => 7,],
            ['id' => 8, 'name' => 'House', 'slug' => 'house', 'description' => null,'order_no' => 8,],
            ['id' => 9, 'name' => 'Land', 'slug' => 'land', 'description' => null,'order_no' => 9,],
        ];

        DB::table('property_categories')->insert($categories);

        // Insert relationships
        $relationships = [
            // Rent -> children
            ['parent_id' => 1, 'child_id' => 4],
            ['parent_id' => 1, 'child_id' => 5],
            ['parent_id' => 1, 'child_id' => 6],
            ['parent_id' => 1, 'child_id' => 7],
            ['parent_id' => 1, 'child_id' => 8],

            // Sold -> children
            ['parent_id' => 3, 'child_id' => 4],
            ['parent_id' => 3, 'child_id' => 5],
            ['parent_id' => 3, 'child_id' => 6],
            ['parent_id' => 3, 'child_id' => 7],
            ['parent_id' => 3, 'child_id' => 8],
        ];

        DB::table('category_relationships')->insert($relationships);
    }
}
