<?php
	
$result = query("SELECT * FROM torn_sq WHERE tornID = ".$torn["ID"]);
if(mysqli_num_rows($result) == 0 ) {
	echo "<div align=\"center\">Nessuna squadra iscritta al torneo.</div>";
	return;
}
?>
<div align="center">
<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Tot">
    <thead>
    <tr class="w3-light-grey">
        <th width="40%">Squadra sfidante</th>
        <th width="40%">Squadra sfidata</th>
        <th >Risultato</th>
    </tr>
    </thead>
    <?php
	$sq = array();
	$match = array();
	while( $t = mysqli_fetch_assoc($result) ) {
		$sq[$t["ID"]] = $t["att"].", ".$t["dif"];
		$match[$t["ID"]] = array();
	}
	$result = query("SELECT * FROM torn_match WHERE tornID = ".$torn["ID"]);
	while( $t = mysqli_fetch_assoc($result) ) {
		$match[$t["winID"]][$t["losID"]] = $t["losPT"];
	}
	foreach($sq as $sqID => $sqNM) {
		foreach($sq as $sq2ID => $sq2NM) {
			if($sq2ID < $sqID) {
				?>
				<tr>
					<td><?php echo $sqNM; ?> </td>
					<td><?php echo $sq2NM; ?> </td>
				<?php
					if(array_key_exists($sq2ID, $match[$sqID])) {
						?>
						<td><?php echo "10 - ".$match[$sqID][$sq2ID]; ?></td>
						<?php
					} else if(array_key_exists($sqID, $match[$sq2ID])){
						?>
						<td><?php echo $match[$sq2ID][$sqID]." - 10"; ?></td>
						<?php
					} else {
						echo "<td style=\"padding:0px !important; vertical-align:middle !important;\"><a href=\"save_tabell.php?sq1=".$sqID."&sq2=".$sq2ID."&torn=".$torn["ID"]."\"><div class=\"w3-btn far fa-plus-square\"></div></a></td>";
					} ?>
				</tr>
				<?php
			}
		}
	}
	?>
</table>
</div>