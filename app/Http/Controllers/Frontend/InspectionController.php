<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\InspectionPlan;
use Illuminate\Routing\Controller;

class InspectionController extends Controller
{
    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required|date_format:H:i',
            'visitors_count' => 'required|integer|min:1|max:5',
            'additional_requirements' => 'array',
            'special_instructions' => 'nullable|string'
        ]);

        $inspection = InspectionPlan::create([
            'user_id' => auth()->id(),
            'property_id' => $validated['property_id'],
            'planned_datetime' => $validated['preferred_date'] . ' ' . $validated['preferred_time'],
            'status' => 'scheduled',
            'visitors_count' => $validated['visitors_count'],
            'additional_requirements' => json_encode($validated['additional_requirements'] ?? []),
            'special_instructions' => $validated['special_instructions']
        ]);

        return back()->with('success', 'Inspection scheduled successfully');
    }
}
