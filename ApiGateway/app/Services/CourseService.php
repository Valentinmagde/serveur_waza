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
     * Authorization secret to pass to book api
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
        return $this->performRequest('GET', '/courses');
    }

    public function createBook($data)
    {
        return $this->performRequest('POST', '/courses', $data);
    }

    public function obtainBook($book)
    {
        return $this->performRequest('GET', "/courses/{$book}");
    }

    public function editBook($data, $book)
    {
        return $this->performRequest('PUT', "/courses/{$book}", $data);
    }

    public function deleteBook($book)
    {
        return $this->performRequest('DELETE', "/courses/{$book}");
    }
}