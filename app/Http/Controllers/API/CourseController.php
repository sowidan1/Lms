<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Course\StoreCourseRequest;
use App\Http\Requests\API\Course\UpdateCourseRequest;
use App\Services\Services\CourseService;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        return $this->courseService->index();
    }

    public function show($id)
    {
        return $this->courseService->show($id);
    }

    public function store(StoreCourseRequest $request)
    {
        return $this->courseService->store($request->validated());
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        return $this->courseService->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->courseService->destroy($id);
    }
}
