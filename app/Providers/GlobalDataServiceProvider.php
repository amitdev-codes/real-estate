<?php
namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;
use Modules\Notifications\Models\NotificationGroup;
use Modules\Notifications\Models\NotificationSubGroup;
 // Replace with your models

class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share global data with all Inertia responses
        Inertia::share([
            'notificationGroupTypes' => fn () => cache()->remember('notificationGroupTypes', 3600, function () {
                return NotificationGroup::all();
            }),
            'notificationSubGroupTypes'  => fn () => cache()->remember('notificationSubGroupTypes', 3600, function () {
                return NotificationSubGroup::all();
            }),
        ]);
    }
}
