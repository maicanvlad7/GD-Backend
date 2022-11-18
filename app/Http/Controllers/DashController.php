<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Calls;
use App\Models\Course;
use App\Models\Free;
use App\Models\Host;
use App\Models\Landing;
use App\Models\Lesson;
use App\Models\News;
use App\Models\Payout;
use App\Models\Question;
use App\Models\Resource;
use App\Models\Review;
use App\Models\Social;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Event\RequestEvent;

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

        $sql = "select count(id) as hits, button_name from clogs group by button_name";
        $clicks = DB::select($sql);

        $hits    = array();
        $labels  = array();

        if(!empty($clicks)) {
            foreach($clicks as $c) {
                array_push($hits, intval($c->hits));
                array_push($labels, $c->button_name);
            }
        }

        $data = new \stdClass();

        $data->users   = count($users);
        $data->subbed  = $subbed;
        $data->courses = $courses;
        $data->books   = $books;
        $data->hits    = json_encode($hits);
        $data->labels  = json_encode($labels);

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

    public function showAllComments()
    {
        $sql = "SELECT courses.name AS cname, users.name AS uname, users.email, users.level as ulevel,  reviews.* FROM reviews
                INNER JOIN users ON users.id = reviews.user_id
                INNER JOIN courses ON courses.id = reviews.course_id";

        $result = DB::select($sql);

        $users = User::where('is_bot', 1)->get();
        $courses = Course::all();

        return view('comments', ["data" => $result,"users"=>$users,"courses"=>$courses]);

    }

    public function addFakeUser(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('test12345');
        $user->referred_by = 0;
        $user->is_bot = 1;
        $user->active = 1;
        $user->level  = $request->level;

        if($user->save()) {
            return redirect()->back()->with('message', 'Ati adaugat cu succes userul ' . $user->name);
        }


    }

    public function addFakeComment(Request $request)
    {
        $rev = new Review();

        $rev->user_id = $request->user_id;
        $rev->course_id = $request->course_id;
        $rev->content    = $request->con;
        $rev->rating = 5;

        if($rev->save()) {
            return redirect()->back()->with('message', 'Ati adaugat cu succes comentariul');
        }
    }

    public function deleteReview($id)
    {
        $rev = Review::find($id);

        if($rev->delete()) {
            return redirect()->back()->with('message', 'Ati sters comentariul cu succes!');
        }
    }

    public function showAllTeachers()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $teachers = Host::all();

        return view('teachers', ["data" => $teachers]);
    }

    public function showTeacher($id)
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $host = new Host();

        $hostData = $host::where('id', $id)->first();
        $hostData = $hostData->getOriginal();

        return view('edit_teacher', ["host" => $hostData]);
    }

    public function saveTeacher(Request $request, $id)
    {

        $host = Host::where("id", $id)->first();

        $host->name = $request->name;
        $host->title = $request->title;
        $host->description = $request->description;
        $host->image = $request->image;

        if($host->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes teacher-ul ' . $host->name);
        }

    }

    public function addTeacher(Request $request)
    {
        $host = new Host();

        $host->name = $request->name;
        $host->title = $request->title;
        $host->description = $request->description;
        $host->image = $request->image;

        if($host->save()) {
            return redirect()->back()->with('message', 'Ati adaugat cu succes teacher-ul' . $host->name );
        }
    }

