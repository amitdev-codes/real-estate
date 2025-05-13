<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:property_categories,id',
            'slug' => 'required|string|max:255|unique:property_categories,slug,' . $this->property_category->id,
            'icon'=> 'nullable|string',
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
