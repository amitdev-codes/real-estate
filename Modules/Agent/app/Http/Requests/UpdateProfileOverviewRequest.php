<?php

namespace Modules\Agent\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileOverviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('agents', 'email')->ignore(auth()->id())
            ],
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
            'experience' => 'required|integer|min:0',
            'agency_id' => 'required|exists:agencies,id',
            'service_areas' => 'required|array|min:1',
            'service_areas.*' => 'string|max:100',
            'primary_area' => 'required|string|max:100',
            'additional_areas' => 'nullable|array',
            'additional_areas.*' => 'string|max:100',
            'short_description' => 'required|string|max:500',
            'specializations' => 'nullable|array',
            'specializations.*' => 'string|max:100',
            'profile_image' => 'nullable|image|max:2048'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email address is required',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'license_number.required' => 'License number is required',
            'experience.required' => 'Years of experience is required',
            'experience.min' => 'Experience years cannot be negative',
            'agency_id.required' => 'Please select an agency',
            'service_areas.required' => 'At least one service area is required',
            'primary_area.required' => 'Primary service area is required',
            'short_description.required' => 'Short description is required',
            'profile_image.max' => 'The profile image must not be larger than 2MB'
        ];
    }
}
