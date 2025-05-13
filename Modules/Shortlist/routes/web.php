<?php

use Illuminate\Support\Facades\Route;
use Modules\Shortlist\Http\Controllers\ShortlistController;

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
//     Route::resource('shortlist', ShortlistController::class)->names('shortlist');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/shortlist', [ShortlistController::class, 'index'])->name('frontend.shortlist.index');
    Route::post('/shortlist/toggle', [ShortlistController::class, 'toggle'])->name('frontend.shortlist.toggle');
    Route::patch('/shortlist/{shortlist}/notes', [ShortlistController::class, 'updateNotes'])->name('frontend.shortlist.updateNotes');
});
