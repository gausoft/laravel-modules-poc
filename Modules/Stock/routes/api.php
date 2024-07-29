<?php

use Illuminate\Support\Facades\Route;
use Modules\Stock\Http\Controllers\ProductCategoryController;
use Modules\Stock\Http\Controllers\ProductController;
use Modules\Stock\Http\Controllers\StockController;
use Modules\Stock\Http\Controllers\StockLocationController;

Route::middleware(['module.loader'])->group(function () {
    Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
        Route::apiResource('stock-locations', StockLocationController::class);
        Route::apiResource('stocks', StockController::class)->names('stock');

        Route::apiResource('products', ProductController::class);
        Route::apiResource('categories', ProductCategoryController::class);
    });
});
