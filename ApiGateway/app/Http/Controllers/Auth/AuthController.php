<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the passport service
     * @var AuthService
     */
    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Get token access data
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        return $this->successResponse($this->authService->auth($request->all()));
    }

    /**
     * Refresh token 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        return $this->successResponse($this->authService->refresh($request->all()));
    }

    /**
     * Revoke token 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->successResponse($this->authService->revoke());
    }

    /**
     * Authenticated user
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticatedUser()
    {
        return $this->successResponse($this->authService->currentLogged());
    }
}
