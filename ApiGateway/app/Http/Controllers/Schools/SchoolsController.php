<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Services\SchoolsService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SchoolsController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the users micro-service
     * @var SchoolsService
     */
    public $schoolsService;

    public function __construct(SchoolsService $schoolsService)
    {
        $this->schoolsService = $schoolsService;
    }

    /**
     * Get user data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->schoolsService->obtainschools());
    }
}
