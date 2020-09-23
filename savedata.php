<?php
if(!isset($_POST["att1"]) or !isset($_POST["att2"]) or !isset($_POST["dif1"]) or !isset($_POST["dif2"]) or !isset($_POST["sq1"]) or !isset($_POST["sq2"])) {
	header("location: /newmatch.php?err");
	abort();
}
$att1 = $_POST["att1"];
$att2 = $_POST["att2"];
$dif1 = $_POST["dif1"];
$dif2 = $_POST["dif2"];
$pti1 = $_POST["sq1"];
$pti2 = $_POST["sq2"];

require_once("script/utilities.php");
$result = query("SELECT * FROM giocatori WHERE ID IN (".$att1.", ".$att2.", ".$dif1.", $dif2 )");
if(mysqli_num_rows($result) != 4) {
	header("location: /newmatch.php?err");
	abort();
}

$eloa1;
$eloa2;
$elod1;
$elod2;
while( $row = mysqli_fetch_assoc($result) ) {
	if($row["ID"] == $att1) $eloa1=$row["PuntiA"];
	if($row["ID"] == $att2) $eloa2=$row["PuntiA"];
	if($row["ID"] == $dif1) $elod1=$row["PuntiD"];
	if($row["ID"] == $dif2) $elod2=$row["PuntiD"];
}

$fr = 34.0*exp(-0.14*$pti2);

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

$eloa1 += $va1;
$elod1 += $vd1;
$eloa2 += $va2;
$elod2 += $vd2;

query("UPDATE giocatori SET PuntiA = ".$eloa1." WHERE ID = ".$att1);
query("UPDATE giocatori SET PuntiA = ".$eloa2." WHERE ID = ".$att2);
query("UPDATE giocatori SET PuntiD = ".$elod1." WHERE ID = ".$dif1);
query("UPDATE giocatori SET PuntiD = ".$elod2." WHERE ID = ".$dif2);

query("INSERT INTO partite (Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2) VALUES ($att1, $att2, $dif1, $dif2, $va1, $va2, $vd1, $vd2, $pti1, $pti2)");

/*COPPIA DEI CAMPIONI*/
$campioni = mysqli_fetch_assoc(query("SELECT ccup.Att AS Att, ccup.Dif as Dif, partite.Timestamp AS time FROM ccup LEFT JOIN partite ON ccup.Match1 = partite.ID ORDER BY ccup.ID DESC LIMIT 1"));
$newccup = false;
if($campioni["time"] == NULL) $campioni["time"]=0;

if( ($campioni["Att"] == $att2 and $campioni["Dif"] == $dif2) or ($campioni["Att"] == $dif2 and $campioni["Dif"] == $att2)) {
	$result = query("SELECT ID, Timestamp FROM partite WHERE (( Att2 = ".$campioni["Att"]." AND Dif2 = ".$campioni["Dif"]." ) OR ( Att2 = ".$campioni["Dif"]." AND Dif2 = ".$campioni["Att"]." )) AND (( Att1 = ".$att1." AND Dif1 = ".$dif1." ) OR ( Att1 = ".$dif1." AND Dif1 = ".$att1.")) AND Timestamp > \"".$campioni["time"]."\" ORDER BY ID DESC LIMIT 2");
	if(mysqli_num_rows($result) > 1) {
		$match1 = mysqli_fetch_assoc($result);
		$match2 = mysqli_fetch_assoc($result);
		
		$timeok = true;
		$result = query("SELECT ID, Timestamp FROM partite WHERE (( Att1 = ".$campioni["Att"]." AND Dif1 = ".$campioni["Dif"]." ) OR ( Att1 = ".$campioni["Dif"]." AND Dif1 = ".$campioni["Att"]." )) AND (( Att2 = ".$att1." AND Dif2 = ".$dif1." ) OR ( Att2 = ".$dif1." AND Dif2 = ".$att1.")) ORDER BY ID DESC LIMIT 2");
		if(mysqli_num_rows($result) > 1) {
			$match3 = mysqli_fetch_assoc($result);
			$match3 = mysqli_fetch_assoc($result);
			if(strtotime($match3["Timestamp"]) > strtotime($match2["Timestamp"]))  {
				$timeok = false;
			}
		}
		
		
		if($timeok) {
			query("INSERT INTO ccup(Att, Dif, Match1, Match2) VALUES (".$att1.",".$dif1.",".$match1["ID"].",".$match2["ID"].")");
			$newccup = true;
		}
	}
}


if($newccup) header("location: /index.php?newccup");
else header("location: /index.php?saved");
?>