<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the users micro-service
     * @var UserService
     */
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get user data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->userService->obtainusers());
    }

    /**
     * Save an user data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->userService->createuser($request->all()));
    }
    
    /**
     * Show a single user details
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user)
    {
        return $this->successResponse($this->userService->obtainuser($user));
    }


    /**
     * Update a single user data
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        return $this->successResponse($this->userService->edituser($request->all(),$user));
    }


    /**
     * Delete a single user details
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        return $this->successResponse($this->userService->deleteuser($user));
    }
}
