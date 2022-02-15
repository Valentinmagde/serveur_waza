<?php

namespace App\Services;

use App\Traits\PassportService;

class AuthService
{
    use PassportService;

    /**
     * The base uri to consume authentication service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.gateway.base_uri');
    }


    /**
     * Obtain the access token
     */
    public function auth($data)
    {
        return $this->getToken('POST', '/oauth/token', $data);
    }

    /**
     * Refresh the access token
     */
    public function refresh($data)
    {
        return $this->refreshToken('POST', '/oauth/token', $data);
    }

    /**
     * Get the current logged in user data
     */
    public function currentLogged()
    {
        return $this->getUserLogged();
    }

    /**
     * Revoking the token
     */
    public function revoke()
    {
        return $this->revokeToken();
    }
}