<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function adminLogin(LoginRequest $request)
    {
        if ($request->is('admin/login')) {
            $request->authenticate();
            $request->session()->regenerate();
            if ($request->user()->hasRole('Admin') || $request->user()->hasRole('SuperAdmin')) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Unauthorized.']);
            }
        }
        return redirect()->route('login');
    }

    public function create(Request $request): Response
    {
        if ($request->is('admin/*')) {
            return Inertia::render('backend/pages/auth-pages/login', [
                'canResetPassword' => Route::has('password.request'),
                'status' => session('status'),
            ]);
        }
        return Inertia::render('frontend/pages/auth-pages/auth-login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $userRole = $request->user()->getRoleNamesLowercaseAttribute()->first();

        if ($userRole == 'admin' || $userRole == 'superadmin') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Unauthorized login']);
        }
        $roleRouteMap = ['user' => 'dashboard', 'agent' => 'agent.dashboard', 'agency' => 'agency.dashboard'];
        $dashboardRoute = $roleRouteMap[$userRole] ?? 'admin.dashboard';

        return redirect()->intended(route($dashboardRoute, [], absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
