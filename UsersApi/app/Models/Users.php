<?php

namespace App\Models;

use App\Models\Classes;
use App\Models\Schools;
use Illuminate\Http\Request;
use App\Models\RolesHasUser;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Users extends Model implements AuthenticatableContract, AuthorizableContract
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
        'type',
        'parentEmail',
        'agreement',
        'class_id',
        'school_id'
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    /**
     * Get the class associated with the user.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    /**
     * Get the school associated with the user.
     */
    public function school()
    {
        return $this->belongsTo(Schools::class);
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
            $user = Users::find($userId);
            return response()->json($user, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all users
     */
    public static function getAll()
    {
        try {
            $users = Users::all();
            return response()->json($users, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            // Encode the password
            $request['password']=Hash::make($request['password']);

            // Create a random email if it does not exist
            if(!$request['email']){
                $request['email'] = strtolower($request['userName']).'@gmail.com';
            }

            // Send an email to parent
            if($request['parentEmail']){
                $data = array(
                    'body'=>"Votre enfant $request[firstName] vous invite à s'inscrire sur la plateforme wazala veuillez cliquez sur ce lien $request[url] pour vous inscrire",
                    'to'=>$request['parentEmail']
                );
                Mail::raw($data['body'], function($message) use($data) {
                    $message->to($data['to'], 'Tutorials Point')
                    ->subject('Demande d\'inscription sur la plateforme wazala');
                    $message->from('wazala.inc@gmail.com','Wazala.inc');
                });
            }

            // Persist user data in database
            $user = Users::create($request->all());

            // Associate the appropriate role with the new user
            RolesHasUser::createRoleHasUser($user);

            if($request['type'] === 'ELEVE'){
                // Get the id of the class if it exists
                $class = Classes::getById($request['class_id']);
                if(!$class){
                    return response()->json('The class does not exist', Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                // Get the id of the school if it exists
                $school = Schools::getById($request['school_id']);
                if(!$school){
                    return response()->json('The school does not exist', Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                
                $user->class()->associate($class);
                $user->school()->associate($school);
                $user->save();
            }

            return response()->json($user, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $user = Users::where('email', $request->userName)->orWhere('userName', $request->userName)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response()->json($response, Response::HTTP_OK);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json($response, Response::HTTP_OK);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $user = Users::find($userId);
            $user->fill($request->all());
            if($user->isClean()){
                return ApiResponser::errorResponse("Atleast one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user->save();
            return $this->successResponse($user, Response::HTTP_OK);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete user
     * @param userId
     */
    public static function purge($userId)
    {
        try{
            $user = Users::find($userId);
            $user->delete();
            return response()->json($user, Response::HTTP_NO_CONTENT);
        }catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
