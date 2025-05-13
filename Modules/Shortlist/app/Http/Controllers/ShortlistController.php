<?php

namespace Modules\Shortlist\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use App\Http\Controllers\Controller;
use Modules\Property\Models\Property;
use Modules\Shortlist\Models\Shortlist;

class ShortlistController extends Controller
{
    public function index()
    {
        // Fetch shortlists for the authenticated user with their relationships
        $shortlists = Shortlist::with(['shortlistable', 'agent', 'agency'])
            ->where('user_id', auth()->id()) // Filter by the authenticated user
            ->latest()
            ->get();
    
        // Transform and group the shortlists by type
        $groupedShortlists = $shortlists
            ->groupBy('shortlistable_type')
            ->map(function ($items, $type) {
                return [
                    'type' => Str::title(class_basename($type)),
                    'items' => $items->map(function ($item) {
                        // Prepare the shortlistable item with additional data
                        $shortlistableItem = $item->shortlistable;
    
                        // Add agent and agency info to the shortlistable item if they exist
                        if ($item->agent) {
                            $shortlistableItem->agent = $item->agent;
                        }
    
                        if ($item->agency) {
                            $shortlistableItem->agency = $item->agency;
                        }
    
                        return [
                            'id' => $item->id,
                            'notes' => $item->notes,
                            'created_at' => $item->created_at,
                            'item' => $shortlistableItem,
                        ];
                    }),
                ];
            })
            ->all();
    
        // Get agents and agencies associated with shortlisted properties
        $agentIds = $shortlists->pluck('agent_id')->filter()->unique();
        $agencyIds = $shortlists->pluck('agency_id')->filter()->unique();
    
        $agents = Agent::whereIn('id', $agentIds)
            ->select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->get()
            ->map(function ($agent) {
                return [
                    'id' => $agent->id,
                    'name' => $agent->first_name . ' ' . $agent->last_name, // Merge first and last name
                ];
            });
    
        $agencies = Agency::whereIn('id', $agencyIds)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

    
        return Inertia::render('Shortlist::index', [
            'groupedShortlists' => $groupedShortlists,
            'agents' => $agents,
            'agencies' => $agencies,
            'meta' => [
                'title' => 'My Shortlists',
                'meta_key' => 'shortlists',
                'meta_description' => 'View and manage your shortlisted properties and agencies',
                'url' => route('frontend.shortlist.index'),
                'type' => 'website',
                'image' => asset('path/to/your/default/image.jpg'),
            ],
        ]);
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'shortlistable_id' => 'required|integer',
            'shortlistable_type' => 'required|string',
            'notes' => 'nullable|string',
            'agent_id' => 'nullable|integer|exists:agents,id',
            'agency_id' => 'nullable|integer|exists:agencies,id',
        ]);

        // Convert to proper namespace format if needed
        // $modelClass = $validated['shortlistable_type'];

        // if (!Str::startsWith($modelClass, 'App\\') && !Str::startsWith($modelClass, 'Modules\\')) {
        //     // Convert to the correct namespace format
        //     $modelClass = Str::of($modelClass)
        //         ->replace('App\\Models\\', 'Modules\\Property\\Models\\') // Replace "App\Models\" with "Modules\Property\Models\"
        //         ->replace('app\\models\\', 'Modules\\Property\\Models\\') // Replace "app\models\" with "Modules\Property\Models\"
        //         ->toString();
        // }

        $modelClass = Property::class;
        // Ensure the class exists
        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }


        // dd($modelClass, $validated['shortlistable_type']);

        // Set property_id if the shortlistable is a property
        $property_id = null;
        if (Str::contains($modelClass, 'Property')) {
            $property_id = $validated['shortlistable_id'];
        }

        // Find existing shortlist
        $shortlist = Shortlist::where([
            'user_id' => auth()->id(),
            'shortlistable_id' => $validated['shortlistable_id'],
            'shortlistable_type' => $modelClass,
        ]);

        if ($shortlist->exists()) {
            $shortlist->delete();
            return response()->json(['status' => 'removed']);
        }

        Shortlist::create([
            'user_id' => auth()->id(),
            'shortlistable_id' => $validated['shortlistable_id'],
            'shortlistable_type' => $modelClass,
            'agent_id' => $validated['agent_id'] ?? null,
            'agency_id' => $validated['agency_id'] ?? null,
            'property_id' => $property_id,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json(['status' => 'added']);
    }

    public function updateNotes(Request $request, Shortlist $shortlist)
    {
        // Make sure the user owns this shortlist
        if ($shortlist->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'notes' => 'required|string',
        ]);

        $shortlist->update(['notes' => $validated['notes']]);

        return response()->json(['status' => 'updated']);
    }
}
