<?php

use App\Http\Controllers\Admin\BulkDeleteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Locations\CityController;
use App\Http\Controllers\Admin\Locations\CountryController;
use App\Http\Controllers\Admin\Locations\StateController;
use App\Http\Controllers\Admin\Logs\ActivityLogController;
use App\Http\Controllers\Admin\Logs\SystemLogController;
use App\Http\Controllers\Admin\TempFileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserManagement\PermissionController;
use App\Http\Controllers\UserManagement\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:SuperAdmin|Admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');

    $commonExceptions = ['create', 'edit', 'show'];

    // for common getdata for datatables
    Route::macro('resourceWithDatatables', function ($name, $controller, $options = []) {
        $defaultOptions = ['except' => ['show'], 'withExport' => false];
        $options = array_merge($defaultOptions, $options);
        Route::resource($name, $controller)->except($options['except']);
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

    // Bulk delete
    Route::delete('/bulk-delete/{model}', [BulkDeleteController::class, 'bulkDestroy'])->name('bulkDelete');
    $resources = [
        'users' => [UserController::class, ['except' => ['show'], 'withExport' => true]],
        'roles' => [RoleController::class, ['except' => ['show']]],
        'permissions' => [PermissionController::class, ['except' => $commonExceptions]],
        'countries' => [CountryController::class, ['except' => $commonExceptions]],
        'states' => [StateController::class, ['except' => $commonExceptions]],
        'cities' => [CityController::class, ['except' => $commonExceptions]],
        'activityLogs' => [ActivityLogController::class, ['except' => $commonExceptions]],
        'systemLogs' => [SystemLogController::class, ['except' => $commonExceptions]],
    ];

    foreach ($resources as $name => [$controller, $options]) {
        Route::resourceWithDatatables($name, $controller, $options);
    }

    Route::get('system-logs/show', [SystemLogController::class, 'show'])->name('systemLogs.show');
});

Route::get('users/archive/{user}', [UserController::class, 'archive'])->name('users.archive');
// Temp file upload and remove
Route::middleware(['auth', 'role:SuperAdmin|Admin|Agent|Agency'])->group(function () {
    Route::post('/temp-file/upload', [TempFileController::class, 'tempFileUpload'])->name('fileUpload');
    Route::delete('/temp-file/remove-temp', [TempFileController::class, 'tempFileDelete'])->name('tempFileDelete');
    Route::delete('/temp-file/remove', [TempFileController::class, 'fileDelete'])->name('fileDelete');
});
