<?php

use App\Http\Controllers\Admin\TempFileController;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserProfileController;

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
Route::group(['prefix' => 'user'], function () {
    Route::get('profile', [UserProfileController::class, 'show'])->name('frontend.userProfile.show');
    Route::put('updateProfile', [UserProfileController::class, 'update'])->name('frontend.userProfile.update');
    // update password
    Route::get('accountSecurity', [UserProfileController::class, 'changePassword'])->name('frontend.userProfile.changePassword');
    Route::post('accountSecurity', [UserProfileController::class, 'updatePassword'])->name('frontend.userProfile.updatePassword');
    Route::post('temp-file/upload', [TempFileController::class, 'tempFileUpload'])->name('fileUpload');
});
