<?php

namespace App\Http\Controllers\Sommary;

use App\Http\Controllers\Controller;
use App\Models\Sommary;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class SommaryController extends Controller
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
       $sommaries = Sommary::getAll();
       return $this->successResponse($sommaries, Response::HTTP_OK);
    }


    /**
     * Store a single sommariy information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'course_id'  =>  'required',
        //     'title'   =>  'required',
        // ]);

        //Returns an error if a field is not filled
        // if ($validator->fails()) {
        //     $error = implode(", ", $validator->errors()->all());
        //     return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $sommary = Sommary::storeSommary($request->all());

        return $this->successResponse($sommary, Response::HTTP_CREATED);
    }


    /**
     * Storing a single sommary data
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($sommaryId)
    {
        $sommary = Course::showCourse($sommaryId);
        return $this->successResponse($sommary);
    }


    /**
     * @param Request $request
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $sommary)
    {
        $rules = [
            'name'         =>  'max:255',
            'chapter'   =>  'min:1',
            'level'         =>  'min:1',
        ];
        $this->validate($request, $rules);
        $sommary = Course::findOrFail($sommary);
        $sommary->fill($request->all());
        if($sommary->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $sommary->save();
        return $this->successResponse($sommary);
    }


    /**
     * Delete sommary information
     * @param $sommary
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($sommary)
    {
        $sommary = Sommary::findOrFail($sommary);
        $sommary->delete();
        return $this->successResponse($sommary);
    }
}
