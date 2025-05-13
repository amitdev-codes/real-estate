<?php

namespace Modules\Agency\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'registered_agency_number' => 'required|string|max:50',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable',
            'website' => 'nullable|url',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'state' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'street' => 'nullable|string|max:255',
            'building_number' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
