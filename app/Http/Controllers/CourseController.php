<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Free;
use App\Models\Lesson;
use App\Models\Review;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Host;
use App\Models\User;
use App\Models\Progress;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

    public function getRecommended(Request $request)
    {
        //get category of current course
        $cid = $request->course_id;
        $current_course = Course::where('id', $cid)->first();
        $current_category = $current_course->category_id;

        //get recommended from same category but not current course
        $courses = Course::where('coming_soon', 0)->where('id','!=',$cid)->where('category_id', $current_category)->inRandomOrder()->limit(5)->get();

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
            $review_user = User::select(['name','email','level'])->where('id', $cr->user_id)->first();
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

    public function getMostViewed()
    {
        $sql = "SELECT hosts.name AS host_name, courses.* FROM courses
                INNER JOIN hosts ON courses.host = hosts.id
                ORDER BY views DESC
                LIMIT 5";

        $courses = DB::select($sql);

        return response()->json([
            "success" => true,
            "message" => "Most viewed courses found",
            "data" => $courses
        ], 200);
    }

    public function getComingSoon()
    {
        $courses = Course::select('id','image','name','cktag')->where('coming_soon','1')->get();

        return response()->json([
            "success" => true,
            "message" => "Coming soon courses found",
            "data" => $courses
        ], 200);

    }

    public function getUserVideoStats(Request $request)
    {
        $uid = $request->user_id;

        if(!$uid) return 0;

        //started courses
        $wnSql = "SELECT course_id FROM progress WHERE user_id = $uid GROUP BY course_id";
        $wn = DB::select($wnSql);

        $completed = 0;

        foreach ($wn as $w) {
            //num lessons SQL
            $nl = Lesson::where('course_id', $w->course_id)->where('is_trailer',0)->where('is_sample', 0)->count();

            //see how many lessons from course user has finished
            $fl = Progress::select('id')
                ->where('user_id', $uid)
                ->where('course_id',$w->course_id)
                ->where('completed',1)
                ->count();

            if($fl == $nl) {
                $completed += 1;
            }
        }

        $res = new \stdClass();

        $res->watching = $wn;
        $res->completed = $completed;

        return response()->json([
            "success" => true,
            "message" => "Got user progress",
            "data" => $res
        ], 200);

    }

    public function getFreeCourses()
    {
        $courses = Course::where('free', '1')->with(['category','host'])->get();
        $webinars = Free::where('type','webinar')->get();
        $interviews = Free::where('type','interviu')->get();

        return response()->json([
            "success" => true,
            "message" => "Got user progress",
            "courses" => $courses,
            "webinars" => $webinars,
            "interviews" => $interviews
        ], 200);
    }

    public function getFreeData(Request $request)
    {
        if(!isset($request->course_id)) {
            return response()->json([
                "success" => false,
                "message" => "Provide course id",
            ], 500);
        }

        $course = Course::where('id', $request->course_id)->with(['category','host','lessons'])->first();


        return response()->json([
            "success" => true,
            "message" => "Got free course data",
            "course" => $course,
        ], 200);
    }




}
