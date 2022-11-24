<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('dash', [DashController::class, 'index']);

//LOGIN
Route::get('login', [DashController::class, 'login']);
Route::post('login', [DashController::class, 'doLogin']);

//USERS
Route::get('users', [DashController::class, 'showAllUsers']);
Route::get('user/{id}', [DashController::class, 'showUser']);
Route::post('user/{id}', [DashController::class, 'saveUser']);

Route::post('muac/{id}', [DashController::class, 'addCallToUser']);
Route::get('calls', [DashController::class, 'showAllUserCalled']);

//TEACHERS
Route::get('teachers', [DashController::class, 'showAllTeachers']);
Route::get('teacher/{id}', [DashController::class, 'showTeacher']);
Route::post('add_teacher', [DashController::class, 'addTeacher']);
Route::post('teacher/{id}', [DashController::class, 'saveTeacher']);

//COMMENTS
Route::get('comments', [DashController::class, 'showAllComments']);
Route::post('addFakeUser', [DashController::class, 'addFakeUser']);
Route::post('addFakeComment', [DashController::class, 'addFakeComment']);
Route::get('deleteReview/{id}', [DashController::class, 'deleteReview']);


//COURSE
Route::get('courses', [DashController::class, 'showAllCourses']);
Route::get('course/{id}', [DashController::class, 'showCourse']);
Route::post('course/{id}', [DashController::class, 'saveCourse']);
Route::get('add_course', [DashController::class, 'addCourse']);
Route::post('add_course', [DashController::class, 'saveAddCourse']);

Route::get('clessons/{id}', [DashController::class, 'getCourseLessons']);
Route::get('deleteLesson/{id}', [DashController::class, 'deleteLesson']);
Route::post('addLessonToCourse', [DashController::class, 'addLessonToCourse']);

Route::get('cres/{id}', [DashController::class, 'getCourseRes']);
Route::post('addResourceToCourse', [DashController::class, 'addResourceToCourse']);
Route::get('deleteResource/{id}', [DashController::class, 'deleteResource']);

Route::get('csecond/{id}', [DashController::class, 'getSecondaryCategoriesForCourse']);
Route::post('addSecondary', [DashController::class, 'addSecondaryCategoryToCourse']);
Route::get('deleteSecondaryCategory/{id}', [DashController::class, 'deleteSecondaryCategory']);

//STORIES
Route::get('stories', [DashController::class, 'showAllStories']);
Route::get('editStory/{id}', [DashController::class, 'editStory']);
Route::post('saveStoryEdit/{id}', [DashController::class, 'saveStoryEdit']);
Route::post('addStory', [DashController::class, 'saveAddStory']);
Route::get('deleteStory/{id}', [DashController::class, 'deleteStory']);

//BOOKS
Route::get('books', [DashController::class, 'showAllBooks']);
Route::post('addBook', [DashController::class, 'saveAddBook']);
Route::get('bookEdit/{id}', [DashController::class, 'showBook']);
Route::post('saveBookEdit/{id}', [DashController::class, 'saveBookEdit']);
Route::get('deleteBook/{id}', [DashController::class, 'deleteBook']);

//NEWS
Route::get('news', [DashController::class, 'news']);
Route::post('addNews', [DashController::class, 'addNews']);
Route::get('deleteNews/{id}', [DashController::class, 'deleteNews']);
Route::get('editNews/{id}', [DashController::class, 'editNews']);
Route::post('saveNewsEdit', [DashController::class, 'saveNewsEdit']);

//PAYOUTS
Route::get('payouts', [DashController::class, 'payouts']);
Route::post('addPayout', [DashController::class, 'addPayout']);
Route::get('editPayout/{id}', [DashController::class, 'editPayout']);
Route::post('savePayoutEdit/{id}', [DashController::class, 'savePayoutEdit']);

//LANDINGS
Route::get('landings', [DashController::class, 'landings']);
Route::post('addLanding', [DashController::class, 'addLanding']);
Route::get('deleteLanding/{id}', [DashController::class, 'deleteLanding']);
Route::get('editLanding/{id}', [DashController::class, 'editLanding']);
Route::post('saveLandingEdit', [DashController::class, 'saveLandingEdit']);

//QUESTIONS
Route::get('questions', [DashController::class, 'questions']);
Route::post('addQuestion', [DashController::class, 'addQuestion']);
Route::get('deleteQuestion/{id}', [DashController::class, 'deleteQuestion']);
Route::post('addAnswer', [DashController::class, 'addAnswer']);


//FREES
//QUESTIONs
Route::get('frees', [DashController::class, 'frees']);
Route::post('addFreeCourse', [DashController::class, 'addFreeCourse']);
Route::post('addFreeResource', [DashController::class, 'addFreeResource']);
Route::get('deleteFree/{id}', [DashController::class, 'deleteFree']);
Route::get('deleteFreeCourse/{id}', [DashController::class, 'deleteFreeCourse']);
Route::get('deleteQuestion/{id}', [DashController::class, 'deleteQuestion']);

//SOCIALS
Route::get('socials', [DashController::class, 'socials']);
Route::post('addSocial', [DashController::class, 'addSocial']);


//CRONS
Route::get('avfec', [DashController::class, 'addViewsToCourses']);

//check for subscriber status on convertKit tag
Route::get('cfssck', [DashController::class, 'checkForTagStatusCk']);





