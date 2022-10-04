<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\GroupController;
use App\Http\Controllers\Dashboard\ProjectController;
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
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('courses', CourseController::class);

