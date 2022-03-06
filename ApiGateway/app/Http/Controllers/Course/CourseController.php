<?php

namespace App\Http\Controllers\Course;


use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\CourseService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the courses micro-service
     * @var CourseService
     */
    public $courseService;

    /**
     *  The service to consume the users micro-service
     * @var $userService;
     */
    public $userService;

    public function __construct(courseService $courseService, userService $userService)
    {
        $this->courseService = $courseService;
        $this->userService = $userService;
    }


    /**
     * Get course data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->courseService->obtaincourses());
    }


    /**
     * Save an course data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $this->userService->obtainuser($request->user_id);
        return $this->successResponse($this->courseService->createcourse($request->all()));
    }


    /**
     * Show a single course details
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($courseId)
    {
        return $this->successResponse($this->courseService->obtaincourse($courseId));
    }


    /**
     * Update a single course data
     * @param Request $request
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $course)
    {
        if(isset($request->user_id))
        {
            $this->userService->obtainuser($request->user_id);
        }
        return $this->successResponse($this->courseService->editcourse($request->all(),$course));
    }


    /**
     * Delete a single course details
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($course)
    {
        return $this->successResponse($this->courseService->deletecourse($course));
    }

}
