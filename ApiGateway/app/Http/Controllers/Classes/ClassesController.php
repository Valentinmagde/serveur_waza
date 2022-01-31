<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Controller;
use App\Services\ClassesService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassesController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the users micro-service
     * @var ClassesService
     */
    public $classesService;

    public function __construct(ClassesService $classesService)
    {
        $this->classesService = $classesService;
    }

    /**
     * Get user data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->classesService->obtainclasses());
    }
}
