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


