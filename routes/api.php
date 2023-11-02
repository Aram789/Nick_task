<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/', \App\Http\Controllers\Api\V1\WebsiteController::class);
Route::apiResource('/subscriber', \App\Http\Controllers\Api\V1\SubscriberController::class);
Route::apiResource('/posts', \App\Http\Controllers\Api\V1\PostController::class);
