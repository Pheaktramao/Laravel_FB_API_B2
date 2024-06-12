<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Psr7\Request;
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
// Authentication routes
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ROUTES AUTHENTICATION
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ROUTES POSTS
// Route::get('/post/list', [PostController::class, 'index']);
// Route::post('/post/create', [PostController::class, 'store']);
// Route::get('/post/show/{id}', [PostController::class, 'show']);
// Route::put('/post/update/{id}', [PostController::class, 'update']);
// Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
Route::prefix('post')->group(function () {
    Route::get('/list', [PostController::class, 'index']);
    Route::post('/create', [PostController::class, 'store']);
    Route::get('/show/{id}', [PostController::class, 'show']);
    Route::put('/update/{id}', [PostController::class, 'update']);
    Route::delete('/delete/{id}', [PostController::class, 'destroy']);
});


// ROUTES COMMENTS
Route::prefix('comment')->group(function () {
    Route::get('/list', [CommentController::class, 'index']);
    Route::post('/create', [CommentController::class, 'store']);
    Route::get('/show/{id}', [CommentController::class, 'show']);
    Route::put('/update/{id}', [CommentController::class, 'update']);
    Route::delete('/delete/{id}', [CommentController::class, 'destroy']);
});


