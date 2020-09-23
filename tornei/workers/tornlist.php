<div align="center">
<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Tot">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Torneo</th>
        <th width="20%">Inizio</th>
        <th width="20%">Fine</th>
        <th width="15%">Stato</th>
        <th width="20%">Vincitori</th>
        <th width="5%"></th>
    </tr>
    </thead>
    
    <?php
    
	if(isset($admincose))
	    $torns = query("SELECT t.ID AS ID, t.startData AS start, t.endData AS end, t.stato AS stato, t.nome AS nome, ts.att AS att, ts.dif AS dif, t.visib AS visib FROM tornei AS t LEFT JOIN torn_direct AS td ON t.ID = td.tornID LEFT JOIN torn_sq AS ts ON t.ID = ts.tornID AND td.winfin = ts.ID ORDER BY startData DESC");
	else $torns = query("SELECT t.ID AS ID, t.startData AS start, t.endData AS end, t.stato AS stato, t.nome AS nome, ts.att AS att, ts.dif AS dif, t.visib AS visib FROM tornei AS t LEFT JOIN torn_direct AS td ON t.ID = td.tornID LEFT JOIN torn_sq AS ts ON t.ID = ts.tornID AND td.winfin = ts.ID WHERE t.visib = 1 ORDER BY startData DESC");
	
	if(mysqli_num_rows($torns) == 0) echo "Nessun torneo al momento disponibile.";
	while($torn = mysqli_fetch_assoc($torns)) {
		?>
    	<tr>
			<td><?php echo $torn["nome"]; ?> </td>
            <td><?php echo $torn["start"]; ?> </td>
			<td><?php echo $torn["end"]; ?> </td>
			<td><?php
				if($torn["stato"] == 0) echo "Concluso";
				else if($torn["stato"] == 1) echo "Prima fase";
				else if($torn["stato"] == 2) echo "Scontri diretti";
				else echo "Annullato";
				if($torn["visib"] == 0) echo ", Nascosto";
				?> </td>
			<td><?php if($torn["stato"] == 0) echo $torn["att"].", ".$torn["dif"]; ?> </td>
         <?php if(isset($admincose)) { ?>
            <td style="padding:0px !important; vertical-align:middle !important;"><a href="modtorn.php?tid=<?php echo $torn["ID"]; ?>">Mod</a></td>		 
		 <?php } else { ?>
            <td style="padding:0px !important; vertical-align:middle !important;"><a href="torn.php?tid=<?php echo $torn["ID"]; ?>"><div class="w3-btn fas fa-external-link-alt"></div></a></td>
         <?php } ?>
        </tr>
 		<?php }
    ?>
</table></div>