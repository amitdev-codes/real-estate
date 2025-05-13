<?php

namespace Modules\Property\Database\Seeders;

use App\Models\PropertyLengthUnit;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Agent\Models\Agent;
use Modules\Property\Models\NearbyFacility;
use Modules\Property\Models\NearbyFacilityPropertyDistance;
use Modules\Property\Models\Project;
use Modules\Property\Models\Property;
use Modules\Property\Models\PropertyCategory;
use Modules\Property\Models\PropertyFacilitiesDistance;
use Modules\Property\Models\PropertyFeature;
use Modules\Property\Models\PropertyPurpose;
use Modules\Property\Models\PropertyStatus;
use Modules\Property\Models\PropertyType;
use Spatie\Permission\Models\Role;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        $fake_records_no = 50;

        $faker = Faker::create();

        $agent_ids = Agent::pluck('id')->toArray();
        $project_ids = Project::pluck('id')->toArray();
        $property_status_ids = PropertyStatus::pluck('id')->toArray();
        $features_data = PropertyFeature::all();
        $length_units = PropertyLengthUnit::where('type', 'length')->select('id', 'conversion_rate')->get();
        $area_units = PropertyLengthUnit::where('type', 'area')->select('id', 'conversion_rate')->get();

        $property_type_ids = PropertyType::pluck('id')->toArray();

        $nearby_facilities = NearbyFacility::all();

        $hero_image_files = File::files(base_path('__misc/dummy_images/exterior'));
        $gallery_image_files = File::files(base_path('__misc/dummy_images/interior'));

        foreach (range(1, $fake_records_no) as $index) {
            $title = $faker->company;
            $slug = Str::slug($title);
            $short_description = $faker->realText(200);

            

            $random_area_unit = $faker->randomElement($area_units);
            $area = $faker->numberBetween(50, 2000);
            $unit_id = $random_area_unit->id ;
            $total_area_in_m2 = $area * $random_area_unit->id;

            $base_price = $faker->numberBetween(100000, 10000000);
            $offer_price = $faker->optional(0.4, $base_price)->numberBetween(
                (int) ($base_price * 0.85),
                (int) ($base_price * 0.98)
            );


            $features = $features_data
                ->random($faker->numberBetween(6, 10))
                ->pluck('id')->toArray();

            $custom_fields = collect(range(1, $faker->numberBetween(2, 6)))
                ->map(function() use ($faker) {
                    return [
                        'field_title' => $faker->word(),
                        'field_value' => $faker->words(2, true)
                    ];
                })
                ->values()
                ->toArray();


            $publish_start_date = $faker->dateTimeBetween('-2 years', '+2 months');
            $publish_end_date = $faker->optional(0.2)->dateTimeBetween($publish_start_date, '+1 years');

            $end_date = $publish_end_date ?? (clone $publish_start_date)->modify('+1 year');
            $property_availability_date = $faker->dateTimeBetween($publish_start_date, $end_date);

            $agent_id = $faker->randomElement($agent_ids);
            $created_by_id = $agent_id;
            $modified_by_id = $faker->boolean() ? $agent_id : null;

            $property = Property::create([
                'title' => $title,
                'slug' => $slug,
                'short_description' => $short_description,
                'description' => $faker->paragraphs(10, true),
                'private_notes' => $faker->optional(0.4)->realText(200),

                'visits' => $faker->numberBetween(10, 1000),

                'bedrooms' => $faker->numberBetween(1, 10),
                'bathrooms' => $faker->numberBetween(1, 5),
                'floors' => $faker->numberBetween(1, 5),
                'parkings' => $faker->numberBetween(0, 3),

                'area' => $area,
                'unit_id' => $unit_id,
                'total_area_in_m2' => $total_area_in_m2,

                'base_price' => $base_price,
                'offer_price' => $offer_price,

                'project_id' => $faker->optional(0.4)->randomElement($project_ids),
                'property_status_id' => $faker->randomElement($property_status_ids),
                'construction_type' => $faker->randomElement(['New Construction', 'Established Property']),

                'features' => $features,
                'custom_fields' => $custom_fields,

                'video_link' => $faker->url(),

                'property_availability_date' => $property_availability_date,
                'publish_start_date' => $publish_start_date,
                'publish_end_date' => $publish_end_date,

                'is_featured' => $faker->boolean(90),
                'is_published' => $faker->boolean(80),
                'is_active' => $faker->boolean(90),
                'has_ads' => $faker->boolean(50),

                'moderation_status' => $faker->randomElement(['pending', 'rejected', 'approved']),
                'agent_id' =>$faker->randomElement($agent_ids),
                'created_by_id' => $created_by_id,
                'modified_by_id' => $modified_by_id,
            ]);
            
            $property->propertyTypes()->sync($faker->randomElements($property_type_ids, $faker->numberBetween(2, 5)));

            $facilities_distance_entries_count = rand(0, 10);

            $nearby_facilities->random($facilities_distance_entries_count)->each(function ($facility) use ($property, $length_units, $faker) {
                $distance =  rand(50, 5000);
                $random_unit = $faker->randomElement($length_units);
                $unit_id = $random_unit->id;
                $total_area_in_m = $distance * $random_unit->conversion_rate;
                
                NearbyFacilityPropertyDistance::create([
                    'property_id' => $property->id,
                    'nearby_facility_id' => $facility->id,
                    'distance' => $distance,
                    'unit_id' => $unit_id,
                    'total_area_in_m' => $total_area_in_m
                ]);
            });

            $property->address()->create([
                'building_number' => $faker->buildingNumber(),
                'street' => $faker->streetName(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'country' => $faker->country(),
                'postal_code' => $faker->postcode(),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
            ]);            

            $property->metaContent()->create([
                'seo_title' => $title,
                'seo_description' => $short_description,
                'index' => $faker->boolean(75) ? 'index' : 'noindex',
                'seo_indexing' => $faker->boolean(75) ? 1 : 0,
            ]);

            // // // Add a random image to the media collection
            // $random_image_file = $faker->randomElement($hero_image_files);
            // $property->addMedia($random_image_file->getPathname())->preservingOriginal()->toMediaCollection('image');

            $random_hero_image = $faker->randomElement($hero_image_files);
            $property->addMedia($random_hero_image->getPathname())
                ->preservingOriginal()
                ->toMediaCollection('hero_image');

            // Add random unique images to the gallery media collection
            // $number_gallery_images = $faker->numberBetween(0, 3);
            // $gallery_images = $faker->randomElements($gallery_image_files, $number_gallery_images);

            // foreach ($gallery_images as $gallery_image) {
            //     $property->addMedia($gallery_image->getPathname())->preservingOriginal()->toMediaCollection('gallery');
            // }

            $number_gallery_images = $faker->numberBetween(0, 3);
            $gallery_images = $faker->randomElements($gallery_image_files, $number_gallery_images);

            foreach ($gallery_images as $gallery_image) {
                $property->addMedia($gallery_image->getPathname())
                    ->preservingOriginal()
                    ->toMediaCollection('gallery');
            }
                    }
                }
}
