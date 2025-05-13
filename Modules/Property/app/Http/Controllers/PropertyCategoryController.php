<?php

namespace Modules\Property\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesExceptions;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\PropertyCategory;
use Modules\Property\Http\Requests\StorePropertyCategoryRequest;
use Modules\Property\Http\Requests\UpdatePropertyCategoryRequest;

class PropertyCategoryController extends Controller
{
    use HandlesExceptions;

    private function buildCategoryTree($categories, $parentId = null)
    {
        $tree = [];
        foreach ($categories as $category) {
            // If no parentId is specified, only add root-level categories (no parents)
            // if ($parentId === null && $category->parents->isEmpty()) {
            //     $tree[] = $this->formatCategory($category);
            // }
            // // If parentId is specified, check if the current category's parents contain the parentId
            // elseif ($parentId !== null && $category->parents->pluck('id')->contains($parentId)) {
            //     $tree[] = $this->formatCategory($category);
            // }

            $tree[] = $this->formatCategory($category);

        }
        return $tree;
    }

    private function formatCategory($category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'is_active' => $category->is_active,
            'children' => $this->buildCategoryTree($category->children, $category->id), // Recursively fetch children
        ];
    }


    public function show($id)
    {
        $category = PropertyCategory::with('children')->findOrFail($id);

        return response()->json([
            'category' => $category,
            'message' => 'Category retrieved successfully.',
        ]);
    }

    public function index()
    {
        $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
        $icons = json_decode(file_get_contents($icon_path), true);
        // $categories = PropertyCategory::with('children')->whereNull('parent_id')->get();
        $categories = PropertyCategory::with('children', 'parents')->get();
        $categoryTree = $this->buildCategoryTree($categories);
        // $categories = PropertyCategory::with('children')->whereNull('parent_id')->get();

        return inertia('Property::property-category/index',
            [
                'categories' => $categoryTree,
                'icons'=> $icons,
            ]);
    }

    public function store(StorePropertyCategoryRequest $request)
    {
        return $this->handleExceptions(function () use ($request) {
            $category = PropertyCategory::create($request->validated());
            if ($request->has('parent_ids')) {
                $category->children()->sync($request->input('parent_ids'));
            }

            $categories = PropertyCategory::with('children', 'parents')->get();
            $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
            $icons = json_decode(file_get_contents($icon_path), true);
            $categoryTree = $this->buildCategoryTree($categories);

            return inertia('Property::property-category/index', [
                'categories' => $categoryTree,
                'icons'=> $icons,
                'success' => 'Property category created successfully.',
            ]);
        }, 'admin.property-categories.index');


        // return $this->handleExceptions(function () use ($request) {
        //     $category = PropertyCategory::create($request->validated());
        //     if ($request->has('parent_ids')) {
        //         $category->children()->sync($request->input('parent_ids'));
        //     }
        //     return redirect()
        //         ->route('admin.property-categories.index')
        //         ->with('success', 'Property category created successfully.');
        // }, 'admin.property-categories.index');

    }

    public function update(UpdatePropertyCategoryRequest $request, PropertyCategory $property_category): RedirectResponse
    {

        return $this->handleExceptions(function () use ($request, $property_category) {
            $property_category->update($request->validated());

            if ($request->has('parent_ids')) {
                $property_category->children()->sync($request->input('parent_ids'));
                // $property_category->parents()->sync($request->input('id'));
            }

            return redirect()
                ->route('admin.property-categories.index')
                ->with('success', 'Property category updated successfully.');
            }, 'admin.property-categories.index');
    }

    public function destroy(PropertyCategory $property_category)
    {
        return $this->handleExceptions(function () use ($property_category) {
            $property_category->deleteOrFail();
            // return redirect()->back()->with('success', 'Property category deleted');
            $categories = PropertyCategory::with('children', 'parents')->get();
            $icon_path = resource_path('assets/backend/fonts/optimized-mdi-icons-meta.json');
            $icons = json_decode(file_get_contents($icon_path), true);
            $categoryTree = $this->buildCategoryTree($categories);

            return inertia('Property::property-category/index', [
                'categories' => $categoryTree,
                'icons'=> $icons,
                'success' => 'Property category deleted.',
            ]);
        }, 'admin.property-categories.index');
    }
}
