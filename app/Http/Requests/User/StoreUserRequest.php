<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'mobile_no' => [
                'required',
                'string',
                'regex:/^\+[1-9]\d{1,14}$/',
                'unique:users,mobile_no',
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'id')->whereNotIn('name', ['admin', 'superadmin'])
            ],
            'license_number' => 'required_if:role,3|string|max:255|nullable',
            'agency_id' => 'required_if:role,4|string|max:255|nullable',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/',
                'confirmed'
            ],
            'password_confirmation' => 'required',
            'remember_me' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'mobile_no.regex' => 'The mobile number must start with + followed by country code and number (e.g., +61253614785).',
            'role.exists' => 'Please select a valid role.',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (! request()->has('roles')) {
                $userRole = \Spatie\Permission\Models\Role::where('name', 'user')->first();
                if ($userRole) {
                    request()->merge(['roles' => [$userRole->id]]);
                }
            }
        });
    }
}
