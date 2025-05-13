<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        // return inertia('backend/pages/index');
        return Inertia::render('backend/pages/index');
    }
}
