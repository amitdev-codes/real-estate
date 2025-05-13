<?php

use Illuminate\Support\Facades\Route;
use Modules\Agent\Http\Controllers\AgentController;
use Modules\Agent\Http\Controllers\ProfileOverviewController;
use Modules\Agent\Http\Controllers\PropertyController;

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

Route::group(['prefix' => 'agent'], function () {
    Route::get('dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('profileOverview', [ProfileOverviewController::class, 'index'])->name('agent.profileOverview');
    Route::get('/{agent}/agent_testimonials', [ProfileOverviewController::class, 'getTestimonials'])->name('agent.testimonials');

    Route::resource('agents', AgentController::class);

    Route::post('/temp-file/upload', [TempFileController::class, 'tempFileUpload'])->name('fileUpload');
    Route::delete('/temp-file/remove-temp', [TempFileController::class, 'tempFileDelete'])->name('tempFileDelete');
    Route::delete('/temp-file/remove', [TempFileController::class, 'fileDelete'])->name('fileDelete');


    Route::group(['as' => 'agent.'], function () {
        Route::resourceWithDatatables('properties', PropertyController::class, [
            'except' => ['show', 'store', 'update',  'destroy'],
            'withExport' => true,
        ]);
    });


});
