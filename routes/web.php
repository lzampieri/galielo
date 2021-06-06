<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LogController;
use App\Http\Resources\UserResource;
use App\Models\Param;
use Illuminate\Support\Facades\Auth;

// Almost all routing is managed by React
Route::get('/{path?}', function () {
    return view('welcome');
})->where('path','(?!auth)(?!storage)(?!log).*')->name('react');

// Auth routing (via Google through Socialite)
Route::get('/auth/login_google', [ GoogleAuthController::class, 'redirect' ] )->name('login-google');
Route::get('/auth/callback_google', [ GoogleAuthController::class, 'callback' ] )->name('callback-google');
Route::get('/auth/logout_google', [ GoogleAuthController::class, 'logout' ] )->name('logout-google');

// Log routing
Route::get('/log/human_readable', [ LogController::class, 'human_readable'])->middleware(['auth.admin']);
Route::get('/log/all', [ LogController::class, 'all'])->middleware(['auth.admin']);

// todo Remove
Route::get('/auth/add_param/{key}/{value}', function ($key, $value) {
    return Param::firstOrCreate( [ 'key' => $key, 'value' => $value ] );
});