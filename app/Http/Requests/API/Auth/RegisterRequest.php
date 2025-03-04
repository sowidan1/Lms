<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role'     => ['required', 'in:instructor,student']
        ];
    }
}
