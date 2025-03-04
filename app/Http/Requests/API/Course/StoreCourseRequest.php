<?php

namespace App\Http\Requests\API\Course;

use App\Rules\InstructorRole;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|max:2000',
            'price'         => 'required|numeric|min:0|max:9999.99',
            'instructor_id' => [
                'required',
                'exists:users,id',
                new InstructorRole
            ],
        ];
    }
}
