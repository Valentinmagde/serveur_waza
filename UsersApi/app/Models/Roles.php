<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Users::class);
    }

    /**
     * Get all roles
     */
    public static function getAll()
    {
        try {
            $roles = Roles::all();
            return $roles;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get role by title
     */
    public static function getByTitle($roleTitle)
    {
        try {
            $role = Roles::where('title', $roleTitle)->first();
            return $role;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}