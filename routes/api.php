<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\PasswordResetRequestController;
use App\Http\Controllers\CategoriesController;
use App\Models\Categories;
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
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset-password-request',[PasswordResetRequestController::class, 'sendPasswordResetEmail']);
    Route::post('/change-password', [ChangePasswordController::class, 'passwordResetProcess']);
    Route::post('/get-email', [ChangePasswordController::class, 'getEmail']);

    Route::group(['middleware' => 'jwt.verify'], function ($router) {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('/message',[ChatController::class,'sendMessage']);
        Route::get('/messages/{id}',[ChatController::class,'getMessages']);
        Route::get('/chats',[ChatController::class,'getChats']);
        Route::post('/chats/update/{id}',[ChatController::class,'update']);
        Route::post('/send-application',[ChatController::class,'sendApplication']);
        Route::get('/countries',[CountriesController::class,'index']);
    });
});

