<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function create(Request $request) {
        try {      
            $player = Player::create( [
                'name' => $request->input('name'),
                'apoints' => 1400,
                'dpoints' => 1400
            ]);
            LogController::player_create( $player );
            if( Auth::check() ) {
                if( ! (Auth::user()->player()->exists() ) ) {
                    Auth::user()->player()->save( $player );
                    LogController::player_associate( $player );
                }
            }
            return response()->json([ 'success' => true ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'errorInfo' => $e->errorInfo
            ]);
        }
    }

    public function unassociated() {
        return Player::whereNull('user_id')->select('id','name')->get();
    }

    public function associate(Request $request) {
        try {
            $player = Player::find( $request->input('player_id') );
            $user = Auth::user();
            $user->player()->save( $player );
            LogController::player_associate( $player );
            return response()->json([
                'success' => true
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'errorInfo' => $e->errorInfo
            ]);
        }
    }

    public function all() {
        return PlayerResource::collection( Player::all() );
    }

    public function details(int $id) {
        try {
            $player = Player::findOrFail( $id );
            return new PlayerResource( $player );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'errorInfo' => 'Player not found'
            ]);
        }
    }
}