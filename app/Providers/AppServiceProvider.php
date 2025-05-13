<?php

namespace App\Providers;
use Inertia\Inertia;
use App\Models\master\City;
use App\Models\master\State;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        Gate::before(function ($user, $ability) {
            return $user->hasRole('SuperAdmin') ? true : null;
        });

        // Share cached states and cities with Inertia
        Inertia::share([
            'states' => function () {
                return Cache::remember('states', 60 * 60 * 24, function () {
                    return State::all()->map(function ($state) {
                        return [
                            'value' => $state->id,
                            'label' => $state->name,
                        ];
                    })->all();
                });
            },
            'cities' => function () {
                return Cache::remember('cities', 60 * 60 * 24, function () {
                    return City::all()->map(function ($city) {
                        return [
                            'value' => $city->id,
                            'label' => $city->name,
                        ];
                    })->all();
                });
            },
        ]);
    }
}