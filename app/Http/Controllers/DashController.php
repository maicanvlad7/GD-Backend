<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Course;
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
        $course->description = $request->description;
        $course->subtitle = $request->subtitle;
        $course->length = $request->length;
        $course->views = $request->views;

        if($course->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes cursul ' . $course->name);
        }

    }
}
