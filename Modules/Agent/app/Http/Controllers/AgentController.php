<?php

namespace Modules\Agent\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Property\Models\Property;
use Modules\Agent\Http\Requests\UpdateAgentRequest;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $stats = Property::where('agent_id', auth()->user()->agent->id)
            ->selectRaw('
            COUNT(*) as total_properties,
            SUM(visits) as total_visits,
            SUM(CASE WHEN moderation_status = "approved" THEN 1 ELSE 0 END) as approved_properties,
            SUM(CASE WHEN moderation_status = "pending" THEN 1 ELSE 0 END) as pending_properties,
            SUM(CASE WHEN moderation_status = "rejected" THEN 1 ELSE 0 END) as rejected_properties
        ')
            ->first();

        return Inertia::render('Agent::dashboard', [
            'data' => $stats ?? [
                'total_visits' => 0,
                'total_properties' => 0,
                'approved_properties' => 0,
                'pending_properties' => 0,
                'rejected_properties' => 0,
            ],
        ]);
    }

    public function index()
    {

        return view('Agent::index');
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
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
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
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        $validatedData=$request->validated();
        $agent->update($validatedData);
        if (empty($validated['specializations'])) {
            $validated['specializations'] = [];
        }
        if ($request->hasFile('image')) {
            $agent->clearMediaCollection('agents');
            $agent->addMediaFromRequest('image')
                ->usingName('agent_profile')
                ->usingFileName('profile_' . time() . '.' . $request->image->extension())
                ->toMediaCollection('agents');
        }

        // Load media relationship
        $agent->load('media');
        return redirect()->route('agent.profileOverview')->with('success', 'Profile updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
