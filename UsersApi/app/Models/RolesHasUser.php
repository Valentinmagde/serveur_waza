<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 10 Sep 2020 16:07:15 +0000.
 */

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Class RoleHasUser
 * 
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * 
 * @property \App\Models\Role $role
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $privileges
 *
 * @package App\Models
 */
class RolesHasUser extends Model
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'role_id'
	];

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class, 'role_id');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

	public function privileges()
	{
		return $this->hasMany(\App\Models\Privilege::class, 'roles_has_users_id');
	}

    /** 
     * Create a memberHasUser api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public static function createRoleHasUser($request){
        $input = $request->all(); 
        try {
            $member = RolesHasUser::create($input);
            $success['status'] = 'OK'; 
            $success['data'] =  $member;

            return response()->json($success,200); 
        }
        catch(\Exception $e){
            $err['errNo'] = 11;
            $err['errMsg'] = $e->getMessage();
            $error['status'] = 'NOK';
            $error['data'] = $err;
            return response()->json($error, 400);
       }
    }
}
