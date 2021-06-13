<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatrixController;
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


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('matrix/multiply', [MatrixController::class, 'multiply']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
