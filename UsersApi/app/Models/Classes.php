<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Classes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * Get the user that owns the class.
     */
    public function user()
    {
        return $this->hasOne(Users::class);
    }


    /**
     * Get class by id
     */
    public static function getById($classId)
    {
        try {
            $class = Classes::find($classId);
            return $class;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
    /**
     * Get class by title
     */
    public static function getByTitle($classTitle)
    {
        try {
            $class = Classes::where('title', $classTitle)->first();
            return $class;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all classes
     */
    public static function getAll()
    {
        try {
            $classes = Classes::all();
            return response()->json($classes, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}