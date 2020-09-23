<div align="center">
<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Tot">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Data di chiusura</th>
        <th width="20%">Squadra Vincitrice</th>
        <th width="20%">Squadra Perdente</th>
        <th width="15%">Punteggio</th>
        <th width="20%"></th>
    </tr>
    </thead>
    
    <?php
    
	$torns = query("SELECT t.ID AS ID, t.closeTime AS closeTime, t.stato AS stato, t.sq0 AS sq0, t.sq1 AS sq1, p0.pt AS pt0, p1.pt AS pt1 FROM t12h AS t LEFT JOIN ( SELECT COUNT(ID) AS pt, torneo AS tid0 FROM p12h WHERE sq = 0 GROUP BY torneo ) AS p0 ON t.ID = p0.tid0 LEFT JOIN ( SELECT COUNT(ID) AS pt, torneo AS tid1 FROM p12h WHERE sq = 1 GROUP BY torneo ) AS p1 ON t.ID = p1.tid1 ORDER BY closeTime DESC");
	
	if(mysqli_num_rows($torns) == 0) echo "Nessuna 12h al momento disponibile.";
	while($torn = mysqli_fetch_assoc($torns)) {
		if($torn["stato"] != 3 or isset($admincose)) {
		$pt0 = ($torn["pt0"]==NULL?0:$torn["pt0"]);
		$pt1 = ($torn["pt1"]==NULL?0:$torn["pt1"]);
		?>
    	<tr>
			<td><?php echo $torn["closeTime"]; ?> </td>
            <td><?php echo ($pt0>$pt1?$torn["sq0"]:$torn["sq1"]); ?> </td>
            <td><?php echo ($pt0>$pt1?$torn["sq1"]:$torn["sq0"]); ?> </td>
			<td><?php echo ($pt0>$pt1?$pt0." - ".$pt1:$pt1." - ".$pt0) ?> </td>
			<td><?php
				if($torn["stato"] == 0) echo "Non ancora attivo";
				else if($torn["stato"] == 1) echo "In corso";
				else if($torn["stato"] == 2) echo "Concluso";
				else if($torn["stato"] == 3) echo "Nascosto";
				?>
                <?php if(isset($admincose) and $torn["stato"] == 0) { ?><a href="mod12h.php?start&id=<?php echo $torn["ID"]; ?>">Inizia</a> <?php } ?>
                <?php if(isset($admincose) and $torn["stato"] == 1) { ?><a href="mod12h.php?end&id=<?php echo $torn["ID"]; ?>">Concludi</a> <?php } ?>
                <?php if(isset($admincose) and $torn["stato"] == 2) { ?><a href="mod12h.php?disable&id=<?php echo $torn["ID"]; ?>">Disabilita</a> <?php } ?>
                </td>
        </tr>
 		<?php }}
    ?>
</table></div>