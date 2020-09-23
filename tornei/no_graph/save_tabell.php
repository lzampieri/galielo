<?php
function cmp($a, $b) {
		if ($a["pti"] == $b["pti"]) {
			if(array_key_exists($b["ID"],$a)) return -1;
			if(array_key_exists($a["ID"],$b)) return 1;
			$diff = $a["done"]-$a["sub"]+$b["sub"]-$a["done"];
			if($diff > 0) return -1;
			if($diff < 0) return 1;
			return 0;
		}
		return ($a["pti"] < $b["pti"]) ? 1 : -1;
	}
	
require_once("../../script/utilities.php");

$sq1 = $_POST["sq1"];
$sq2 = $_POST["sq2"];
$pti1 = $_POST["pti".$sq1];
$pti2 = $_POST["pti".$sq2];
$tid = $_POST["tid"];

if($pti1==10)
	query("INSERT INTO torn_match(tornID, winID, losID, losPT) VALUES ($tid , $sq1 , $sq2 , $pti2 )");
else if($pti2==10)
	query("INSERT INTO torn_match(tornID, winID, losID, losPT) VALUES ($tid , $sq2 , $sq1 , $pti1 )");
else {
	header("location: ../index.php?errIns");
	return;
}
$nummatch = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM torn_match WHERE tornID = $tid"))["cc"];
$numsq = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM torn_sq WHERE tornID = $tid"))["cc"];
$numatt = $numsq * ($numsq-1) / 2;
if($numatt == $nummatch) {
	
    $result = query("SELECT * FROM torn_sq WHERE tornID = ".$tid);
    $sq = array();
    while( $t = mysqli_fetch_assoc($result) ) {
		$sq[$t["ID"]] = array();
		$sq[$t["ID"]]["ID"] = $t["ID"];
		$sq[$t["ID"]]["pti"] = 0;
    }
    $result = query("SELECT * FROM torn_match WHERE tornID = ".$tid);
    while( $t = mysqli_fetch_assoc($result) ) {
        if( $t["losPT"] == 9 ) {
            $sq[$t["winID"]]["pti"] += 2;
            $sq[$t["losID"]]["pti"] += 1;	
        }
        else $sq[$t["winID"]]["pti"] += 3;
		$sq[$t["winID"]][$t["losID"]] = 1;
    }
    usort($sq,'cmp');
	
	query("UPDATE tornei SET stato = 2 WHERE ID = $tid");
	query("DELETE FROM torn_direct WHERE ID = $tid");
	query("INSERT INTO torn_direct(tornID, sq1, sq2, sq3, sq4) VALUES ($tid , ".$sq[0]["ID"].", ".$sq[1]["ID"].", ".$sq[2]["ID"].", ".$sq[3]["ID"].")");
}
header("location: ../index.php");
?>