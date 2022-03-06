<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Subtitle extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'title',
        'sommary_id' 
    ];

    /**
     * Get the sommary that owns the subtile.
     */
    public function sommary()
    {
        return $this->belongsTo(Sommary::class);
    }

    // -----------------------------------------------------------------------------------------------------
    // @ Public methods
    // -----------------------------------------------------------------------------------------------------

    /**
     * Get course by id
     * 
     * @param courseId
     * @return course
     */
    public static function getById($categoryId)
    {
        try {
            $course = Category::find($categoryId);
            return $course;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all subtiles
     */
    public static function getAll()
    {
        try {
            $subtitle = Subtile::all();
            return $subtitle;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Store a subtitle
     * 
     * @param subtitle
     * @return subtitle
     */
    public static function storeSubtitle($request)
    {
        try {
            // Persist subtitle data in database
            $subtitle = Subtitle::create($request);
            return $subtitle;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}
