<?php

namespace Database\Seeders;

use App\Models\PropertyLengthUnit;
use Illuminate\Database\Seeder;


class PropertyLengthUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $units = [
            // Length Units
            ['name' => 'Millimeter', 'symbol' => 'mm', 'description' => '1/1000th of a meter', 'conversion_rate' => 0.001, 'type' => 'length', 'order_no' => 1],
            ['name' => 'Centimeter', 'symbol' => 'cm', 'description' => '1/100th of a meter', 'conversion_rate' => 0.01, 'type' => 'length', 'order_no' => 2],
            ['name' => 'Meter', 'symbol' => 'm', 'description' => 'Base unit of length', 'conversion_rate' => 1, 'type' => 'length', 'order_no' => 3],
            ['name' => 'Kilometer', 'symbol' => 'km', 'description' => '1000 meters', 'conversion_rate' => 1000, 'type' => 'length', 'order_no' => 4],
            ['name' => 'Inch', 'symbol' => 'in', 'description' => '1/12th of a foot', 'conversion_rate' => 0.0254, 'type' => 'length', 'order_no' => 5],
            ['name' => 'Foot', 'symbol' => 'ft', 'description' => '12 inches', 'conversion_rate' => 0.3048, 'type' => 'length', 'order_no' => 6],
            ['name' => 'Yard', 'symbol' => 'yd', 'description' => '3 feet', 'conversion_rate' => 0.9144, 'type' => 'length', 'order_no' => 7],
            ['name' => 'Mile', 'symbol' => 'mi', 'description' => '5280 feet', 'conversion_rate' => 1609.344, 'type' => 'length', 'order_no' => 8],

            // Area Units
            ['name' => 'Square Millimeter', 'symbol' => 'mm²', 'description' => '1/1,000,000th of a square meter', 'conversion_rate' => 0.000001, 'type' => 'area', 'order_no' => 9],
            ['name' => 'Square Centimeter', 'symbol' => 'cm²', 'description' => '1/10,000th of a square meter', 'conversion_rate' => 0.0001, 'type' => 'area', 'order_no' => 10],
            ['name' => 'Square Meter', 'symbol' => 'm²', 'description' => 'Base unit of area', 'conversion_rate' => 1, 'type' => 'area', 'order_no' => 11],
            ['name' => 'Hectare', 'symbol' => 'ha', 'description' => '10,000 square meters', 'conversion_rate' => 10000, 'type' => 'area', 'order_no' => 12],
            ['name' => 'Square Kilometer', 'symbol' => 'km²', 'description' => '1,000,000 square meters', 'conversion_rate' => 1000000, 'type' => 'area', 'order_no' => 13],
            ['name' => 'Square Inch', 'symbol' => 'in²', 'description' => '1/144th of a square foot', 'conversion_rate' => 0.000645, 'type' => 'area', 'order_no' => 14],
            ['name' => 'Square Foot', 'symbol' => 'ft²', 'description' => '144 square inches', 'conversion_rate' => 0.092903, 'type' => 'area', 'order_no' => 15],
            ['name' => 'Square Yard', 'symbol' => 'yd²', 'description' => '9 square feet', 'conversion_rate' => 0.836127, 'type' => 'area', 'order_no' => 16],
            ['name' => 'Acre', 'symbol' => 'ac', 'description' => '4840 square yards', 'conversion_rate' => 4046.856, 'type' => 'area', 'order_no' => 17],
            ['name' => 'Square Mile', 'symbol' => 'mi²', 'description' => '640 acres', 'conversion_rate' => 22589988.110336, 'type' => 'area', 'order_no' => 18],
        ];

        foreach ($units as $unit) {
            PropertyLengthUnit::create($unit);
        }
    }
}
