<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\WebsiteController;
use \App\Http\Controllers\Api\V1\SubscriberController;
use \App\Http\Controllers\Api\V1\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/', WebsiteController::class);
Route::apiResource('/subscriber', SubscriberController::class);
Route::apiResource('/posts', PostController::class);
