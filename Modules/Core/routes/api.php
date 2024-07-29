<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\AuthController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['module.loader'])->group(function () {
    Route::post('/v1/auth/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);

        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/roles', [AuthController::class, 'createRole']);
    });
});
