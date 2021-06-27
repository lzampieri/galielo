<?php

use App\Http\Controllers\BackupsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ParamController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PlayerController;
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

// Public stuff

// Params
Route::get('/param/all', [ParamController::class, 'all']);
Route::get('/table/all', [TableController::class, 'all']);

// Users
Route::get('/user/me', function() {
    if( Auth::check() ) return new UserResource( Auth::user() );
    else return "{}";
});

// Players
Route::post('/player', [PlayerController::class, 'create'] );
Route::get('/player/unassociated', [PlayerController::class, 'unassociated'] );
Route::get('/player/all', [PlayerController::class, 'all'] );

// Games
Route::get('/game/all', [GameController::class, 'all'] );
Route::get('/game/some', [GameController::class, 'some'] )->withoutMiddleware(['throttle:api']);

// Only logged stuff
Route::middleware('auth:sanctum')->group( function() {
    // Players
    Route::post('/player/associate', [PlayerController::class, 'associate'] );
    
    // Games
    Route::post('/game', [GameController::class, 'create'] );
});

// Backup
Route::get('/backup/create', [BackupsController::class, 'create'] );