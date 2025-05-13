<?php

use Illuminate\Support\Facades\Route;
use Modules\Agency\Http\Controllers\AgentController;
use Modules\Agency\Http\Controllers\AgencyController;
use Modules\Agency\Http\Controllers\ProfileOverviewController;

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

// Route::group([], function () {
//     Route::resource('agency', AgencyController::class)->names('agency');
// });

Route::group(['prefix' => 'agency'], function () {
    Route::get('dashboard', [AgencyController::class, 'dashboard'])->name('agency.dashboard');
    Route::resource('agency', AgencyController::class)->names('agency');
    Route::get('profileOverview', [ProfileOverviewController::class, 'index'])->name('agency.profileOverview');
    Route::get('/{agency}/agency_testimonials', [ProfileOverviewController::class, 'getTestimonials'])->name('agency.testimonials');


    Route::group(['as' => 'agency.'], function () {
        Route::resourceWithDatatables('agents', AgentController::class, [
            'except' => ['show'],
            'withExport' => true,
        ]);
    });

});
