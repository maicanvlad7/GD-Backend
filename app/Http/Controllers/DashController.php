<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Course;
use App\Models\Host;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DashController extends Controller
{
    public function index()
    {
        $users   = User::all();
        $courses = Course::all()->count();
        $books   = Book::all()->count();

        $subbed = 0;
        foreach($users as $val) {
            if($val->subscription != '0' && $val->subscription != 'host') {
                $subbed += 1;
            }
        }

        $data = new \stdClass();

        $data->users   = count($users);
        $data->subbed  = $subbed;
        $data->courses = $courses;
        $data->books   = $books;

        return view('dash', ["data" => $data]);
    }
    //    for edit only

    public function login()
    {
        return view('login');
    }


    public function doLogin(Request $request)
    {

        if($request->user == 'adminergd' && $request->pass == env('ADMIN_PASS_DASH')) {
            Session::put('logged_in', 1);
            return Redirect::to('dash');
        }else{
            die('parola gresita sau user ceva');
        }

    }

//    USER
    public function showAllUsers()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $users = User::all();

        return view('users', ["data" => $users]);
    }

    public function showUser($id)
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $user = new User();

        $userData = $user::where('id', $id)->first();
        $userData = $userData->getOriginal();

        return view('edit_user', ["user" => $userData]);
    }

    public function saveUser(Request $request, $id)
    {

        $user = User::where("id", $id)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->subscription = $request->subscription;
        $user->stripe_id = $request->stripe_id;

        if($user->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes userul ' . $user->name);
        }

    }

//    COURSE
    public function showAllCourses()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $data = Course::all();

        return view('courses', ["data" => $data]);
    }

    public function showCourse($id)
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $course = new Course();

        $data = $course::where('id', $id)->first();
        $data = $data->getOriginal();

        return view('edit_course', ["data" => $data]);
    }

    public function saveCourse(Request $request, $id)
    {

        $course = Course::where("id", $id)->first();

        $course->name = $request->name;
        $course->score = $request->score;
        $course->image = $request->image;
        $course->description = $request->description;
        $course->subtitle = $request->subtitle;
        $course->length = $request->length;
        $course->views = $request->views;
        $course->coming_soon = $request->coming_soon == "on" ? 1 : 0;

        if($course->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes cursul ' . $course->name);
        }

    }

    public function addCourse()
    {
        $hosts = Host::select('name','id')->get();

        return view('add_course', ["data" => $hosts]);
    }

    public function saveAddCourse(Request $request)
    {
        $course = new Course();

        $course->category_id = $request->category_id;
        $course->host = $request->host;
        $course->name = $request->name;
        $course->subtitle = $request->subtitle;
        $course->description = $request->description;
        $course->views = $request->views;
        $course->image = $request->image;
        $course->plan = $request->plan;
        $course->length = $request->length;
        $course->coming_soon = isset($request->coming_soon) ? 1 : 0;

        if($course->save()) {
            return redirect('/courses')->with('message', 'Ati adaugat cu succes ' . $course->name);
        }


    }

    public function getCourseLessons($id)
    {

        $course_name = Course::select('name')->where('id', $id)->first();

        $lessons = Lesson::where('course_id', $id)->get();

        return view('course_lessons', ["data" => $lessons,"course_id" => $id, 'course_name' => $course_name]);
    }

    public function addLessonToCourse(Request $request)
    {
        $lesson = new Lesson();

        $lesson->name = $request->name;
        $lesson->video_id = $request->video_id;
        $lesson->course_id = $request->course_id;
        $lesson->length = $request->length;
        $lesson->video_link = "https://player.vimeo.com/video/" . $lesson->video_id . "?h=e7389b8c2e";
        $lesson->is_trailer = isset($request->is_trailer) ? 1 : 0;
        $lesson->is_sample = isset($request->is_sample) ? 1 : 0;

        if($lesson->save()) {
            return redirect()->back()->with('message', 'Ati adaugat cu succes lectia ' . $lesson->name);
        }
    }

    public function deleteLesson($id)
    {
        $lesson = Lesson::find($id);

        if($lesson->delete()) {
            return redirect()->back()->with('message', 'Ati sters lectia cu succes! ');
        }
    }

    public function getCourseRes($id)
    {
        $course_name = Course::select('name')->where('id', $id)->first();

        $res = Resource::where('course_id', $id)->get();

        return view('course_res', ["data" => $res,"course_id" => $id, 'course_name' => $course_name]);
    }

    public function addResourceToCourse(Request $request)
    {
        $resource = new Resource();

        $resource->name = $request->name;
        $resource->course_id = $request->course_id;
        $resource->link   = $request->link;

        if($resource->save()) {
            return redirect()->back()->with("message", "Resursa a fost adaugata cu succes!");
        }
    }

    public function deleteResource($id)
    {
        $resource = Resource::find($id);

        if($resource->delete()) {
            return redirect()->back()->with('message', 'Ati sters resursa cu succes!');
        }
    }

    public function showAllStories()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $data = Story::all();

        return view('stories', ["data" => $data]);
    }

    public function saveAddStory(Request $request)
    {
        $story = new Story();

        foreach($request->input() as $key => $val) {
            if($key != "_token") {
                $story->$key = $val;
            }
        }

        if($story->save()) {
            return redirect()->back()->with("message", "Povestea a fost adaugata cu succes!");
        }
    }

    public function deleteStory($id)
    {
        $story = Story::find($id);

        if($story->delete()) {
            return redirect()->back()->with('message', 'Ati sters povestea cu succes!');
        }
    }

    public function showAllBooks()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $data = Book::all();

        return view('books', ["data" => $data]);
    }

    public function saveAddBook(Request $request)
    {
        $book = new Book();

        foreach($request->input() as $key => $val) {
            if($key != "_token") {
                $book->$key = $val;
            }
        }

        //set audio as default available 0
        $book->audio_av = 0;
        $book->ideas    = "";
        $book->synopsis    = "";
        $book->target_audience    = "";
        $book->category    = "";

        if($book->save()) {
            return redirect()->back()->with("message", "Rezumatul cartii a fost adaugat cu succes!");
        }
    }

    public function deleteBook($id)
    {
        $book = Book::find($id);

        if($book->delete()) {
            return redirect()->back()->with('message', 'Ati sters rezumatul cartii cu succes!');
        }
    }
}
