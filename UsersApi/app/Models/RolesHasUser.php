<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 10 Sep 2020 16:07:15 +0000.
 */

namespace App\Models;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Model;

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
		return $this->belongsTo(\App\Models\Roles::class, 'role_id');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\Users::class, 'user_id');
	}

	public function privileges()
	{
		return $this->hasMany(\App\Models\Privilege::class, 'roles_has_users_id');
	}

    /** 
     * Create a roleHasUser api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public static function createRoleHasUser($user){ 
        try {
            $input = array();
            $role = null;
            switch ($user->type) {
                case 'ELEVE':
                    $role = Roles::getByTitle('Eleve');
                    break;
                case 'PARENT':
                    $role = Roles::getByTitle('Parent');;
                    break;
                default:
                    $role = Roles::getByTitle('Eleve');;
                    break;
            }
            $input['user_id'] = $user->id;
            $input['role_id'] = $role->id;

            $roleHasUser = RolesHasUser::create($input);
            $success['status'] = 'OK'; 
            $success['data'] =  $roleHasUser;

            return $success; 
        }
        catch(\Exception $e){
            $err['errNo'] = 11;
            $err['errMsg'] = $e->getMessage();
            $error['status'] = 'NOK';
            $error['data'] = $err;
            return $error;
       }
    }
}
