<?php

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Http\Controllers\NotificationController;

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

Route::middleware(['web'])->group(function () {
    Route::resource('notifications', NotificationController::class);
    Route::get('notifications/unread/count', [NotificationController::class, 'getUnreadCount']);
    Route::put('/notifications/{notification}/reply', [NotificationController::class, 'reply'])->name('notifications.reply');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/bulk-mark-as-read', [NotificationController::class, 'bulkMarkAsRead']);
    Route::post('/notifications/bulk-delete', [NotificationController::class, 'bulkDelete']);

    Route::get('fetchNotifications', [NotificationController::class, 'getNotifications'])->name('fetchNotifications');
    Route::get('/group/{groupName}', [NotificationController::class, 'viewGroupNotifications'])->name('viewGroupNotifications');
});
