<?php

namespace App\Traits;

use GuzzleHttp\Client;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\Classes;
use App\Models\Schools;
use App\Models\RolesHasUser;
use App\Models\Roles;
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

            $user = Users::where('userName', $formParams['userName'])->first();
            $roleHasUser = RolesHasUser::where('user_id', $user->id)->first();
            $role = null;
            $class = null;
            $school = null;

            if($roleHasUser){
               $role = Roles::find($roleHasUser->role_id); 
            }

            // Get user class and school
            if($role && $role->title === 'Eleve'){
                // Get the id of the class if it exists
                $class = Classes::where('id', $user->class_id)->first();

                // Get the id of the school if it exists
                $school = Schools::where('id', $user->school_id)->first();
                
                $user->class = $class;
                $user->school = $school;
            }

            if ($user && Hash::check($formParams['password'], $user->password)) {
                $response = $http->post(config('services.passport.login_endpoint'), [
                    'debug' => fopen('php://stderr', 'w'),
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => config('services.passport.client_id'),
                        'client_secret' => config('services.passport.client_secret'),
                        'username' => $user->email,
                        'password' => $formParams['password']
                    ],
                ]);

                $user->role = $role;
                $donnees = json_decode($response->getBody(), true);
                $data['access_token'] = $donnees['access_token'];
                $data['refresh_token'] = $donnees['refresh_token'];
                $data['token_type'] = $donnees['token_type'];
                $data['expires_in'] = $donnees['expires_in'];
                $data['user'] = $user;
                $success['data'] = $data;

                return $success;
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

            return $this->successResponse($e->getMessage(), $e->getCode());
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
            $token = Auth::user()->token();
            $token->revoke();
            $response['message'] = 'You have been successfully logged out!';
            return $response;
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

     /**
     * Get the current logged in user data
     * 
     * @param $request
     * @param $requestUrl
     * @return string
     */
    public function getUserLogged()
    {
        try{
            $user = Auth::user();

            // Get user roles
            $roleHasUser = RolesHasUser::where('user_id', $user->id)->first();
            $role = null;
            $class = null;
            $school = null;

            if($roleHasUser){
               $role = Roles::find($roleHasUser->role_id); 
            }

            // Get user class and school
            if($role && $role->title === 'Eleve'){
                // Get the id of the class if it exists
                $class = Classes::where('id', $user->class_id)->first();

                // Get the id of the school if it exists
                $school = Schools::where('id', $user->school_id)->first();
                
                $user->class = $class;
                $user->school = $school;
            }

            $user->role = $role;
            $data['user'] = $user;
            $success['data'] = $data;
            return $success;
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}