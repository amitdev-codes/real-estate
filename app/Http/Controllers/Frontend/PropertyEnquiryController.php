<?php
namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PropertyEnquiry;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class PropertyEnquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'postcode' => 'nullable|string',
            'enquiry_type_id' => 'nullable|array', // Can store multiple or a single ID
            'property_id' => 'nullable|exists:properties,id',
        ]);

        $enquiry = PropertyEnquiry::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Enquiry submitted successfully',
            'data' => $enquiry
        ]);
    }

    public function index()
    {
        $enquiries = PropertyEnquiry::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return Inertia::render('frontend/pages/inquiries/index', [
            'enquiries' => $enquiries
        ]);
    }
}
