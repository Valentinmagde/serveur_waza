<?php

namespace App\Http\Controllers\Sommary;


use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\CourseService;
use App\Services\SommaryService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SommaryController extends Controller
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

    /**
     * The service to consume the courses micro-service
     * @var SommaryService
     */
    public $sommaryService;

    public function __construct(
        courseService $courseService, 
        userService $userService,
        sommaryService $sommaryService)
    {
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->sommaryService = $sommaryService;
    }


    /**
     * Get sommary data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->sommaryService->obtainsommaries());
    }


    /**
     * Save an sommary data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $this->userService->obtainuser($request->user_id);
        return $this->successResponse($this->sommaryService->createsommary($request->all()));
    }


    /**
     * Show a single sommary details
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($sommaryId)
    {
        return $this->successResponse($this->sommaryService->obtainsommary($sommaryId));
    }


    /**
     * Update a single sommary data
     * @param Request $request
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $sommary)
    {
        if(isset($request->id))
        {
            $this->sommaryService->obtainuser($request->id);
        }
        return $this->successResponse($this->sommaryService->editsommary($request->all(),$sommary));
    }


    /**
     * Delete a single sommary details
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($sommary)
    {
        return $this->successResponse($this->sommaryService->deletesommary($sommary));
    }
}
