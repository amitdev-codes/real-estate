<?php

namespace Modules\Notifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'message' => 'sometimes|required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'postcode' => 'nullable|string',
            'notification_group_id' => 'nullable',
            'notification_sub_group_ids' => 'nullable|array',
            'property_id' => 'nullable|exists:properties,id',
            'notifiable_id' => 'nullable|integer',
            'notifiable_type' => 'nullable|string',
            'data' => 'nullable|json',
            'reply' => 'nullable|string',
            'replied_by' => 'nullable|exists:users,id',
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
