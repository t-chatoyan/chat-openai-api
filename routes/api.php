<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
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



Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'jwt.verify'], function ($router) {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});
Route::post('/message',[ChatController::class,'sendMessage']);
Route::get('/messages/{id}',[ChatController::class,'getMessages']);
Route::get('/chats',[ChatController::class,'getChats']);