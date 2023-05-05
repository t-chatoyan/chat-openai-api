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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');

Route::prefix('admins')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminsController::class, 'index'])->name('admins');
    Route::get('/add', [App\Http\Controllers\AdminsController::class, 'adminPage']);
    Route::delete('/delete/{id}', [App\Http\Controllers\AdminsController::class, 'destroy'])->name('admins.destroy');
    Route::get('/update/{id}', [App\Http\Controllers\AdminsController::class, 'show'])->name('admins.update');
});
Route::post('/create-form', [App\Http\Controllers\AdminsController::class, 'addAdmin'])->name('create-form');
Route::put('/update-form', [App\Http\Controllers\AdminsController::class, 'update'])->name('update-form');

Route::get('/chats/{id}', [App\Http\Controllers\CustomerController::class, 'getChat'])->name('chats');
Route::get('/chat/{id}/messages', [App\Http\Controllers\CustomerController::class, 'getChatMessages'])->name('messages');
Route::get('/messages/{id}/export', [App\Http\Controllers\CustomerController::class, 'exportMessages'])->name('export');
