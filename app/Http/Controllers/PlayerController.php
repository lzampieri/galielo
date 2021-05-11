<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function create(Request $request) {
        try {      
            Player::create( [
                'name' => $request->input('name'),
                'apoints' => 1400,
                'dpoints' => 1400
            ]);
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
}