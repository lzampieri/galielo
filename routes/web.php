<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

// Routing is managed by React
Route::get('/{path?}', function () {
    return view('welcome');
})->where('path','(?!auth)(?!storage).*')->name('react');

// Only auth routing (via Google through Socialite) is managed by Laravel
Route::get('/auth/login_google', [ GoogleAuthController::class, 'redirect' ] )->name('login-google');
Route::get('/auth/callback_google', [ GoogleAuthController::class, 'callback' ] )->name('callback-google');
Route::get('/auth/logout_google', [ GoogleAuthController::class, 'logout' ] )->name('logout-google');