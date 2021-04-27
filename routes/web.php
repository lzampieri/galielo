<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

// Routing is managed by React
Route::get('/{path?}', function () {
    return view('welcome');
})->where('path','(?!auth).*')->name('react');

// Only auth routing is managed by laravel
/* Socialite OAuth */
Route::get('/auth/login_google', [ GoogleAuthController::class, 'redirect' ] )->name('login-google');
Route::get('/auth/callback_google', [ GoogleAuthController::class, 'callback' ] )->name('callback-google');
Route::get('/auth/logout_google', [ GoogleAuthController::class, 'logout' ] )->name('logout-google');

Route::get('/auth/user/me', function() {
    if( Auth::check() ) return new UserResource( Auth::user() );
    else return "{}";
});