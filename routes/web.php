<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->hasRole('Admin') || $user->hasRole('SuperAdmin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Agent')) {
            return redirect()->route('agent.dashboard');
        } elseif ($user->hasRole('Agency')) {
            return redirect()->route('agency.dashboard');
        }

        // Default Inertia dashboard for other users
        return Inertia::render('frontend/pages/index/index-two');
    })->name('dashboard');

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile-setting', [ProfileController::class, 'edit'])->name('profile-setting');
    // Route::get('/profile-setting', [ProfileController::class, 'edit'])->name('profile.setting');

    // common media upload
    Route::post('/media/upload', [MediaController::class, 'upload']);
    Route::delete('/media/{id}', [MediaController::class, 'destroy']);
    // Route::get('{model}/{id}/{collection}', [MediaController::class, 'getMediaByCollection'])
    //     ->name('media.by.collection');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'],
    function () {
        require base_path('routes/backend.php');
    });

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'],
    function () {
        require base_path('routes/admin.php');
    });
Route::group([
    'as' => 'frontend.'],
    function () {
        require base_path('routes/frontend.php');
    });

require __DIR__.'/auth.php';
