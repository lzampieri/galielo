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
	
    $result = query("SELECT * FROM torn_sq WHERE tornID = ".$torn["ID"]);
	if(mysqli_num_rows($result) == 0) {
		echo "<div align=\"center\">Nessuna squadra iscritta al torneo.</div>";
		return;
	}
	?>
   
<div align="center">
<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Tot">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Nome</th>
        <th width="20%">Punti</th>
        <th width="20%">Gol fatti</th>
        <th width="20%">Gol subiti</th>
        <th width="20%">Partite giocate</th>
    </tr>
    </thead> 
   
    <?php
    $sq = array();
    while( $t = mysqli_fetch_assoc($result) ) {
		$sq[$t["ID"]] = array();
		$sq[$t["ID"]]["ID"] = $t["ID"];
        $sq[$t["ID"]]["name"] = $t["att"].", ".$t["dif"];
		$sq[$t["ID"]]["pti"] = 0;
		$sq[$t["ID"]]["match"] = 0;
		$sq[$t["ID"]]["done"] = 0;
		$sq[$t["ID"]]["sub"] = 0;
    }
    $result = query("SELECT * FROM torn_match WHERE tornID = ".$torn["ID"]);
    while( $t = mysqli_fetch_assoc($result) ) {
        if( $t["losPT"] == 9 ) {
            $sq[$t["winID"]]["pti"] += 2;
            $sq[$t["losID"]]["pti"] += 1;	
        }
        else $sq[$t["winID"]]["pti"] += 3;
        $sq[$t["winID"]]["match"] += 1;
        $sq[$t["losID"]]["match"] += 1;
		$sq[$t["winID"]]["done"] += 10;
		$sq[$t["losID"]]["sub"] += 10;
		$sq[$t["losID"]]["done"] += $t["losPT"];
		$sq[$t["winID"]]["sub"] += $t["losPT"];
		$sq[$t["winID"]][$t["losID"]] = 1;
    }
    uasort($sq,'cmp');
    foreach($sq as $csq) {
    ?>
    	<tr>
			<td><?php echo $csq["name"]; ?> </td>
            <td><?php echo $csq["pti"]; ?> </td>
			<td><?php echo $csq["done"]; ?> </td>
			<td><?php echo $csq["sub"]; ?> </td>
			<td><?php echo $csq["match"]; ?> </td>
        </tr>
 	<?php
    }
    ?>
</table>
</div>