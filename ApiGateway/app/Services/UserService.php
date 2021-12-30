<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class UserService
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
     * Obtain the full list of user from the user service
     */
    public function obtainusers()
    {
        return $this->performRequest('GET', '/users');
    }

    /**
     * Create user
     */
    public function createuser($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    /**
     * Get a single user data
     */
    public function obtainuser($user)
    {
        return $this->performRequest('GET', "/users/{$user}");
    }

    /**
     * Edit a single user data
     */
    public function edituser($data, $user)
    {
        return $this->performRequest('PUT', "/users/{$user}", $data);
    }

    /**
     * Delete an user
     */
    public function deleteuser($user)
    {
        return $this->performRequest('DELETE', "/users/{$user}");
    }
}