//    USER
    public function showAllUsers()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $sql = "SELECT calls.called, users.* FROM users LEFT JOIN calls ON users.id = calls.user_id";
        $users = DB::select($sql);

        return view('users', ["data" => $users]);
    }

    public function showAllUserCalled()
    {
        if( !Session::exists('logged_in') ) {
            return Redirect::to('/login');
        }

        $sql = "SELECT calls.*, users.phone, users.name, users.email, users.created_at as data_creare FROM calls INNER JOIN users ON users.id = calls.user_id";
        $calls = DB::select($sql);

        return view('calls', ["data" => $calls]);
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

    public function addCallToUser(Request $request, $id)
    {

        $call = Calls::updateOrCreate(
            ['user_id' => $id],
            [
                'called' => 1,
                'status' => $request->status,
                'notes' => $request->notes,
                'called_by'=> $request->called_by
            ]
        );

        if($call) {
            return redirect()->back()->with('message', 'Apelul a fost adaugat cu succes!');
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
        $course->cktag = $request->cktag;
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

    public function editStory($id)
    {
        $story = Story::find($id);

        return view('edit_story', ["data" => $story]);

    }

    public function saveStoryEdit(Request $request, $id)
    {
        $story = Story::where('id', $id)->first();

        $story->title = $request->title;
        $story->excerpt = $request->excerpt;
        $story->description = $request->description;
        $story->author = $request->author;
        $story->role = $request->role;
        $story->cover = $request->cover;
        $story->score = $request->score;

        if($story->save()) {
            return redirect()->back()->with("message", "Povestea ".$story->title." a fost editata cu succes!");
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

    public function showBook($id)
    {
        $book = Book::find($id);

        $book = Book::where('id', $id)->first();
        $book = $book->getOriginal();

        return view('edit_book', ["data" => $book]);
    }

    public function saveBookEdit(Request $request, $id)
    {
        $looper = $request->all();

        $book = Book::where('id', $id)->first();

        foreach($looper as $key=>$val) {
           if($key != "_token") {
               $book->$key = $val;
           }
        }

        if($book->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes rezumatul ' . $book->title);
        }
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

    public function news()
    {
        $news = News::all();

        return view('news', ["data" => $news]);
    }

    public function addNews(Request $request)
    {
        $news = new News();

        $news->image = $request->image;
        $news->link = $request->link;
        $news->score = $request->score;

        if($news->save()) {
            return redirect()->back()->with("message", "NEWS adaugate cu succes.");
        }
    }

    public function deleteNews($id)
    {
        $news = News::find($id);

        if($news->delete()) {
            return redirect()->back()->with('message', 'Ati sters NEWS cu succes!');
        }
    }

    public function editNews($id)
    {
        $news = News::find($id);

        return view('edit_news', ["data" => $news]);
    }

    public function saveNewsEdit(Request $request)
    {
        $news = News::find($request->id);

        foreach($request->all() as $key => $r) {
            if(!in_array($key, ['id', '_token'])) {
                $news->$key = $r;
            }
        }

        if($news->save()) {
            return redirect()->back()->with('message', 'Ati editat NEWS cu succes!');
        }

    }

    public function frees()
    {
        //select free courses
        $courses = Course::select('name','id')->where('free', '1')->get();
        $all_courses = Course::select('name','id')->where('free','0')->get();

        $frees = Free::all();

        return view('frees', [
            "courses" => $courses,
            "frees" => $frees,
            "all_courses" => $all_courses,
        ]);
    }

    public function addFreeCourse(Request $request)
    {
        $course = Course::find($request->course_id);

        $course->free = 1;

        $course->save();

        return redirect()->back()->with('message', 'Curs marcat ca gratuit');
    }

    public function addFreeResource(Request $request)
    {
        $free = new Free();

        foreach($request->all() as $key=>$val) {
            if($key != '_token') {
                $free->$key = $val;
            }
        }

        if($free->save()) {
            return redirect()->back()->with('message', 'Ai adaugat continut gratuit cu succes!');
        }
    }

    public function deleteFree($id)
    {
        $free = Free::find($id);

        if($free->delete()) {
            return redirect()->back()->with('message', 'Resursa gratuita stearsa');
        }
    }


    public function deleteFreeCourse($id)
    {
        $course = Course::find($id);

        $course->free = 0;

        $course->save();

        return redirect()->back()->with('message', 'Curs sters din lista de gratuite');
    }


//SOCIALS
    public function socials()
    {
        $socials = Social::with('host')->get();
        $hosts   = Host::select('id','name')->get();

        return view('socials', [
            "socials" => $socials,
            "hosts"   => $hosts,
        ]);

    }

    public function addSocial(Request $request)
    {
        $social = Social::updateOrCreate([
            "host_id" => $request->host_id,
        ],[
            "instagram" => $request->instagram,
            "facebook"  => $request->facebook,
            "website"  => $request->website,
            "telegram" => $request->telegram,
            "linkedin" => $request->linkedin
        ]);

        if($social) {
            return redirect()->back()->with('message','Socials adaugate cu succes!');
        }


    }
//END SOCIALS

    public function questions()
    {
        $sql = "SELECT courses.name as cname, users.name, questions.* FROM questions 
                INNER JOIN users on questions.user_id = users.id
                INNER JOIN courses on questions.course_id = courses.id";

        $questions = DB::select($sql);

        $users = User::select(['id','email','name'])->where('is_bot', 1)->where('level', '>=' ,'2')->get();
        $courses = Course::select(['id','name'])->get();

        return view('questions', [
            "data" => $questions,
            "users" => $users,
            "courses" => $courses
        ]);
    }

    public function addQuestion(Request $request)
    {
        $question = new Question();

        foreach($request->all() as $key => $q) {
            if($key !== '_token') {
                $question->$key = $q;
            }
        }

        if($question->save()) {
            return redirect()->back()->with('message', 'Ati editat intrebarea cu succes!');
        }
    }

    public function deleteQuestion($id)
    {
        $question = Question::find($id);

        if($question->delete()) {
            return redirect()->back()->with('message', 'Ati sters intrebarea cu succes!');
        }
    }

    public function addViewsToCourses()
    {
        $sql = "UPDATE courses SET views = views + 125";

        DB::select($sql);

        return 0;

    }

    public function payouts()
    {
        $teachers = User::select(['id','name','email'])->where('isHost', 1)->get();

        $sql = "SELECT users.name, users.id as uid, payouts.* FROM payouts INNER JOIN users ON users.id = payouts.user_id";

        $payouts = DB::select($sql);

        return view('payouts', ["teachers" => $teachers, "payouts" => $payouts]);
    }

    public function addPayout(Request $request)
    {
        $payout = Payout::updateOrCreate(
            ['user_id' => $request->user_id],
            ['amount' => $request->amount]
        );

        if($payout) {
            return redirect()->back()->with('message', 'Payout adaugat cu succes!');
        }
    }

    public function editPayout($id)
    {
        $payout = Payout::find($id);

        return view('edit_payout', ["payout" => $payout]);

    }

    public function savePayoutEdit(Request $request, $id)
    {
        $payout = Payout::find($id);

        $payout->amount = $request->amount;

        if($payout->save()) {
            return redirect('/payouts')->with('message', 'Payout editat cu succes!');
        }
    }

    public function landings()
    {
        $courses = Course::select('id','name')->get();

        $sql_land = "SELECT courses.id as course_id, courses.name as course_name, landings.* FROM landings INNER JOIN courses ON courses.id = landings.course_id";

        $landings = DB::select($sql_land);

        return view('landings', ["courses" => $courses, "landings" => $landings]);
    }

    public function addLanding(Request $request)
    {
        $landing = new Landing();

        $looper = $request->all();

        foreach($looper as $key=>$val) {
            if($key != "_token") {
                $landing->$key = $val;
            }
        }

        if($landing->save()) {
            return redirect()->back()->with('message', 'Ati adaugat cu succes ' . $landing->title);
        }

    }

    public function deleteLanding(Request $request, $id)
    {
        $landing = Landing::find($id);

        if($landing->delete()) {
            return redirect()->back()->with('message', 'Ati sters cu succes ' . $landing->title);
        }
    }

    public function editLanding($id)
    {
        $landing = Landing::find($id);


        return view('edit_landing', ["landing" => $landing]);
    }

    public function saveLandingEdit (Request $request)
    {

        $landing = Landing::find($request->id);

        foreach($request->all()  as $key => $r) {

            if(!in_array($key, ['id', '_token'])) {
                $landing->$key = $r;
            }
        }

        if($landing->save()) {
            return redirect()->back()->with('message', 'Ati editat cu succes landing-ul ' . $landing->title);
        }

    }

    public function checkForTagStatusCk()
    {
        set_time_limit(0);

        $has_ab_tag_id = '3284089';
        $no_ab_tag_id  = '3284129';

        $users = User::select(['email','level'])->where('isHost', '0')->where('is_bot', '0')->get();

        foreach($users as $u) {
            //if user is not paying subscription add tag in CK
            if($u->level == 0) {
                $ch = curl_init();

                $tag_url = 'https://api.convertkit.com/v3/tags/'.$no_ab_tag_id.'/subscribe';

                curl_setopt($ch, CURLOPT_URL, $tag_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \n            \"api_secret\": \"".env('CK_KEY')."\",\n            \"email\": \"".$u->email."\"\n         }");

                $headers = array();
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }else {
                //if user is paying remove NOT PAYING tag from CK and add Paying tag
                $ch = curl_init();

                $tag_url = 'https://api.convertkit.com/v3/tags/'.$no_ab_tag_id.'/unsubscribe';

                curl_setopt($ch, CURLOPT_URL, $tag_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \n            \"api_secret\": \"".env('CK_KEY')."\",\n            \"email\": \"".$u->email."\"\n         }");

                $headers = array();
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);

                //add to abonati platforma tag from Convert Kit
                $ch = curl_init();

                $tag_url = 'https://api.convertkit.com/v3/tags/'.$has_ab_tag_id.'/subscribe';

                curl_setopt($ch, CURLOPT_URL, $tag_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \n            \"api_secret\": \"".env('CK_KEY')."\",\n            \"email\": \"".$u->email."\"\n         }");

                $headers = array();
                $headers[] = 'Content-Type: application/json; charset=utf-8';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
        }
    }


}
