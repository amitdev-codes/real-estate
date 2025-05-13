<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // dd($this->input('hero_image')['tmp']);
        // dd($this->all());
        return [
            // "category_id" => "required|exists:property_categories,id",
            "title" =>  "required|string|max:255",
            "slug" => "required|regex:/^[a-z0-9-]+$/|string|max:255|unique:properties",
            "short_description" => "required|string|max:1000",
            "description" => "required|string|max:10000",
            "private_notes" => "nullable|string|max:1000",

            'property_status_id' => "required|exists:property_statuses,id",
            'project_id' => "nullable|integer|exists:projects,id",
            'construction_type' => "required",
            "property_availability_date" => "nullable|date",

            "country" => "required",
            "state" => "required",
            "city" => "required",
            "street" => "required",
            "building_number" => "nullable",
            "postal_code" => "required|numeric",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",

            "bedrooms" => "required|integer|min:0",
            "bathrooms" => "required|integer|min:0",
            "floors" => "required|integer|min:0",
            "parkings"=> "required|integer|min:0",
            "area" => "required|integer|min:0",
            'unit_id' => "required|exists:property_length_units,id",

            "base_price" => "required|numeric|min:0",
            "offer_price" => "required|numeric|min:0",

            'property_types' => "required|array|min:1",
            'property_types.*' => "required|exists:property_types,id",
            "features" => "required|array|min:1",
            "features.*" => "required|exists:property_features,id",

            "facilities_distance.*.facility" => "required|integer|exists:nearby_facilities,id",
            "facilities_distance.*.distance" => "required|integer|min:0",
            "facilities_distance.*.unit_id" => "required|exists:property_length_units,id",

            "custom_fields.*.field_title" => 'required|string|max:255',
            "custom_fields.*.field_value" => 'required|string|max:255',

            "video_link" => "nullable|url",

            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string|max:500',
            'seo_indexing' => 'required|boolean',

            'agent_id' => 'required|exists:agents,id',
            //'moderation_status' => 'required|string',

            'publish_start_date' => 'nullable|date',
            'publish_end_date' => 'nullable|date',
            'is_published' => 'required|boolean',
            'has_ads' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'is_active' => 'required|boolean',

            // image validations for 5 images
            // hero image, image_360, floor_plan_images, project_gallery
            // seo_image
        ];
    }

    public function messages(): array
    {
        return [
            "facilities_distance.*.facility.required" => "The facility field is required.",
            "facilities_distance.*.distance.required" => "The distance field is required.",
            "facilities_distance.*.unit_id.required" => "The unit field is required.",

            "custom_fields.*.field_title.required" => "The title field is required.",
            "custom_fields.*.field_value.required" => "The value field is required.",
        ];
    }

}
