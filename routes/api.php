<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::post('stripe_session', [ApiController::class, 'stripe']);
Route::post('stripe_customer_data', [ApiController::class, 'get_stripe_customer_data']);
Route::post('update_stripe_id', [ApiController::class, 'updateCustomerId']);
Route::post('get_stripe_profile_data', [ApiController::class, 'get_stripe_profile_data']);

Route::post('course/lesson/{id}', [CourseController::class, 'getById']);
Route::post('courses/{slug}', [CourseController::class, 'getBySlug']);

Route::post('category/{slug}', [CategoryController::class, 'getCoursesByCategorySlug']);
Route::post('getAllCategories', [CategoryController::class, 'getAllCategories']);

Route::post('getAllBooks', [BookController::class, 'getAllBooks']);
Route::post('getBook/{id}', [BookController::class, 'getById']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::put('update/{product}',  [ProductController::class, 'update']);
    Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
    //activate account
    Route::post('activate/{code}', [ApiController::class, 'activateAccount']);
    Route::post('getLessonNotes', [NoteController::class, 'getByLessonId']);
    Route::post('addLessonNote', [NoteController::class, 'store']);
    Route::post('deleteLessonNote', [NoteController::class, 'destroy']);
    Route::post('deleteUserReview', [ReviewController::class, 'destroy']);
    Route::post('getReviewsByCourseId', [ReviewController::class, 'getByCourseId']);
    Route::post('addCourseReview', [ReviewController::class, 'store']);
    Route::post('getInstructorDetails', [HostController::class, 'getDataById']);
    Route::post('cancelUserSub', [ApiController::class, 'cancel_active_sub']);
    Route::post('getReferredCount', [ApiController::class, 'getReferred']);
    Route::post('updateLessonsProgress', [ProgressController::class, 'updateUserProgress']);
    Route::post('getNotesByCourseId', [NoteController::class, 'getByCourseId']);
    Route::post('getQuestionsByCourseId', [QuestionController::class, 'getAllByCourseId']);
    Route::post('addQuestionToCourse', [QuestionController::class, 'addQuestionToCourse']);
});
