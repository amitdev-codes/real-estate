<?php

namespace Modules\Property\Database\Seeders;

use App\Models\PropertyLengthUnit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Modules\Agent\Models\Agent;
use Modules\Property\Models\Project;
use Modules\Property\Models\ProjectStatus;
use Modules\Property\Models\PropertyCategory;
use Modules\Property\Models\PropertyDeveloper;
use Modules\Property\Models\PropertyFacilitiesDistance;
use Modules\Property\Models\PropertyFeature;
use Modules\Property\Models\PropertyType;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake_records_no = 20;
        $faker = Faker::create();

        $agents_ids = Agent::pluck('id')->toArray();
        $project_status_ids = ProjectStatus::pluck('id')->toArray();
        $features_data = PropertyFeature::all();
        $developer_data = PropertyDeveloper::pluck('id')->toArray();
        $area_units = PropertyLengthUnit::where('type', 'area')->select('id', 'conversion_rate')->get();

        $property_type_ids = PropertyType::pluck('id')->toArray();

        // $hero_image_files = File::files(base_path('__misc/dummy_images/exterior'));
        // $gallery_image_files = File::files(base_path('__misc/dummy_images/interior'));

        foreach (range(1, $fake_records_no) as $index) {
            $name = $faker->company;
            $slug = Str::slug($name);
            $short_description = $faker->realText(200);            

            $random_unit = $faker->randomElement($area_units);

            $total_area = $faker->numberBetween(50, 2000);
            $unit_id = $random_unit->id;
            $total_area_in_m2 = $total_area * $random_unit->conversion_rate;


            $lowest_price = $faker->numberBetween(100000, 10000000);
            $max_price = $lowest_price + $faker->numberBetween(100000, 10000000);

            $features = $features_data
                ->random($faker->numberBetween(6, 10))
                ->pluck('id')->toArray();


            $project_start_date = $faker->dateTimeBetween('-5 years', 'now');
            $project_finish_date = $faker->dateTimeBetween($project_start_date, '2 years');
            $project_sale_start_date = $faker->dateTimeBetween($project_start_date, '1 years');
            $property_availability_date = $faker->dateTimeBetween($project_start_date, '2 years');

            $agent_id = $faker->randomElement($agents_ids);
            $created_by_id = $agent_id;
            $modified_by_id = $faker->boolean() ? $agent_id : null;


            $project = Project::create([
                'name' => $name,
                'slug' => $slug,
                'short_description' => $short_description,
                'description' => $faker->paragraphs(10, true),

                'visits' => $faker->numberBetween(10, 500),

                'project_status_id' => $faker->randomElement($project_status_ids),
                'features' => $features,
                'construction_type' => $faker->randomElement(['New Construction', 'Established Property']),

                'total_blocks' => $faker->numberBetween(1, 20),
                'total_buildings' => $faker->numberBetween(1, 50),
                'total_floors' => $faker->numberBetween(1, 50),
                'total_flats' => $faker->numberBetween(1, 200),
                'total_area' => $total_area,
                'unit_id' => $unit_id,
                'total_area_in_m2' => $total_area_in_m2,

                'project_start_date' => $project_start_date,
                'project_finish_date' => $project_finish_date,
                'project_sale_start_date' => $project_sale_start_date,
                'property_availability_date' => $property_availability_date,
                
                'lowest_price' => $lowest_price,
                'max_price' => $max_price,

                'video_link' => $faker->url(),

                'developer_id' => $faker->randomElement($developer_data),

                'publish_start_date' => $faker->dateTimeBetween('-1 years', '1 years'),
                'publish_end_date' => $faker->dateTimeBetween('now', '3 years'),

                'is_featured' => $faker->boolean(90),
                'is_published' => $faker->boolean(80),
                'is_active' => $faker->boolean(90),
                'has_ads' => $faker->boolean(50),
                
                'moderation_status' => $faker->randomElement(['pending', 'rejected', 'approved']),

                'created_by_id' => $created_by_id,
                'modified_by_id' => $modified_by_id,
            ]);

            $project->propertyTypes()->sync($faker->randomElements($property_type_ids, $faker->numberBetween(2, 5)));

            $project->metaContent()->create([
                'seo_title' => $name,
                'seo_description' => $short_description,
                'index' => $faker->boolean(75) ? 'index' : 'noindex',
                'seo_indexing' => $faker->boolean(75) ? 1 : 0,
            ]);

            // // Add a random image to the media collection
            // $random_image_file = $faker->randomElement($hero_image_files);
            // $project->addMedia($random_image_file->getPathname())->preservingOriginal()->toMediaCollection('image');

            // // Add random unique images to the gallery media collection
            // $number_gallery_images = $faker->numberBetween(0, 3);
            // $gallery_images = $faker->randomElements($gallery_image_files, $number_gallery_images);

            // foreach ($gallery_images as $gallery_image) {
            //     $project->addMedia($gallery_image->getPathname())->preservingOriginal()->toMediaCollection('gallery');
            // }
        }
    }
}


