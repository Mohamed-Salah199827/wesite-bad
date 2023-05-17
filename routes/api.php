<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiBadalyController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiChatController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', [ApiAuthController::class, 'logout']);

Route::middleware(['api-auth'])->group(function () {
    Route::post('/post', [ApiBadalyController::class, 'store']);
    Route::get('/allpost', [ApiBadalyController::class, 'index']);
    Route::get('/post/{post}', [ApiBadalyController::class, 'show']);
    Route::post('/post/{post}', [ApiBadalyController::class, 'update']);
    Route::delete('/post/{post}', [ApiBadalyController::class, 'destroy']);
    Route::post('/approve/{post}', [ApiBadalyController::class, 'approve'])->middleware('api-admin');

    // Route::post('/logout', [ApiAuthController::class, 'logout']);

});
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('massage', [ApiChatController::class, 'massage']);
Route::get('/allUser', [ApiAuthController::class, 'allUser']);
Route::get('/allCategory', [ApiCategoryController::class, 'allCategory']);
Route::get('/category/{category}', [ApiCategoryController::class, 'show']);

