<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class CourseService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume authors service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to course api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.courses.base_uri');
        $this->secret = config('services.courses.secret');
    }


    public function obtaincourses()
    {
        return $this->performRequest('GET', 'api/courses');
    }

    public function createcourse($data)
    {
        return $this->performRequest('POST', 'api/courses', $data);
    }

    public function obtaincourse($course)
    {
        return $this->performRequest('GET', "api/course/{$course}");
    }

    public function editcourse($data, $course)
    {
        return $this->performRequest('PUT', "api/course/{$course}", $data);
    }

    public function deletecourse($course)
    {
        return $this->performRequest('DELETE', "api/course/{$course}");
    }
}