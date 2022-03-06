<?php

namespace App\Models;

use App\Models\FileUpload;
use App\Models\Overview;
use App\Models\Sommary;
use App\Models\Subtitle;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Course extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'chapter', 
        'level',
        'chapterNumber',
        'chapterTitle',
        'content',
        'photo',
        'relevant',
        'overview',
        'slug',
        'state',
        'category_id'
    ];

    /**
     * Get the category associated with the course.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the overview associated with the course.
     */
    public function overview()
    {
        return $this->hasOne(Overview::class);
    }

    /**
     * Get the sommaries associated with the course.
     */
    public function sommaries()
    {
        return $this->hasMany(Sommary::class);
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
    public static function getById($courseId)
    {
        try {
            $course = Course::find($courseId);
            return $course;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Get all courses
     */
    public static function getAll()
    {
        try {
            $courses = Course::all();
            return $courses;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * Store a course
     * 
     * @param course
     * @return course
     */
    public static function storeCourse($request)
    {
        try {
            $param = $request->all();
            return Sommary::storeSommary($param['sommary']);
            // Persist course data in database
            $course = Course::create($param);

            //Test if the pictures exist and if yes then we send them to the server by calling the FileUpload class
            if ($request->file('photo')) {
                $profil = FileUpload::courseFileUpload($request->file("photo"), $course->id, "images");
                if ($profil != "error") {
                    $profil =  url($profil);
                    $param["photo"] = $profil;
                }

                //Update cours
                $user->fill($param);
                $user->save();
            }

            // Get the id of the category
            $category = Category::getById($request['category_id']);
            if(!$category){
                return response()->json('The category does not exist', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            
            $course->category()->associate($category);
            $course->save();

            // Persist general information
            // $input['description'] = $param['description'];
            // $input['requirement'] = $param['requirement'];
            // $input['toLearn'] = $param['toLearn'];
            // $input['course_id'] = $course->id;
            
            // $overview = Overview::storeOverview($input);
            // $course->overview = $overview;

            return $course;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

     /**
     * Get course by id
     * 
     * @param courseId
     * @return course
     */
    public static function showCourse($courseId)
    {
        try {
            $course = Course::getById($courseId);
            if($course)
            {
                //Get course overview
                $overview = Overview::where('course_id', $courseId)->first();

                //Get course's sommary
                $sommary = Sommary::where('course_id', $courseId)->get();
                if(count($sommary))
                {
                    foreach ($sommary as $value) 
                    {
                        $value = (object)$value;

                        //Get sommary's subtitles
                        $subtitles = Subtitle::where('sommary_id', $value->id)->get();
                        $value->subtitles = $subtitles;
                    }
                }

                $course->overview = $overview;
                $course->sommaries = $sommary;
            }

            return $course;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }
}
