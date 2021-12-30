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
        $users = User::all();
        return $this->successResponse($users);
    }


    /**
     * Create one new users
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'lastName'  => 'required|max:254',
            'firstName' => 'required|max:254',
            'gender'    => 'required|max:20|in:male,female',
            'country'   => 'required|max:254',
            'password'  => 'required|max:254',
            'email'     => 'required|email', 
            'phone'     => 'required|max:254',
        ];

        $this->validate($request, $rules);

        $user = User::create($request->all());

        return $this->successResponse($user, Response::HTTP_CREATED);
    }


    /**
     * Show a specific user
     * @param user $user
     * @return Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);
        return $this->successResponse($user);
    }


    /**
     * Update user information
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'lastName'  => 'required|max:254',
            'firstName' => 'required|max:254',
            'gender'    => 'required|max:20|in:male,female',
            'country'   => 'required|max:254',
            'password'  => 'required|max:254',
            'email'     => 'required|email', 
            'phone'     => 'required|max:254',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($user);
        $user->fill($request->all());
        if($user->isClean()){
            return $this->errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->successResponse($user);
    }


    /**
     * Delete user information
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return $this->successResponse($user);
    }
}
