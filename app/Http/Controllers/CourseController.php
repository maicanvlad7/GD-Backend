<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Host;
use App\Models\User;
use App\Models\Progress;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function getBySlug($slug)
    {
        $course =  Course::where(DB::raw('lower(name)'), str_replace('-',' ', $slug))->first();

        if($course) {
            return response()->json([
                "success" => true,
                "message" => "Course details founds",
                "data" => $course
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Course does not exist"
            ], 200);
        }

    }

    public function getById(Request $request, $id)
    {
        $course = Course::where('id', $id)->with(['lessons','reviews'])->first();
        $course->hoster = Host::find($course->host);

        foreach($course->reviews as $cr) {
            $review_user = User::select(['name','email'])->where('id', $cr->user_id)->first();
            $cr->user = $review_user;
        }

        if(isset($request->user_id) && !empty($request->user_id)) {
            foreach($course->lessons as $cl) {
                $progress = Progress::where('lesson_id', $cl->id)->where('user_id', $request->user_id)->first();

                $cl->progress = new \stdClass();

                if(isset($progress->completed)) {
                    $cl->progress->completed = $progress->completed;
                    $cl->progress->percent = $progress->percent;
                }else {
                    $cl->progress->completed = 0;
                    $cl->progress->percent  = 0;
                }
            }
        }



        if($course) {
            return response()->json([
                "success" => true,
                "message" => "Course details founds",
                "data" => $course
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Course does not exist"
            ], 200);
        }
    }


}
