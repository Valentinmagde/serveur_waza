<?php

namespace App\Traits;

use GuzzleHttp\Client;
use App\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\OauthRefreshToken;
use App\Models\OauthAccessToken;

trait PassportService
{
    use ApiResponser;

    /**
     * Get token
     * 
     * @param $request
     * @param $requestUrl
     * @return string
     */
    public function getToken($method, $requestUrl, $formParams, $headers = [])
    {
        $http = new Client();

        try {

            $user = User::where('userName', $formParams['userName'])->first();

            if ($user && Hash::check($formParams['password'], $user->password)) {
                $response = $http->post(config('services.passport.login_endpoint'), array(
                    'form_params' => array(
                        'grant_type' => 'password',
                        'client_id' => config('services.passport.client_id'),
                        'client_secret' => config('services.passport.client_secret'),
                        'username' => $user->email,
                        'password' => $formParams['password']
                    )
                ));
                return $response->getBody();
            } else {
                abort(Response::HTTP_NOT_FOUND);
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === Response::HTTP_BAD_REQUEST) {
                return $this->successResponse('Invalid Request. Please enter a username or a password.', $e->getCode());
            }

            if ($e->getCode() === Response::HTTP_UNAUTHORIZED ) {
                return $this->successResponse('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return $this->successResponse('Something went wrong on the server.', $e->getCode());
        }
    }

    /**
     * Refresh the token
     * 
     * @param $request
     * @param $requestUrl
     * @return string
     */
    public function refreshToken($method, $requestUrl, $formParams, $headers = [])
    {
        $http = new Client();

        try {

            $response = $http->post(config('services.passport.login_endpoint'), array(
                'form_params' => array(
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $formParams['refresh_token'],
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret')
                )
            ));
            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === Response::HTTP_BAD_REQUEST) {
                return $this->successResponse('Invalid Request. Please enter a username or a password.', $e->getCode());
            }

            if ($e->getCode() === Response::HTTP_UNAUTHORIZED ) {
                return $this->successResponse('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return $this->successResponse('Something went wrong on the server.', $e->getCode());
        }
    }

    /**
     * Revoking Token
     * 
     * @param $request
     * @param $requestUrl
     * @return string
     */
    public function revokeToken()
    {
        try{
            $token = Auth::user()->token()->delete();
            $token->revoke();
            $response = ['message' => 'You have been successfully logged out!'];
            return $this->successResponse($response, Response::HTTP_OK);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}