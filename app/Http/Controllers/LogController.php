<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
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

    public static function player_changeApoints(Player $plt, int $old_points) {
        LogController::create_and_associate("Player | change Apoints from " . $old_points . " to " . $plt->apoints . "(" . $plt->name . ", " . $plt->id . ")" );
    }

    public static function player_changeDpoints(Player $plt, int $old_points) {
        LogController::create_and_associate("Player | change Dpoints from " . $old_points . " to " . $plt->dpoints . "(" . $plt->name . ", " . $plt->id . ")" );
    }
    
    public static function user_login() {
        LogController::create_and_associate("User | login" );
    }
    
    public static function game_create(Game $game) {
        LogController::create_and_associate("Game | create game (" . $game->id . ")" );
    }
}