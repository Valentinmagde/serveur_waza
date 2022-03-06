<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Overview extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'description',
        'requirement',
        'toLearn',
        'course_id'
    ];

    /**
     * Get the course that owns the overview.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // -----------------------------------------------------------------------------------------------------
    // @ Public methods
    // -----------------------------------------------------------------------------------------------------

    /**
     * Get overview by id
     * 
     * @param overviewId
     * @return overview
     */
    public static function getById($categoryId)
    {
        try {
            $overview = Overview::find($categoryId);
            return $overview;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all overview
     */
    public static function getAll()
    {
        try {
            $overviews = Overview::all();
            return $overviews;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Store an overview
     * 
     * @param overview
     * @return overview
     */
    public static function storeOverview($data)
    {
        try {
            // Persist overview data in database
            $overview = Overview::create($data);
            return $overview;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}
