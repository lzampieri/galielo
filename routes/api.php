<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\Param;
use Illuminate\Support\Facades\Auth;
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

// Params
Route::get('/param/all', function() {
    return Param::select('key','value')->get();
});

// Users
Route::get('/user/me', function() {
    if( Auth::check() ) return new UserResource( Auth::user() );
    else return "{}";
});

// Players
Route::post('/player', [PlayerController::class, 'create'] );
Route::get('/player/unassociated', [PlayerController::class, 'unassociated'] );
Route::post('/player/associate', [PlayerController::class, 'associate'] );

