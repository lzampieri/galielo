<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ccup;
use App\Models\Game;
use Illuminate\Database\QueryException;

class CCupController extends Controller
{
    public static function checkAndCreate(Game $lastgame) {
        try {
            // Get actual champions
            $latest = Ccup::orderBy('ID','desc')->first();

            // Check if they've been defeated in the current match
            // if( $latest->att1)
            return $latest;
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'errorInfo' => $e->errorInfo
            ]);
        }
    }

}

    // // Check if they're defeated
    // if( ($champions["Att"] == $att2 and $champions["Dif"] == $dif2) or ($champions["Att"] == $dif2 and $champions["Dif"] == $att2)) {

    //     // Check if they've already been defeated in correct time intervals
    //     $result = query("SELECT ID, Timestamp FROM partite WHERE (( Att2 = ".$champions["Att"]." AND Dif2 = ".$champions["Dif"]." ) OR ( Att2 = ".$champions["Dif"]." AND Dif2 = ".$champions["Att"]." )) AND (( Att1 = ".$att1." AND Dif1 = ".$dif1." ) OR ( Att1 = ".$dif1." AND Dif1 = ".$att1.")) AND Timestamp > \"".$champions["time"]."\" AND Hidden = 0 ORDER BY ID DESC LIMIT 2");
    //     if(mysqli_num_rows($result) > 1) {
    //         $match1 = mysqli_fetch_assoc($result);
    //         $match2 = mysqli_fetch_assoc($result);
            
    //         $timeok = true;
    //         $result = query("SELECT ID, Timestamp FROM partite WHERE (( Att1 = ".$champions["Att"]." AND Dif1 = ".$champions["Dif"]." ) OR ( Att1 = ".$champions["Dif"]." AND Dif1 = ".$champions["Att"]." )) AND (( Att2 = ".$att1." AND Dif2 = ".$dif1." ) OR ( Att2 = ".$dif1." AND Dif2 = ".$att1.")) AND Hidden = 0 ORDER BY ID DESC LIMIT 2");
    //         if(mysqli_num_rows($result) > 1) {
    //             $match3 = mysqli_fetch_assoc($result);
    //             $match3 = mysqli_fetch_assoc($result);
    //             if(strtotime($match3["Timestamp"]) > strtotime($match2["Timestamp"]))  {
    //                 $timeok = false;
    //             }
    //         }
            
    //         if($timeok) {
    //             query("INSERT INTO ccup(Att, Dif, Match1, Match2) VALUES (".$att1.",".$dif1.",".$match1["ID"].",".$match2["ID"].")");
    //             log_to_database("New ccup (Att, Dif, Match1, Match2) = (".$att1.",".$dif1.",".$match1["ID"].",".$match2["ID"].")");
    //             $output["ccup"] = true;
    //         }
    //     }
    // }

