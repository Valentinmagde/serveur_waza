<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class SommaryService
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


    public function obtainsommaries()
    {
        return $this->performRequest('GET', 'api/sommaries');
    }

    public function createsommary($data)
    {
        return $this->performRequest('POST', 'api/sommaries', $data);
    }

    public function obtainsommary($sommary)
    {
        return $this->performRequest('GET', "api/sommary/{$sommary}");
    }

    public function editsommary($data, $sommary)
    {
        return $this->performRequest('PUT', "api/sommary/{$sommary}", $data);
    }

    public function deletesommary($sommary)
    {
        return $this->performRequest('DELETE', "api/sommary/{$sommary}");
    }
}