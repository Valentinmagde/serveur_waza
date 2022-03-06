<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class OverviewService
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


    public function obtainoverviews()
    {
        return $this->performRequest('GET', 'api/overviews');
    }

    public function createoverview($data)
    {
        return $this->performRequest('POST', 'api/overviews', $data);
    }

    public function obtainoverview($overview)
    {
        return $this->performRequest('GET', "api/overview/{$overview}");
    }

    public function editoverview($data, $overview)
    {
        return $this->performRequest('PUT', "api/overview/{$overview}", $data);
    }

    public function deleteoverview($overview)
    {
        return $this->performRequest('DELETE', "api/overview/{$overview}");
    }
}