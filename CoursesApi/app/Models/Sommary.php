<?php

namespace App\Models;

use App\Models\Subtitle;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Sommary extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'title',
        'course_id'
    ];

    /**
     * Get the course that owns the sommary.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the subtitles for the sommary.
     */
    public function subtitles()
    {
        return $this->hasMany(Subtitle::class);
    }
    // -----------------------------------------------------------------------------------------------------
    // @ Public methods
    // -----------------------------------------------------------------------------------------------------

    /**
     * Get sommary by id
     * 
     * @param sommaryId
     * @return sommary
     */
    public static function getById($sommaryId)
    {
        try {
            $sommary = Category::find($sommaryId);
            return $sommary;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all sommaries
     */
    public static function getAll()
    {
        try {
            $sommaries = Sommary::all();
            return $sommaries;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Store a sommary
     * 
     * @param sommary
     * @return sommary
     */
    public static function storeSommary($data)
    {
        try {
            foreach ($data as $value) {
                $value = (object)$value;

                $input['course_id'] = $value->course_id;
                $input['title'] = $value->title;

                // Persist sommary data in database
                $sommary = Sommary::create($input);

                foreach ($value->subtitles as $value)
                {
                    $params['sommary_id'] = $sommary->id;
                    $params['title'] = $value;

                    // Persist subtitle data in database
                    $subtitle = Subtitle::storeSubtitle($params);
                }

            }
            
            return $sommary;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}
