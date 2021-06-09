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

    public function human_readable() {
        $logs = Log::with('user')->orderBy('id','desc')->get();
        $table = "<a href=\"systemlog\">System log</a><br/>";
        $table .= "<table cellspacing=0 cellpadding=7><thead><tr><th>ID</th><th>Creation time</th><th>Action</th><th>User ID</th><th>User mail</th></thead><tbody>";
        $pari = true;
        foreach( $logs as $log ) {
            $table .= "<tr" . ( $pari ? " style=\"background-color: #00000030;\" " : "") ."><td>" . $log['id'] . "</td><td>" . $log['created_at'] . "</td><td>" . $log['action'] . "</td><td>" . $log['user_id'] . "</td><td>" . $log['user']['email'] . "</td></tr>";
            $pari = !$pari;
        }
        $table .= "</tbody></table>";
        return $table;
    }

    public function all() {
        return Log::with('user')->orderBy('id','desc')->get();
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
    
    public static function game_create(Game $game) {
        LogController::create_and_associate("Game | create game (" . $game->id . ")" );
    }
}