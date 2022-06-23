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

    public function getRecommended()
    {
        $courses = Course::inRandomOrder()->limit(5)->get();

        foreach ($courses as $co) {
            $co->hoster = Host::find($co->host);
        }

        return response()->json([
            "success" => true,
            "message" => "Courses recommended found",
            "data" => $courses
        ], 200);


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

    public function getFavoriteCourses(Request $request)
    {
        $sql = "SELECT courses.*, favorites.course_id, favorites.user_id, hosts.name AS host_name FROM courses 
                INNER JOIN favorites ON courses.id = favorites.course_id
                INNER JOIN hosts     ON courses.host = hosts.id
                WHERE favorites.user_id = $request->user_id";

        $query = DB::select($sql);

        return response()->json([
            "success" => true,
            "message" => "Favs found",
            "favorites" => $query
        ], 200);
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

    public function getCoursesByHost(Request $request)
    {

        $sql = "SELECT categories.name as cat_name , courses.* FROM courses
                    INNER JOIN categories ON categories.id = courses.category_id
                    WHERE courses.host = $request->host_id";

        $courses = DB::select($sql);


        return response()->json([
            "success" => true,
            "message" => "Courses found",
            "data" => $courses
        ], 200);
    }


}
