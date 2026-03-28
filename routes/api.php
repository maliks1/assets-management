<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and
| automatically assigned to the "api" middleware group.
| URL will be prefixed with /api
|
*/

// Simple test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working'
    ]);
});

// Product API Routes
Route::prefix('v1')
    ->name('api.')
    ->group(function () {
        Route::apiResource('products', ProductController::class);
    });
