<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounting\Http\Controllers\SalesController;

Route::middleware(['module.loader', 'auth:sanctum'])->prefix('v1')->group(function () {
    app('request')->headers->set('Accept', 'application/json');
    Route::apiResource('sales', SalesController::class);
});
