<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class ClassesService
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
     * Obtain the full list of classes from the user service
     */
    public function obtainclasses()
    {
        return $this->performRequest('GET', 'api/classes');
    }
}