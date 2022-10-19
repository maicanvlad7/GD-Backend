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

//PAYOUTS
Route::get('payouts', [DashController::class, 'payouts']);
Route::post('addPayout', [DashController::class, 'addPayout']);
Route::get('editPayout/{id}', [DashController::class, 'editPayout']);
Route::post('savePayoutEdit/{id}', [DashController::class, 'savePayoutEdit']);

//PAYOUTS
Route::get('landings', [DashController::class, 'landings']);
Route::post('addLanding', [DashController::class, 'addLanding']);

//CRONS
Route::get('avfec', [DashController::class, 'addViewsToCourses']);

//check for subscriber status on convertKit tag
Route::get('cfssck', [DashController::class, 'checkForTagStatusCk']);





