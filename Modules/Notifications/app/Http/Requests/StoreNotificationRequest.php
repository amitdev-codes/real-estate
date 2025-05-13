<?php

namespace Modules\Notifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'message' => 'required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'postcode' => 'nullable|string',
            'notification_group_id' => 'required|exists:notification_groups,id',
            'notification_sub_group_ids' => 'nullable|array',
            'property_id' => 'nullable|exists:properties,id',
            'notifiable_id' => 'nullable|integer',
            'notifiable_type' => 'nullable|string',
            'data' => 'nullable|json',
            'reply' => 'nullable|string',
            'replied_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'A message is required.',
            'email.email' => 'Please provide a valid email address.',
            'notification_group_ids.*.exists' => 'One or more selected notification groups do not exist.',
            'notification_sub_group_ids.*.exists' => 'One or more selected notification sub-groups do not exist.',
            'property_id.exists' => 'The selected property does not exist.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Set default values if not provided
        $this->merge([
            'notifiable_id' => $this->notifiable_id ?? 1, // Default to 1 (admin)
            'notifiable_type' => $this->notifiable_type ?? 'App\Models\User', // Default to User model
        ]);
    }


}
