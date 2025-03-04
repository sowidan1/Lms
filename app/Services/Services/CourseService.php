<?php

namespace App\Services\Services;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == User::ROLE_STUDENT) {
            $courses = Course::whereHas('subscriptions', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', Course::ACTIVE_STATUS);
            })->cursorPaginate(15);
        } else {
            $courses = Course::with('instructor')->cursorPaginate(15);
        }

        return apiSuccess(
            data   : ['courses' => $courses],
            message: 'Courses retrieved successfully',
            code   : 200
        );
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        $user = Auth::user();

        if ($user->role === User::ROLE_STUDENT) {
            if (!$course->subscriptions()->where('user_id', $user->id)->where('status', Course::ACTIVE_STATUS)->exists()) {
                return apiError(
                    error: 'Unauthorized to view this course',
                    code : 403
                );
            }
        }

        $course->load('instructor');

        return apiSuccess(
            data   : ['course' => $course],
            message: 'Course retrieved successfully',
            code   : 200
        );
    }

    public function store($validated)
    {
        $instructor = User::findOrFail($validated['instructor_id']);
        if ($instructor->role !== User::ROLE_INSTRUCTOR) {
            return apiError(
                error: 'Selected user must have the instructor role',
                code : 403
            );
        }

        $course = Course::create($validated);

        return apiSuccess(
            data   : $course,
            message: 'Course created successfully',
            code   : 201
        );
    }

    public function update($validated, $id)
    {
        $course = Course::findOrFail($id);

        if (isset($validated['instructor_id'])) {
            $instructor = User::findOrFail($validated['instructor_id']);
            if ($instructor->role !== User::ROLE_INSTRUCTOR) {
                return apiError(
                    error: 'Selected user must have the instructor role',
                    code : 403
                );
            }
        }

        $course->update($validated);

        return apiSuccess(
            data   : $course->fresh(),
            message: 'Course updated successfully',
            code   : 200
        );
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return apiSuccess(
            message: 'Course deleted successfully',
            code   : 200
        );
    }
}
