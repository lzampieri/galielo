<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LogController;
use App\Http\Resources\UserResource;
use App\Models\Param;
use App\Models\Table;
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
Route::redirect('/log',url('log/human_readable'));
Route::middleware('auth.admin')->group( function() {
    Route::get('/log/human_readable', [ LogController::class, 'human_readable']);
    Route::get('/log/all', [ LogController::class, 'all']);
    Route::get('/log/systemlog', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

// todo Remove
Route::get('/auth/add_param/{key}/{value}', function ($key, $value) {
    return Param::firstOrCreate( [ 'key' => $key, 'value' => $value ] );
});// todo Remove
Route::get('/auth/add_table/{value}', function ($value) {
    return Table::firstOrCreate( [ 'name' => $value ] );
});