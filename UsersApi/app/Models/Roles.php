<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Roles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get all roles
     */
    public static function getAll()
    {
        try {
            $users = Role::all();
            return response()->json($users, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}