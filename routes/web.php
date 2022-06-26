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

