<?php

use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\NearbyFacilityController;
use Modules\Property\Http\Controllers\ProjectController;
use Modules\Property\Http\Controllers\PropertyCategoryController;
use Modules\Property\Http\Controllers\PropertyController;
use Modules\Property\Http\Controllers\PropertyDeveloperController;
use Modules\Property\Http\Controllers\PropertyFactilityController;
use Modules\Property\Http\Controllers\PropertyFeatureController;
use Modules\Property\Http\Controllers\PropertyPurposeController;
use Modules\Property\Http\Controllers\PropertyTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['prefix'=>'admin', 'as' => 'admin.'], function () {
//     Route::resource('properties', PropertyController::class)->names('properties');

//     Route::resource('property-categories', PropertyCategoryController::class)->except(['create', 'edit'])->names('property-categories');

//     Route::resource('property-features', PropertyFeatureController::class)->except(['create', 'show', 'edit'])->names('property-features');
//     Route::patch('property-feature/{id}/reorder', [PropertyFactilityController::class, 'reorder'])->name('property-facility.reorder');

//     Route::resource('property-facilities', PropertyFactilityController::class)->except(['create', 'edit'])->names('property-facilities');

//     Route::resource('property-purposes', PropertyPurposeController::class)->except(['create', 'edit'])->names('property-purposes');

// });


Route::group(['prefix'=>'admin', 'as' => 'admin.'], function () {

    Route::middleware(['auth', 'role:SuperAdmin|Admin|Agent'])->group(function () {

        Route::get('project/get-developers', [ProjectController::class,'getDevelopers'])->name('project.get-developers');

        // for common getdata for datatables
        Route::macro('resourceWithDatatables', function ($name, $controller, $options = []) {
            // Default options
            $defaultOptions = [
                'except' => ['show'],
                'withExport' => false,
            ];
            $options = array_merge($defaultOptions, $options);
            // Generate resource routes with specified exceptions
            Route::resource($name, $controller)->except($options['except']);
            // Generate DataTables route
            Route::prefix($name)->group(function () use ($name, $controller) {
                Route::get('data', [$controller, 'getData'])
                    ->name("{$name}.data");
            });

            // Optional export route
            if ($options['withExport']) {
                Route::prefix($name)->group(function () use ($name, $controller) {
                    Route::post('export', [$controller, 'export'])
                        ->name("{$name}.export");
                });
            }
        });

        // Route::resource('properties', PropertyController::class)->names('properties');

        // Route::resource('property-categories', PropertyCategoryController::class)->except(['create', 'edit'])->names('property-categories');

        // Route::resource('property-features', PropertyFeatureController::class)->except(['create', 'show', 'edit'])->names('property-features');
        // Route::patch('property-feature/{id}/reorder', [PropertyFactilityController::class, 'reorder'])->name('property-facility.reorder');

        // Route::resource('property-facilities', PropertyFactilityController::class)->except(['create', 'edit'])->names('property-facilities');

        // Route::resource('property-purposes', PropertyPurposeController::class)->except(['create', 'edit'])->names('property-purposes');


        Route::resourceWithDatatables('properties', PropertyController::class, ['withExport' => true]);

        Route::resource('property-categories', PropertyCategoryController::class)->except(['create', 'edit'])->names('property-categories');

        Route::resource('property-types', PropertyTypeController::class)->except(['create', 'edit', 'show']);
        Route::post('property-types/reorder', [PropertyTypeController::class, 'updateOrder'])->name('property-types.reorder');

        Route::resource('property-features', PropertyFeatureController::class)->except(['create', 'show', 'edit'])->names('property-features');

        // Route::resource('property-facilities', PropertyFactilityController::class)->except(['create', 'edit'])->names('property-facilities');
        Route::resource('nearby-facilities', NearbyFacilityController::class)->except(['create', 'edit'])->names('nearby-facilities');

        Route::resource('property-purposes', PropertyPurposeController::class)->except(['create', 'edit'])->names('property-purposes');

        Route::resourceWithDatatables('projects', ProjectController::class, ['withExport' => true]);

        Route::resourceWithDatatables('property-developers', PropertyDeveloperController::class, ['withExport' => true]);

    });
});

