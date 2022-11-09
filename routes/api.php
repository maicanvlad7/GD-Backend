<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FreeController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoryController;
use App\Models\Course;
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

//update or create user preferences
Route::post('ucpf', [PreferenceController::class, 'updateOrCreatePref']);

//reset user password
Route::post('rup', [ApiController::class, 'generateResetCode']);
Route::post('crcfu', [ApiController::class, 'checkResetCode']);
Route::post('surp', [ApiController::class, 'saveUserResetPassword']);

Route::post('gmwc', [CourseController::class, 'getMostViewed']);
Route::post('gcs', [CourseController::class, 'getComingSoon']);
Route::post('getnews', [NewsController::class, 'getAll']);

//get stories for home page - limit to 10
Route::post('gsfhp', [StoryController::class, 'getHomePageStories']);
//get all success stories
Route::post('gass', [StoryController::class, 'getAll']);
//get success story by id
Route::post('gssbi', [StoryController::class, 'getStoryById']);

Route::get('caus', [ApiController::class,'checkkAllUserSubs']);

Route::post('getLp', [LandingController::class, 'getBySlug']);

Route::post('lll', [ClogController::class, 'store']);

Route::post('spsu', [ApiController::class, 'stripeWebhookUpdateCall']);






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
    Route::post('getResourcesByCourseId', [ResourceController::class, 'getByCourseId']);
    Route::post('getQuestionsByCourseId', [QuestionController::class, 'getAllByCourseId']);
    Route::post('addQuestionToCourse', [QuestionController::class, 'addQuestionToCourse']);

    Route::post('getWatchingNowForUser', [ProgressController::class, 'getWatching']);

    Route::post('getRecommended', [CourseController::class, 'getRecommended']);

    Route::post('controlFav', [FavoritesController::class, 'controlFav']);
    Route::post('getFavorites', [FavoritesController::class, 'getFavorites']);
    Route::post('getFavoriteCourses', [CourseController::class, 'getFavoriteCourses']);

    Route::post('ghdbi', [HostController::class, 'getDataById']);
    Route::post('gcbhi', [CourseController::class, 'getCoursesByHost']);

    Route::post('ghrd', [HostController::class, 'getRefByHost']);

    Route::post('gfac', [CourseController::class, 'getFreeCourses']);
    Route::post('gfcvd', [CourseController::class, 'getFreeData']);
    Route::post('gfpc', [FreeController::class, 'getFreeData']);

    Route::post('cpbugd', [ApiController::class, 'changePassByUser']);

    Route::post('atss', [ApiController::class, 'addTagToSub']);

    Route::post('request_payout', [PayoutController::class, 'markAsRequested']);
    Route::post('get_my_payout', [PayoutController::class, 'getByUserId']);
    Route::post('guvs', [CourseController::class, 'getUserVideoStats']);
});
