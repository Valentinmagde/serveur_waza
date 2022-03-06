<?php

namespace App\Http\Controllers\Overview;


use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\CourseService;
use App\Services\OverviewService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class OverviewController extends Controller
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
     * @var OverviewService
     */
    public $overviewService;

    public function __construct(
        courseService $courseService, 
        userService $userService,
        overviewService $overviewService)
    {
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->overviewService = $overviewService;
    }


    /**
     * Get overview data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->overviewService->obtainoverviews());
    }


    /**
     * Save an overview data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $this->userService->obtainuser($request->user_id);
        return $this->successResponse($this->overviewService->createoverview($request->all()));
    }


    /**
     * Show a single overview details
     * @param $overview
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($overviewId)
    {
        return $this->successResponse($this->overviewService->obtainsommary($overviewId));
    }


    /**
     * Update a single overview data
     * @param Request $request
     * @param $overview
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $overview)
    {
        if(isset($request->id))
        {
            $this->overviewService->obtainuser($request->id);
        }
        return $this->successResponse($this->overviewService->editoverview($request->all(),$overview));
    }


    /**
     * Delete a single overview details
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($overview)
    {
        return $this->successResponse($this->overviewService->deletesommary($overview));
    }
}
