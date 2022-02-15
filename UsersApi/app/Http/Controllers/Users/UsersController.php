<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
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
        return Users::getAll();
    }

    /**
     * Create one new users
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Check if all fields are filled in
        $validator = Validator::make($request->all(), [
            'firstName'     => 'required|max:255',
            'userName'      => 'required|unique:users|max:255',
            'password'      => 'required|min:6',
            'type'          => 'required',
            'class_id'      => '',
            'school_id'     => '',
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Users::register($request);
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
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        return Users::login($request);
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
        return Users::logout($request);
    }

    /**
     * Show a specific user
     * @param user $user
     * @return Response
     */
    public function show($userId)
    {
        return Users::getById($userId);
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
            'lastName'      => 'required|max:255',
            'firstName'     => 'required|max:255',
            'userName'      => 'required|unique:users|max:255',
            'gender'        => 'required|max:20|in:male,female',
            'password'      => 'required|min:6',
            'type'          => 'required',
            'email'         => 'string|email|max:255|unique:users', 
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Users::renew($request, $user);
    }

    /**
     * Delete user information
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        return Users::purge($user);
    }
}
