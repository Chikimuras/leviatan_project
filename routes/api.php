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

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('test', function () {
    return response()->json(['foo' => 'bar']);
});
Route::apiResource('user', App\Http\Controllers\Api\UserController::class);

//Route::apiResource('post', App\Http\Controllers\Api\PostController::class);

Route::get('post', [\App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('post/{post}', [\App\Http\Controllers\Api\PostController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::get('export-posts', [\App\Http\Controllers\Api\PostController::class, 'export']);
    Route::post('post', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::put('post/{post}', [\App\Http\Controllers\Api\PostController::class, 'update']);
    Route::delete('post/{post}', [\App\Http\Controllers\Api\PostController::class, 'destroy']);
});

Route::apiResource('category', App\Http\Controllers\Api\CategoryController::class);
