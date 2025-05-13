<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // dd($this->all());
        return [
            "name" =>  "required|string|max:255",
            "agency_id" => "required|exists:agencies,id",
            "slug" => "required|regex:/^[a-z0-9-]+$/|string|max:255",
            "short_description" => "required|string|max:1000",
            "description" => "required|string|max:10000",

            'property_types' => "required|array|min:1",
            'property_types.*' => "required|exists:property_types,id",
            "features" => "required|array|min:1",
            "features.*" => "required|exists:property_features,id",
            'construction_type' => "required",
            'project_status_id' => "required|exists:project_statuses,id",

            "total_blocks" => "required|integer|min:1",
            "total_buildings" => "required|integer|min:1",
            "total_floors" => "required|integer|min:1",
            "total_flats" => "required|integer|min:1",
            "total_area" => "required|numeric|min:1",
            'unit_id' => "required|exists:property_length_units,id",

            "lowest_price" => "nullable|numeric|min:1",
            "max_price" => "nullable|numeric|min:1|gte:lowest_price",

            "project_start_date" => "nullable|date",
            "project_finish_date" => "nullable|date|after:project_start_date",
            "project_sale_start_date" => "nullable|date|after:project_start_date",
            "property_availability_date" => "nullable|date|after:project_start_date",

            "developer_id" => "nullable|exists:property_developers,id",

            "developer_name" => "required_without:developer_id|nullable|string|max:255",
            "developer_email" => "required_without:developer_id|nullable|email",
            "developer_phone" => "required_without:developer_id|nullable|string|max:255",
            "developer_website" => "required_without:developer_id|nullable|string|max:255",

            "country" => "required_without:developer_id|nullable",
            "state" => "required_without:developer_id",
            "city" => "required_without:developer_id",
            "street" => "required_without:developer_id",
            "building_number" => "nullable",
            "postal_code" => "required_without:developer_id",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",

            "video_link" => "nullable|url",

            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string|max:500',
            'seo_indexing' => 'required|boolean',

            'publish_start_date' => 'required|date',
            'publish_end_date' => 'required|date|after:publish_start_date',
            'is_published' => 'required|boolean',
            'has_ads' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'is_active' => 'required|boolean',


            // image validations for 5 images
            // hero image, image_360, floor_plan_images, project_gallery
            // seo_image
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            // 'video_links.*.platform' => 'Platform field',
            // 'video_links.*.videoId' => 'Video ID field',
            // 'video_links.*.linkType' => 'Link type field',
            // 'quick_links.*.title' => 'Link title field',
            // 'quick_links.*.url' => 'Link URL field',
            // 'email_env' => 'Email field',
            // 'api_secrets.*.platform' => 'Platform field',
            // 'api_secrets.*.clientID' => 'client ID field',
            // 'api_secrets.*.secret' => 'secret field',
            // 'announcement_content' => 'Content',
            // 'announcement_display' => 'Display',
        ];
    }

    public function messages()
    {
        return [
            'city.required_without' => 'The :attribute field is required.',
            'state.required_without' => 'The :attribute field is required.',
            'street.required_without' => 'The :attribute field is required.',
            'postal_code.required_without' => 'The :attribute field is required.',
            // 'announcement_content.array' => 'The :attribute must be a valid array.',
            // 'announcement_content.min' => 'You must select at least one option in the :attribute field.',
            // 'announcement_display.required_if' => 'The :attribute field is required.',

            "developer_name.required_without" => "The :attribute field is required.",
            "developer_email.required_without" => "The :attribute field is required.",
            "developer_phone.required_without" => "The :attribute field is required.",
            "developer_website.required_without" => "The :attribute field is required.",
        ];
    }
}
