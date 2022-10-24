<?php

use App\Http\Controllers\Auth\AccessTokenController;
use App\Http\Controllers\Dashboard\ActivitiesTypeController;
use App\Http\Controllers\Dashboard\ActivityController;
use App\Http\Controllers\Dashboard\AdvertisingController;
use App\Http\Controllers\Dashboard\AttendenceController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\CourseDayController;
use App\Http\Controllers\Dashboard\GroupController;
use App\Http\Controllers\Dashboard\MentorController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\PartnerProjectController;
use App\Http\Controllers\Dashboard\PlatformController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\RateController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\StudentGroupController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\LandingPage\ContactController;
use App\Http\Controllers\LandingPage\LandingPageController;
use App\Http\Controllers\LandingPage\QuestionController;
use App\Http\Controllers\Student\FreelanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/{guard}/access-token', [AccessTokenController::class, 'store'])->middleware('guest:sanctum');
Route::get('landing-page', [LandingPageController::class, 'index']);
Route::post('contacts', [ContactController::class, 'store']);


Route::middleware('auth:sanctum')->prefix('dashboard')->group(function(){
    Route::apiResource('users',UserController::class);
    Route::apiResource('mentors',MentorController::class);
    Route::delete('auth/access-token/{token?}', [AccessTokenController::class, 'destroy']);
    Route::apiResource('categories', CategoriesController::class);
    Route::post('landing-page', [LandingPageController::class, 'store']);
    Route::apiResource('platforms', PlatformController::class);
    Route::apiResource('partners', PartnerController::class);
    Route::apiResource('advertisings', AdvertisingController::class);
    Route::apiResource('activities-types', ActivitiesTypeController::class);
    Route::apiResource('activites',ActivityController::class);
    Route::apiResource('groups', GroupController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('categories', CategoriesController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('rates', RateController::class);
    Route::apiResource('attendences', AttendenceController::class);
    Route::get('{courseDay}/attendences',[AttendenceController::class,'index']);
    Route::apiResource('courses-days', CourseDayController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::post('add-student',[StudentGroupController::class,'store']);
    Route::post('avaliable-students',[StudentGroupController::class,'showStudents']);
    Route::post('avaliable-partners',[PartnerProjectController::class,'showPartners']);
    Route::post('add-partner',[PartnerProjectController::class,'store']);
    Route::apiResource('contacts', ContactController::class)->except('store');
});
Route::middleware('auth:sanctum')->prefix('student')->group(function(){
    Route::apiResource('freelances',FreelanceController::class);
    Route::post('show-groups',[FreelanceController::class,'showGroups']);
});
