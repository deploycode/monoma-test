<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\CandidateController;
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


Route::middleware(['auth:api', 'role:manager'])->group(function () {
    Route::apiResource('lead', CandidateController::class);
});

Route::middleware(['auth:api', 'role:agent,manager'])->group(function () {
    Route::apiResource('lead', CandidateController::class)->except(['store']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('auth', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});
