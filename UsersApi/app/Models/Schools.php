<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Schools extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'founder'
    ];

    /**
     * Get the user that owns the class.
     */
    public function user()
    {
        return $this->hasOne(Users::class);
    }

    /**
     * Get school by id
     */
    public static function getById($schoolId)
    {
        try {
            $school =Schools::find($schoolId);
            return $school;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get school by title
     */
    public static function getByTitle($schoolTitle)
    {
        try {
            $school = Schools::where('name', $schoolTitle)->first();
            return $school;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all schools
     */
    public static function getAll()
    {
        try {
            $schools = Schools::all();
            return response()->json($schools, Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}