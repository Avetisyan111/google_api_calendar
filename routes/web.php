<?php

use App\Http\Controllers\GoogleApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SingupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/signup', [SingupController::class, 'index'])->name('signup');
Route::post('/signup', [SingupController::class, 'signup'])->name('signup');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/user', [UserController::class, 'index'])->name('user');

    Route::get('/user/events', [GoogleApiController::class, 'events'])->name('get.events');
    Route::post('/calendar/add', [GoogleApiController::class, 'create'])->name('calendar.create');
    Route::get('/calendar/{eventId}/edit', [GoogleApiController::class, 'edit'])->name('calendar.edit');
    Route::put('/calendar/update/{eventId}', [GoogleApiController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/delete/{eventId}', [GoogleApiController::class, 'delete'])->name('calendar.delete');

});
