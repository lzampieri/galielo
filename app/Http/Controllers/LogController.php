<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class LogController extends Controller
{
    static function create_and_associate(string $description) {
        $istance = Log::create( [
            'action' => $description
            ] );
        if( Auth::check() )
            Auth::user()->logs()->save( $istance );
    }

    public static function player_create(Player $plt) {
        LogController::create_and_associate("Player | created " . $plt->name . " (" . $plt->id . ")" );
    }

    public static function player_associate(Player $plt) {
        LogController::create_and_associate("Player | associated " . $plt->name . " (" . $plt->id . ")" );
    }
    
    public static function user_login() {
        LogController::create_and_associate("User | login" );
    }
}