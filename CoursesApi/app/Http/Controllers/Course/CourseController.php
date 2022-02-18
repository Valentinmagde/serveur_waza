<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class CourseController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $courses = Course::getAll();
       return $this->successResponse($courses, Response::HTTP_OK);
    }


    /**
     * Store a single course information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chapterNumber'  =>  'required',
            'chapterTitle'   =>  'required',
            'content'        =>  'required',
            'level'          =>  'required',
            'category_id'    =>  'required'
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $course = Course::storeCourse($request);

        return $this->successResponse($course, Response::HTTP_CREATED);
    }


    /**
     * Storing a single course data
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($course)
    {
        $course = Course::findOrFail($course);
        return $this->successResponse($course);
    }


    /**
     * @param Request $request
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $course)
    {
        $rules = [
            'name'         =>  'max:255',
            'chapter'   =>  'min:1',
            'level'         =>  'min:1',
        ];
        $this->validate($request, $rules);
        $course = Course::findOrFail($course);
        $course->fill($request->all());
        if($course->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $course->save();
        return $this->successResponse($course);
    }


    /**
     * Delete course information
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($course)
    {
        $course = Course::findOrFail($course);
        $course->delete();
        return $this->successResponse($course);
    }
}
