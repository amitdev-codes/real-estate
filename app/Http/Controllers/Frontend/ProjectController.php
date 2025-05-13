<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Modules\Property\Models\Project;
use Modules\Property\Models\Property;
use Modules\Property\Models\PropertyCategory;
use App\Http\Controllers\Frontend\BaseController;
use Exception;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

    //  const categories = ref({
    //     Buy: ["House", "Apartment", "Condo", "Townhouse", "Other"],
    //     Sold: ["House", "Land"],
    //     Rent: ["Apartment", "Condo", "Studio"],
    //     "House & Land": ["House", "Land"],
    //   });
    public function show($slug)
    {
        if(!$slug){
            throw new Exception('Invalid Project');
        }
        $projects = $this->getProjectsWithPropertiesBySlug($slug);


        return Inertia::render('frontend/pages/listing/project/project-detail', [
            'projects_properties' => $projects,
            'meta' => [
                'title' => 'Find Your Dream Home With Us',
                'meta_key' => 'Real Estate, Property & Homes, Land, Rent, Buy, Sell',
                'meta_description' => 'Search for Real Estate, Property & Homes',
                'og_title' => 'Find Your Dream Home With Us',
                'og_description' => 'We buy sell homes',
                'og_type' => 'website',
                'og_image' => resource_path('assets/frontend/images/logo-dark.png'),
            ],
        ]);
    }

    public function getCategories()
{
    $categories = PropertyCategory::with('children')
    ->whereHas('children') // Ensure the category has child categories
    ->get();

     // Transform the data into the desired structure
     $transformedCategories = $categories->mapWithKeys(function ($category) {
        return [$category->name => $category->children->pluck('name')->toArray()];
    });

    return $transformedCategories;
}

public function getProjectsWithPropertyCount()
{
    return Project::with('developer.address')->where(['moderation_status'=> 'approved','construction_type'=>'New Construction'])->withCount('properties')
    ->having('properties_count', '>', 0)
    ->get();
}

public function getPropertiesForProject($projectId)
{
    $project = Project::with('properties')->findOrFail($projectId);
    return [
        'project' => $project->name,
        'properties' => $project->properties
    ];
}

public function getProjectsWithProperties()
{
    return Project::with(['properties' => function ($query) {
        $query->select('id', 'title', 'project_id', 'bedrooms', 'bathrooms', 'base_price');
    }])->withCount('properties')->having('properties_count', '>', 0)
    ->get();
}

public function getProjectsWithPropertiesBySlug($slug)
{
    return Project::where(['slug'=>$slug,'moderation_status'=> 'approved'])->with(['developer.address','address','properties.agency','properties' => function ($query) {
        $query->select('id', 'title', 'project_id', 'bedrooms', 'bathrooms', 'base_price');
    }])->withCount('properties')->having('properties_count', '>', 0)
    ->get();
}

}
