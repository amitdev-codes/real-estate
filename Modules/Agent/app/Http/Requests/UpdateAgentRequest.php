<?php

namespace Modules\Agent\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('agents')->ignore($this->agent->id)],
            'phone' => 'required|string|max:15',
            'license_number' => 'required|string|max:50',
            'experience' => 'nullable|numeric|min:0',
            'agency_id' => 'required|exists:agencies,id',
            'primary_area' => 'nullable|string|max:255',
            'additional_areas' => 'nullable|array',
            'short_description' => 'nullable|string|max:500',
            'specializations' => 'nullable',
            'specializations.*' => 'string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    protected function prepareForValidation()
    {
        // Ensure arrays are properly formatted
        if ($this->has('specializations') && !is_array($this->specializations)) {
            $this->merge([
                'specializations' => json_decode($this->specializations, true) ?? []
            ]);
        }

        if ($this->has('additional_areas') && !is_array($this->additional_areas)) {
            $this->merge([
                'additional_areas' => json_decode($this->additional_areas, true) ?? []
            ]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
