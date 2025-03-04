<?php

namespace App\Http\Requests\API\payment;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCheckOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id'
        ];
    }
}
