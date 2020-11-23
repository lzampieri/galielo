<?php
/*
1) player.php           List of all matches
                        A json object with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2,
                        reverse ordered by Timestamp (most recent first)
2) player.php|POST["add","att1":idAtt1,"att2":idAtt2,"dif1":idDif1,"dif2":idDif2,"pt1":10,"pt2":pt2]
                        Add a match
                        Return the match item with the same properties as above,
                        plus a "success":true item, plus a "ccup":true|false if the ccup have been updated
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

if( array_key_exists("add", $_POST)) {

    // Extract data from post
    if (
        ! array_key_exists("att1", $_POST) ||
        ! array_key_exists("att2", $_POST) ||
        ! array_key_exists("dif1", $_POST) ||
        ! array_key_exists("dif2", $_POST) ||
        ! array_key_exists("pt1", $_POST) ||
        ! array_key_exists("pt2", $_POST)
    ) {
        echo json_encode(array("success" => false, "error_message" => "Params not given"));
        exit;
    }
    
    $att1 = $_POST["att1"];
    $att2 = $_POST["att2"];
    $dif1 = $_POST["dif1"];
    $dif2 = $_POST["dif2"];
    $pt1 = $_POST["pt1"];
    $pt2 = $_POST["pt2"];

    // Check for correctness
    if ( $pt1 != 10 || $pt2 >= 10 ) {
        echo json_encode(array("success" => false, "error_message" => "Points team 1 one must be 10 and team 2 must be less"));
        exit;
    }

    // Get users
    if (
        $att1 == $att2 ||
        $att1 == $dif1 ||
        $att1 == $dif2 ||
        $att2 == $dif1 ||
        $att2 == $dif2 ||
        $dif1 == $dif2
    ) {
        echo json_encode(array("success" => false, "error_message" => "Duplicate player"));
        exit;
    }

    $prof_att1 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $att1") );
    $prof_dif1 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $dif1") );
    $prof_att2 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $att2") );
    $prof_dif2 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $dif2") );

    if (
        !$prof_att1 ||
        !$prof_att2 ||
        !$prof_dif1 ||
        !$prof_dif2
    ) {
        echo json_encode(array("success" => false, "error_message" => "Players not found"));
        exit;
    }

    // Compute variations
    $eloa1 = $prof_att1['PuntiA'];
    $eloa2 = $prof_att2['PuntiA'];
    $elod1 = $prof_dif1['PuntiD'];
    $elod2 = $prof_dif2['PuntiD'];

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

    // Save update data
    query("UPDATE giocatori SET PuntiA = ". $eloa1 + $va1 ." WHERE ID = ".$att1);
    query("UPDATE giocatori SET PuntiA = ". $eloa2 + $va2 ." WHERE ID = ".$att2);
    query("UPDATE giocatori SET PuntiD = ". $elod1 + $vd1 ." WHERE ID = ".$dif1);
    query("UPDATE giocatori SET PuntiD = ". $elod2 + $vd2 ." WHERE ID = ".$dif2);

    // Save match
    query("INSERT INTO partite (Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2) VALUES ($att1, $att2, $dif1, $dif2, $va1, $va2, $vd1, $vd2, $pt1, $pt2)");

    // Get saved match
    $lastid = get_last_id();
    $output = mysqli_fetch_assoc( query( "SELECT * FROM partite WHERE id = ". $lastid ) );
    $output["success"] = true;

    // Champions cup
    $output["ccup"] = false;
    // Get actual champions
    $champions = mysqli_fetch_assoc(query("SELECT ccup.Att AS Att, ccup.Dif as Dif, partite.Timestamp AS time FROM ccup LEFT JOIN partite ON ccup.Match1 = partite.ID ORDER BY ccup.ID DESC LIMIT 1"));
    if($champions["time"] == NULL) $champions["time"]=0;

    // Check if they're defeated
    if( ($champions["Att"] == $att2 and $champions["Dif"] == $dif2) or ($champions["Att"] == $dif2 and $champions["Dif"] == $att2)) {

        // Check if they've already been defeated in correct time intervals
        $result = query("SELECT ID, Timestamp FROM partite WHERE (( Att2 = ".$champions["Att"]." AND Dif2 = ".$champions["Dif"]." ) OR ( Att2 = ".$champions["Dif"]." AND Dif2 = ".$champions["Att"]." )) AND (( Att1 = ".$att1." AND Dif1 = ".$dif1." ) OR ( Att1 = ".$dif1." AND Dif1 = ".$att1.")) AND Timestamp > \"".$champions["time"]."\" ORDER BY ID DESC LIMIT 2");
        if(mysqli_num_rows($result) > 1) {
            $match1 = mysqli_fetch_assoc($result);
            $match2 = mysqli_fetch_assoc($result);
            
            $timeok = true;
            $result = query("SELECT ID, Timestamp FROM partite WHERE (( Att1 = ".$champions["Att"]." AND Dif1 = ".$champions["Dif"]." ) OR ( Att1 = ".$champions["Dif"]." AND Dif1 = ".$champions["Att"]." )) AND (( Att2 = ".$att1." AND Dif2 = ".$dif1." ) OR ( Att2 = ".$dif1." AND Dif2 = ".$att1.")) ORDER BY ID DESC LIMIT 2");
            if(mysqli_num_rows($result) > 1) {
                $match3 = mysqli_fetch_assoc($result);
                $match3 = mysqli_fetch_assoc($result);
                if(strtotime($match3["Timestamp"]) > strtotime($match2["Timestamp"]))  {
                    $timeok = false;
                }
            }
            
            if($timeok) {
                query("INSERT INTO ccup(Att, Dif, Match1, Match2) VALUES (".$att1.",".$dif1.",".$match1["ID"].",".$match2["ID"].")");
                $output["ccup"] = true;
            }
        }
    }

    echo json_encode( $output, JSON_NUMERIC_CHECK);
    exit;
} else {
    // Get matches details
    $query_matches = query("SELECT * FROM partite");
    echo json_encode(array_from_query($query_matches),JSON_NUMERIC_CHECK);
}
?>
