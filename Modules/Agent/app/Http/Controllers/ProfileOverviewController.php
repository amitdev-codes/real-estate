<?php

namespace Modules\Agent\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Traits\HasDropzoneMedia;
use Modules\Agency\Models\Agency;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileOverviewController extends Controller
{
    use HasDropzoneMedia;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userInformation = Agent::with('user', 'media', 'agency')->where('user_id', Auth::id())->first();
        $data = null;
        if ($userInformation) {
            $data = [
                'id' => $userInformation->id,
                'model' => 'agent',
                'role' => 'Agent',
                'email' => $userInformation->email,
                'name' => $userInformation->first_name.' '.$userInformation->last_name??'',
                'first_name' => $userInformation->first_name??'',
                'last_name' => $userInformation->last_name??'',
                'phone' => $userInformation->phone,
                'license_number' => $userInformation->license_number,
                'short_description' => $userInformation->short_description,
                'status' => $userInformation->status,
                'agency_id' => $userInformation->agency->id??null,
                'agency_name' => $userInformation->agency->name??null,
                'experience' => $userInformation->experience ?? null,
                'primary_area' => $userInformation->primary_area ?? null,
                'additional_areas' => $userInformation->additional_areas ?? [],
                'specializations' => $userInformation->specializations ?? [],
                'media_url' => $userInformation->thumb_url,
                'previewUrl' => $userInformation->preview_url,
            ];
        }

        // dd($data);

        // Render the Inertia component with the prepared data
        return Inertia::render('Agent::profileOverview/index', [
            'data' => $data,
            'agencies' => Agency::get(['id', 'name']),
        ]);
    }

    public function getTestimonials()
    {
        $agent = Agent::where('user_id', Auth::id())->first();

        if (! $agent) {
            return response()->json(['error' => 'Agent not found'], 404);
        }

        $testimonials = $agent->getMediaItems('agent_testimonials');

        // dd($testimonials);

        return response()->json($testimonials);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agent::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $profile = auth()->user()->profile->load('media');

        return view('agent::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('agent::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgentProfileRequest $request) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
