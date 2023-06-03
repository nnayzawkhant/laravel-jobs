<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostAPIController;
use App\Http\Controllers\UserAPIController;
use App\Models\JobPost;

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

Route::get('/jobs', [JobPostAPIController::class, 'index']);
Route::post('/jobs', [JobPostAPIController::class, 'store'])->middleware('auth:api');
Route::get('/jobs/{id}', [JobPostAPIController::class, 'show']);
Route::put('/jobs/{id}', [JobPostAPIController::class, 'update'])->middleware('auth:api');
Route::delete('/jobs/{id}', [JobPostAPIController::class, 'destroy'])->middleware('auth:api');

Route::post('/register', [UserAPIController::class, 'register']);
Route::post('/login', [UserAPIController::class, 'login']);


