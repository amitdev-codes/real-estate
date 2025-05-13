<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Modules\User\Models\User as ModuleUser;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    // public function share(Request $request): array
    // {
    //     $user = $request->user();
    //     // If user is authenticated, get their media from the module model
    //     $moduleUser = null;
    //     $userMedia = [];
    //     if ($user) {
    //         // Get the module user model instance for the current user
    //         $moduleUser = ModuleUser::find($user->id);
    //         // Get the media using the module's getMediaWithUrls method
    //         if ($moduleUser) {
    //             $userMedia = $moduleUser->getMediaWithUrls('users');
    //         }
    //     }
        
    //     return array_merge(parent::share($request), [
    //         'appName' => config('app.name'),
    //         'auth' => [
    //             'user' => $user ? [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'mobile_no' => $user->mobile_no,
    //                 'permissions' => $user->getAllPermissions()->pluck('name'),
    //                 'roles' => $user->getRoleNames(),
    //                 'role' => $user->roles->first()->name,
    //                 'media' => $userMedia,
    //                 // And optionally include the thumb and preview URLs if needed
    //                 'thumb_url' => $moduleUser  ? $moduleUser ->thumb_url : null,
    //                 'preview_url' => $moduleUser  ? $moduleUser ->preview_url : null,
    //             ] : null,
    //         ],
    //         'ziggy' => fn () => [
    //             ...(new Ziggy)->toArray(),
    //             'location' => $request->url(),
    //         ],
    //     ]);
    // }

    public function share(Request $request): array
    {
        $user = $request->user();
        // Initialize variables
        $moduleUser  = null;
        $userMedia = [];
        $mediaCollectionName = '';

        if ($user) {
            // Determine the media collection name based on the user's role
            if ($user->hasRole('Agent')) {
                $moduleUser  = Agent::with('media')->where('user_id', $user->id)->first();
                $mediaCollectionName = 'agents';
            } elseif ($user->hasRole('Agency')) {
                $moduleUser  = Agency::with('media')->where('user_id', $user->id)->first();
                $mediaCollectionName = 'agencies';
            } elseif ($user->hasRole('User')) {
                $moduleUser  = ModuleUser ::with('media')->where('id', $user->id)->first();
                $mediaCollectionName = 'users';
            }
        }


        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile_no' => $user->mobile_no,
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                    'roles' => $user->getRoleNames(),
                    'role' => $user->roles->first()->name,
                    // 'media' => $userMedia,
                    // And optionally include the thumb and preview URLs if needed
                    'profile_image' => $moduleUser  ? $moduleUser ->thumb_url : null,
                    'preview_url' => $moduleUser  ? $moduleUser ->preview_url : null,
                ] : null,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ]);
    }
}
