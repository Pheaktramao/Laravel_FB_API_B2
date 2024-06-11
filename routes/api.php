<?php

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

// ROUTES POSTS
Route::get('/post/list', [PostController::class, 'index']);
Route::post('/post/create', [PostController::class, 'store']);
Route::get('/post/show/{id}', [PostController::class, 'show']);
Route::put('/post/update/{id}', [PostController::class, 'update']);
Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
