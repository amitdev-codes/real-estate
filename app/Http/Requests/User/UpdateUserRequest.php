<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->user->id,
            'mobile_no' => 'sometimes|required|string',
            'password' => 'nullable|min:8|confirmed',
            'role' => 'sometimes|required|exists:roles,id',
            'license_number' => 'required_if:role,3', // Assuming 2 is Agent role ID
            'agency_id' => 'required_if:role,4',// Assuming 3 is Agency role ID
            'status_id'=>'nullable',
            // 'approval_status' => 'in:pending,approved,rejected',
            // 'remarks' => $this->input('approval_status') === 'rejected' ? 'required|string|max:500' : 'nullable',
        ];
    }
}
