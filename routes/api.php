<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgatePasswordManager;
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
// // });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();

// Route::middleware('auth:sanctum')->group(function () {
// });


// ROUTES AUTHENTICATION
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
});


// ROUTES POSTS
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/list-post', [PostController::class, 'listPost']);
    Route::post('/add-post', [PostController::class, 'addPost']);
    Route::get('/get-post/{id}', [PostController::class, 'getPost']);
    Route::put('/update-post/{id}', [PostController::class, 'updatePost']);
    Route::delete('/delete-post/{id}', [PostController::class, 'destroy']);

    // Comment Router
    Route::get('/list-comment', [CommentController::class, 'listComment']);
    Route::post('/add-comment', [CommentController::class, 'addComment']);
    Route::get('/get-comment/{id}', [CommentController::class, 'getComment']);
    Route::put('/update-comment/{id}', [CommentController::class, 'updateComment']);
    Route::delete('/delete/{id}', [CommentController::class, 'destroy']);

    // Like Router
    
});


// ROUTES COMMENTS
<<<<<<< HEAD
Route::prefix('comment')->group(function () {
    Route::get('/list', [CommentController::class, 'index']);
    Route::post('/create', [CommentController::class, 'store']);
    Route::get('/show/{id}', [CommentController::class, 'show']);
    Route::put('/update/{id}', [CommentController::class, 'update']);
    Route::delete('/delete/{id}', [CommentController::class, 'destroy']);
});

Route::post('/add-like', [PostController::class, 'aaddLike']);
=======


>>>>>>> 245657ad77f7156910ee28ee43b6fc294d78134b
