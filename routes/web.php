<?php

use App\Http\Controllers\CourseController;
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

Route::get('showCourses', [CourseController::class, 'showAllCourses']);
Route::get('course/{id}', [CourseController::class, 'showCourseById']);
Route::post('course/{id}', [CourseController::class, 'saveCourseAdmin']);

