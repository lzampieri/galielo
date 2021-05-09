<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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
}