<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StorePropertyTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:property_types',
            'slug' => 'required|string|max:255|unique:property_types',
            'icon' => 'nullable|string',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:property_types,id',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create property types');
    }
}
