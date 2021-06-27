<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Param;
use App\Models\Player;
use App\Models\Table;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function create(Request $request) {
        try {
            // Retrive players
            $att1 = Player::findOrFail( $request->input('att1') );
            $dif1 = Player::findOrFail( $request->input('dif1') );
            $att2 = Player::findOrFail( $request->input('att2') );
            $dif2 = Player::findOrFail( $request->input('dif2') );
            $pt2  = $request->input('points');
            $table= Table::findOrFail( $request->input('table', 1) );
            
            // Compute variations
            $eloa1 = $att1->apoints;
            $elod1 = $dif1->dpoints;
            $eloa2 = $att2->apoints;
            $elod2 = $dif2->dpoints;

            $fr = 34.0*exp(-0.14*$pt2);
            $sq1=pow(((pow($eloa1,3)+pow($elod1,3))/2.0),0.33);
            $sq2=pow(((pow($eloa2,3)+pow($elod2,3))/2.0),0.33);

            $fp = 1.0 - (1.0 / ( 1.0 + pow(10.0,($sq2-$sq1)/400.0)));

            $coef1=2.0*$elod1/($eloa1+$elod1);
            $coef2=2.0*$eloa1/($eloa1+$elod1);
            $coef3=2.0*$eloa2/($eloa2+$elod2);
            $coef4=2.0*$elod2/($eloa2+$elod2);

            $va1 = ceil($fp * $fr * $coef1);
            $va2 = -ceil($fp * $fr * $coef3);
            $vd1 = ceil($fp * $fr * $coef2);
            $vd2 = -ceil($fp * $fr * $coef4);

            // Update players data
            $att1 -> apoints = $eloa1 + $va1;
            $dif1 -> dpoints = $elod1 + $vd1;
            $att2 -> apoints = $eloa2 + $va2;
            $dif2 -> dpoints = $elod2 + $vd2;

            $att1 -> save();
            $dif1 -> save();
            $att2 -> save();
            $dif2 -> save();

            LogController::player_changeApoints($att1, $eloa1);
            LogController::player_changeDpoints($dif1, $elod1);
            LogController::player_changeApoints($att2, $eloa2);
            LogController::player_changeDpoints($dif2, $elod2);

            // Save match
            $game = new Game( [
                'deltaa1' => $va1,
                'deltad1' => $vd1,
                'deltaa2' => $va2,
                'deltad2' => $vd2,
                'pt1' => 10,
                'pt2' => $pt2
            ]);
            $game -> att1 () -> associate( $att1 );
            $game -> dif1 () -> associate( $dif1 );
            $game -> att2 () -> associate( $att2 );
            $game -> dif2 () -> associate( $dif2 );
            $game -> table() -> associate( $table);
            $game -> author() -> associate( Auth::user() );

            $game -> save();

            LogController::game_create( $game );
            
            // Check if Ccup must be assigned
            $ccup = CcupController::checkAndCreate( $game );

            $response = (new GameResource( $game ))->toArray($request);
            $response[ 'success' ] = true;
            $response[ 'ccup' ] = $ccup;
            return response()->json( $response );
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'errorInfo' => $e->errorInfo
            ]);
        }
    }

    public function all() {
        return GameResource::collection( Game::all() );
    }
    
    public function some() {
        return GameResource::collection( Game::orderBy('ID','desc')->paginate( Param::find('games_pages_length')->value ) );
    }

    public function testCcup() {
        return CcupController::checkAndCreate( Game::latest('ID')->first() ) ? "Yes" : "No";
    }
}