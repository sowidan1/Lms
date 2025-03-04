<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Course\StoreCourseRequest;
use App\Http\Requests\API\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('student')) {
            $courses = $user->courses()->wherePivot('status', Course::ACTIVE_STATUS)->cursorPaginate(15);
        } else {
            $courses = Course::with('instructor')->cursorPaginate(15);
        }

        return apiSuccess(
            data: ['courses' => $courses],
            message: 'Courses retrieved successfully',
            code: 200
        );
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        $user = Auth::user();

        if ($user->hasRole('student')) {
            if (!$user->courses()->where('course_id', $course->id)
                ->where('status', Course::ACTIVE_STATUS)->exists()) {
                return apiError(
                    error: 'Unauthorized to view this course',
                    code: 403
                );
            }
        }

        $course->load('instructor');

        return apiSuccess(
            data: ['course' => $course],
            message: 'Course retrieved successfully',
            code: 200
        );
    }

    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        $course = Course::create([
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'price'         => $validated['price'],
            'instructor_id' => $validated['instructor_id']
        ]);

        return apiSuccess(
            data: $course,
            message: 'Course created successfully',
            code: 201
        );
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validated();

        if (isset($validated['instructor_id'])) {
            $instructor = User::findOrFail($validated['instructor_id']);
            if (!$instructor->hasRole('instructor')) {
                return apiError(
                    error: 'Selected user must have the instructor role',
                    code: 403
                );
            }
        }

        $course->update($validated);

        return apiSuccess(
            data: $course->fresh(),
            message: 'Course updated successfully',
            code: 200
        );
    }

    public function destroy(Course $course)
    {
        $user = Auth::user();
        if ($user->hasRole('student')) {
            return apiError(
                error: 'Unauthorized to delete this course',
                code : 403
            );
        }

        $course->delete();

        return apiSuccess(
            data   : [],
            message: 'Course deleted successfully',
            code   : 204
        );
    }
}
