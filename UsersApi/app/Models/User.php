<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, ApiResponser;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastName',
        'firstName',
        'userName',
        'password',
        'gender',
        'email',
        'phone',
        'birthday',
        'avatar',
        'level',
        'type',
        'currentSchool'
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // -----------------------------------------------------------------------------------------------------
    // @ Public methods
    // -----------------------------------------------------------------------------------------------------

    /**
     * Get user by id
     * 
     * @param userId
     * @return user
     */
    public static function getById($userId)
    {
        try {
            $user = User::find($userId);
            return ApiResponser::successResponse($user, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all users
     */
    public static function getAll()
    {
        try {
            $users = User::all();
            return ApiResponser::successResponse($users, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store an user
     * 
     * @param user
     * @return user
     */
    public static function register($request)
    {
        try {
            $request['password']=Hash::make($request['password']);

            if(!$request['email']){
                $request['email'] = $request['userName'].'@gmail.com';
            }
    
            // Persist user data in database
            $user = User::create($request->all());

            return ApiResponser::successResponse($response, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log in the user
     * 
     * @param $request
     * @return user
     */
    public static function login($request)
    {
        try {
            $user = User::where('email', $request->userName)->orWhere('userName', $request->userName)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return ApiResponser::successResponse($response, Response::HTTP_OK);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return ApiResponser::successResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return ApiResponser::successResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log out the user
     * 
     * @param $request
     */
    public static function logout($request)
    {
        try{
            $token = $request->user()->token();
            $token->revoke();
            $response = ['message' => 'You have been successfully logged out!'];
            return ApiResponser::successResponse($response, Response::HTTP_OK);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the user
     * 
     * @param user
     * @return user
     */
    public static function renew($request, $userId)
    {
        try{
            $user = User::find($userId);
            $user->fill($request->all());
            if($user->isClean()){
                return ApiResponser::errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user->save();
            return $this->successResponse($user, Response::HTTP_OK);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete user
     * @param userId
     */
    public static function purge($userId)
    {
        try{
            $user = User::find($userId);
            $user->delete();
            return ApiResponser::successResponse($user, Response::HTTP_NO_CONTENT);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return ApiResponser::successResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
