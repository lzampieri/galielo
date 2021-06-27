<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CcupResource;
use App\Models\Ccup;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\QueryException;

class CcupController extends Controller
{
    public static function checkAndCreate(Game $lastgame) {
        // Get actual champions
        $lastcup = Ccup::orderBy('ID','desc')->first();

        // Check if they've been defeated in the current match
        if( !( $lastcup->pl1_id == $lastgame->att2_id && $lastcup->pl2_id == $lastgame->dif2_id) &&
            !( $lastcup->pl2_id == $lastgame->att2_id && $lastcup->pl1_id == $lastgame->dif2_id) )
            return false;
        
        $pl1_old = $lastcup->pl1_id;
        $pl2_old = $lastcup->pl2_id;
        $pl1_new = $lastgame->att1_id;
        $pl2_new = $lastgame->dif1_id;

        // Check if old ones have been already defeated by the new couple
        $win_games = Game::whereIn( 'att1_id', [ $pl1_new, $pl2_new ] )
                            ->whereIn( 'dif1_id', [ $pl1_new, $pl2_new ] )
                            ->whereIn( 'att2_id', [ $pl1_old, $pl2_old ] )
                            ->whereIn( 'dif2_id', [ $pl1_old, $pl2_old ] )
                            ->orderBy( 'ID','desc' )
                            ->limit(2)->get();
        if( $win_games->count() != 2 )
            return false;
        
        // Check if old ones have already defeated the new couple
        $lost_games = Game::whereIn( 'att1_id', [ $pl1_old, $pl2_old ] )
                            ->whereIn( 'dif1_id', [ $pl1_old, $pl2_old ] )
                            ->whereIn( 'att2_id', [ $pl1_new, $pl2_new ] )
                            ->whereIn( 'dif2_id', [ $pl1_new, $pl2_new ] )
                            ->orderBy( 'ID','desc' )
                            ->limit(2)->get();
        if( $lost_games->count() == 2 ) {
            // If the old couple have already defeated the old one, verify that this has 
            // happened enough time ago
            $old_win_game_id = $win_games->last()->id;
            $old_lost_game_id = $lost_games->last()->id;
            if( $old_win_game_id < $old_lost_game_id )
                return false;
        }

        // If this point is reached, all test are passed: this means that the Ccup is assigned!
        // Save match
        $ccup = new Ccup();
        $ccup -> pl1 () -> associate( Player::findOrFail( $pl1_new ) );
        $ccup -> pl2 () -> associate( Player::findOrFail( $pl2_new ) );
        $ccup -> game1 () -> associate( $lastgame );
        $ccup -> game2 () -> associate( $win_games->last() );
        $ccup -> save();

        // Log the insertion
        LogController::ccup_create( $ccup );

        return true;
    }

    public function all() {
        return CcupResource::collection( Ccup::all() );
    }

}

