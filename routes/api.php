<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\TeacherController;

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

// my custom login API
Route::post('/login', [AuthController::class, 'login']);

// for admin dashboard

Route::get('/teachers', [AdminTeacherController::class, 'index']);
Route::post('/teachers', [AdminTeacherController::class, 'store']);

Route::put('/teachers/{id}/freeze', [AdminTeacherController::class, 'freeze']);
Route::put('/teachers/{id}/unfreeze', [AdminTeacherController::class, 'unfreeze']);
Route::put('/teachers/{id}', [TeacherController::class, 'update']);
Route::delete('/teachers/{id}', [AdminTeacherController::class, 'destroy']);
Route::put('/teachers/{id}/status', [AdminTeacherController::class, 'updateStatus']);
