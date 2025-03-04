<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class InstructorRole implements Rule
{
    public function passes($attribute, $value)
    {
        $user = User::find($value);
        return $user && $user->hasRole('instructor');
    }

    public function message()
    {
        return 'The selected :attribute must belong to a user with the instructor role.';
    }
}
