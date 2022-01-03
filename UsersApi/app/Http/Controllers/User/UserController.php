<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
    * Return full list of users
    * @return Response
    */
    public function index()
    {
        return User::getAll();
    }

    /**
     * Create one new users
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json('$error', Response::HTTP_UNPROCESSABLE_ENTITY);
        // Check if all fields are filled in
        $validator = Validator::make($request->all(), [
            'lastName'      => 'required|string|max:255',
            'firstName'     => 'required|string|max:255',
            'userName'      => 'required|string|max:255',
            'gender'        => 'required|max:20|in:male,female',
            'password'      => 'required|string|min:6|confirmed',
            'email'         => 'string|email|max:255|unique:users', 
            'phone',
            'birthday',
            'avatar', 
            'level',
            'type',
            'currentSchool',
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return User::register($request);
    }

    /**
     * Log in the user
     * 
     * @param $request
     * @return user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        return User::login($request);
    }

    /**
     * Log out the user
     * 
     * @param $request
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return User::logout($request);
    }

    /**
     * Show a specific user
     * @param user $user
     * @return Response
     */
    public function show($userId)
    {
        return User::getById($userId);
    }


    /**
     * Update user information
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        // Check if all fields are filled in
        $validator = Validator::make($request->all(),[
            'lastName'      => 'required|string|max:255',
            'firstName'     => 'required|string|max:255',
            'userName'      => 'required|max:254',
            'gender'        => 'required|max:20|in:male,female',
            'password'      => 'required|max:254',
            'email', 
            'phone',
            'birthday',
            'avatar', 
            'level',
            'type',
            'currentSchool', 
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return User::renew($request, $user);
    }

    /**
     * Delete user information
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        return User::purge($user);
    }
}
