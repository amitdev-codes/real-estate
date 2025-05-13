<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use Illuminate\Validation\Rules;
use Modules\Agency\Models\Agency;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\User\StoreUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('frontend/pages/auth-pages/auth-signup',[
            'roles'=>Role::whereNotIn('name', ['Admin', 'SuperAdmin'])->get()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {

        return DB::transaction(function () use ($request) {
            // Create the base user
            $userData=$request->validated();
            $data = Arr::except($userData, ['terms','role','license_number','agency_id','password_confirmation']);
            $role = Role::findById($request->role);
            $user = User::create($data);
            $user->assignRole($role);

            // Handle role-specific logic
            switch ($role->name) {
                case 'Agent':
                    Agent::create([
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'phone' => $user->mobile_no,
                        'license_number' => $request->license_number,
                        'status' => 'pending'
                    ]);
                    break;

                case 'Agency':
                    Agency::create([
                        'user_id' => $user->id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->mobile_no,
                        'agency_id' => $request->agency_id,
                        'status' => 'pending'
                    ]);
                    break;
            }


            event(new Registered($user));

            Auth::login($user);

            // Get lowercase role name for routing
            $userRole = $user->getRoleNamesLowercaseAttribute()->first();
            $roleRouteMap = [
                'user' => 'dashboard',
                'agent' => 'agent.dashboard',
                'agency' => 'agency.dashboard'
            ];

            $dashboardRoute = $roleRouteMap[$userRole] ?? 'dashboard';

            return redirect()->intended(route($dashboardRoute, absolute: false));
        });

    }
}
