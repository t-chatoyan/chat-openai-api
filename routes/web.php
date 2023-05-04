<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
Route::get('/chats/{id}', [App\Http\Controllers\CustomerController::class, 'getChat'])->name('chats');
Route::get('/chat/{id}/messages', [App\Http\Controllers\CustomerController::class, 'getChatMessages'])->name('messages');
Route::get('/messages/{id}/export', [App\Http\Controllers\CustomerController::class, 'exportMessages'])->name('export');
