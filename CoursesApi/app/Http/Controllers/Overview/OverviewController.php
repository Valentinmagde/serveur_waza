<?php

namespace App\Http\Controllers\Overview;

use App\Http\Controllers\Controller;
use App\Models\Overview;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class OverviewController extends Controller
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
       $overviews = Overview::getAll();
       return $this->successResponse($overviews, Response::HTTP_OK);
    }


    /**
     * Store a single overview information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description'  =>  'required',
            'course_id'    =>  'required'
        ]);

        //Returns an error if a field is not filled
        if ($validator->fails()) {
            $error = implode(", ", $validator->errors()->all());
            return response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $overview = Overview::storeOverview($request->all());

        return $this->successResponse($overview, Response::HTTP_CREATED);
    }


    /**
     * Storing a single overview data
     * @param $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($overviewId)
    {
        $overview = Overview::showOverview($overviewId);
        return $this->successResponse($overview);
    }


    /**
     * @param Request $request
     * @param $overview
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $overview)
    {
        $rules = [
            'name'         =>  'max:255',
            'chapter'   =>  'min:1',
            'level'         =>  'min:1',
        ];
        $this->validate($request, $rules);
        $overview = Overview::findOrFail($overview);
        $overview->fill($request->all());
        if($overview->isClean()){
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $overview->save();
        return $this->successResponse($overview);
    }


    /**
     * Delete overview information
     * @param $overview
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($overview)
    {
        $overview = Overview::findOrFail($overview);
        $overview->delete();
        return $this->successResponse($overview);
    }
}
