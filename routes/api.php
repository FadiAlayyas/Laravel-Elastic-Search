<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);          // List all articles with elastic search
    Route::post('/', [ArticleController::class, 'store']);          // Create a new article
    Route::get('/{article}', [ArticleController::class, 'show']);   // Show a specific article
    Route::put('/{article}', [ArticleController::class, 'update']); // Update an article
    Route::delete('/{article}', [ArticleController::class, 'destroy']); // Delete an article
});
