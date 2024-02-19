<?php

use App\Http\Controllers\recipes\RecipeController;
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

Route::get('recipes', [RecipeController::class, 'get']);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(RecipeController::class)->group(function () {
        Route::post('/recipes', 'post');
    });
});

Route::get('/check', function () {
    return 'json';
});
