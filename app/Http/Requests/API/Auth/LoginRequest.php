<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email:rfc,dns', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required',
            'email.email'       => 'Email must be a valid email address',
            'email.exists'      => 'Credentials do not match our records',
            'password.required' => 'Password is required',
            'password.string'   => 'Password must be a string',
        ];
    }
}
