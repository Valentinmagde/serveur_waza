<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class SchoolsService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume users service
     * @var string
     */
    public $baseUri;

    /**
     * userization secret to pass to user api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.users.base_uri');
        $this->secret = config('services.users.secret');
    }


    /**
     * Obtain the full list of schools from the user service
     */
    public function obtainschools()
    {
        return $this->performRequest('GET', 'api/schools');
    }
}