<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyFeatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:property_features,slug,'.$this->property_feature->id,
            'icon'=> 'required|string',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
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
