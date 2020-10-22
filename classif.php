<script type="text/javascript">
function filter(evt, chosen) {
    var i, x, tablinks;
    x = document.getElementsByClassName("classif");
    for (i = 0; i < x.length; i++) {
        x[i].style.visibility = "collapse";
    }
    tablinks = document.getElementsByClassName("filt");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
    }
    document.getElementById(chosen).style.visibility = "visible";
    evt.currentTarget.className += " w3-red";
}
</script>
<?php
$pointbadge = trim(file_get_contents('conf/puntibadge.txt'));
$pointshit = trim(file_get_contents("conf/pointshit.txt"));
$giocatt = array();
$giocdif = array();
$giocattmese = array();
$giocdifmese = array();
$resultAtt = query("SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Att1 AS Gioc FROM partite UNION SELECT ID, Att2 AS Gioc FROM partite) AS t1 GROUP BY Gioc");
while( ($row = mysqli_fetch_assoc($resultAtt) ) != NULL) $giocatt[$row["Gioc"]] = $row["cc"];
$resultDif = query("SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Dif1 AS Gioc FROM partite UNION SELECT ID, Dif2 AS Gioc FROM partite) AS t1 GROUP BY Gioc");
while( ($row = mysqli_fetch_assoc($resultDif) ) != NULL) $giocdif[$row["Gioc"]] = $row["cc"];
$resultAttMese = query("SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Att1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Att2, Timestamp AS Gioc FROM partite) AS t1 WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 GROUP BY Gioc");
while( ($row = mysqli_fetch_assoc($resultAttMese) ) != NULL) $giocattmese[$row["Gioc"]] = $row["cc"];
$resultDifMese = query("SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Dif1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Dif2, Timestamp AS Gioc FROM partite) AS t1  WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 GROUP BY Gioc");
while( ($row = mysqli_fetch_assoc($resultDifMese) ) != NULL) $giocdifmese[$row["Gioc"]] = $row["cc"];

function get_or_zero($array, $key) {
    if( array_key_exists($key,$array)) return $array[$key];
    else return 0;
}
?>
    <div align="center">
        <div class="width60 w3-bar" align="right">
        <?php if(isset($completa) and !isset($admincose)) { ?>
        	<a href="/index.php"><button class="w3-bar-item w3-button w3-right"><i class="fas fa-exchange-alt"></i> Completa</button></a>   
        <?php } else if(!isset($completa)) { ?>
        	<a href="/classcompl.php"><button class="w3-bar-item w3-button w3-right"><i class="fas fa-exchange-alt"></i> Attivi</button></a>
        <?php } ?>
        <button class="w3-bar-item w3-button w3-right filt" onclick="filter(event,'Dif')">Difesa</button>
        <button class="w3-bar-item w3-button w3-right filt" onclick="filter(event,'Att')">Attacco</button>
        <button class="w3-bar-item w3-button w3-right filt w3-red" onclick="filter(event,'Tot')">Totale</button>
	</div>
    <?php
	$result = query("SELECT ID,Nome,(PuntiA+PuntiD)/2.0 AS PuntiT FROM giocatori ORDER BY PuntiT DESC");
	?>
	<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Tot">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Nome</th>
        <th width="20%">Punti Totali</th>
        <th width="20%">Partite Totali</th>
        <th width="20%">Partite<br/>Ultimo Mese</th>
        <?php if(isset($admincose)) { ?> <th>Modifica</th> <?php } ?>
    </tr>
    </thead>
    <?php
	while( $row = mysqli_fetch_assoc($result) ) {
		if( get_or_zero($giocattmese,$row["ID"])+ get_or_zero($giocdifmese,$row["ID"]) >= 10 or isset($completa)) {
	?>
    <tr>
    	<td><?php 
		if($row["PuntiT"] >= $pointbadge) echo "<i class=\"fas fa-crown\"></i> ";
		if($row["PuntiT"] <= $pointshit) echo "<i class=\"fas fa-blender\"></i> ";
		if($giocattmese[$row["ID"]]+$giocdifmese[$row["ID"]] < 10) echo " <i class=\"fas fa-bed\"></i> ";
		echo "<a href=\"playerstats.php?id=".$row["ID"]."\">".$row["Nome"]."</a>"; 
		?></td>
        <td><?php echo ceil($row["PuntiT"]); ?></td>
        <td><?php echo $giocatt[$row["ID"]]+$giocdif[$row["ID"]]; ?></td>
        <td><?php echo $giocattmese[$row["ID"]]+$giocdifmese[$row["ID"]]; ?></td>
		<?php if(isset($admincose)) { ?>
        <td><a href="modgioc.php?id=<?php echo $row["ID"]; ?>"><button class="w3-button"><div class="fa fa-edit"></div></button></a></td> 
        <?php } ?>
    </tr>
    <?php }} ?>
    </table>
    
    
    <?php
	$result = query("SELECT ID,Nome,PuntiA FROM giocatori ORDER BY PuntiA DESC");
	?>
	<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Att" style="visibility:collapse">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Nome</th>
        <th width="20%">Punti Attacco</th>
        <th width="20%">Partite in attacco</th>
        <th width="20%">Partite in attacco<br/>Ultimo Mese</th>
        <?php if(isset($admincose)) { ?> <th>Modifica</th> <?php } ?>
    </tr>
    </thead>
    <?php
	while( $row = mysqli_fetch_assoc($result) ) {
	if( get_or_zero($giocattmese,$row["ID"]) >= 10 or isset($completa)) {
	?>
    <tr>
    	<td><?php 
		if($row["PuntiA"] >= $pointbadge) echo "<i class=\"fas fa-crown\"></i> ";
		if($row["PuntiA"] <= $pointshit) echo "<i class=\"fas fa-blender\"></i> ";
		if($giocattmese[$row["ID"]] < 10) echo " <i class=\"fas fa-bed\"></i> ";
		echo "<a href=\"playerstats.php?id=".$row["ID"]."\">".$row["Nome"]."</a>"; 
		?></td>
        <td><?php echo $row["PuntiA"]; ?></td>
        <td><?php echo $giocatt[$row["ID"]]; ?></td>
        <td><?php echo $giocattmese[$row["ID"]]; ?></td>
		<?php if(isset($admincose)) { ?>
        <td><a href="modgioc.php?id=<?php echo $row["ID"]; ?>"><button class="w3-button"><div class="fa fa-edit"></div></button></a></td> 
        <?php }} ?>
    </tr>
    <?php } ?>
    </table>
    
    <?php
	$result = query("SELECT ID,Nome,PuntiD FROM giocatori ORDER BY PuntiD DESC");
	?>
	<table class="w3-card-4 w3-table-all w3-hoverable width60 classif" id="Dif" style="visibility:collapse">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Nome</th>

        <th width="20%">Punti Difesa</th>
        <th width="20%">Partite in difesa</th>
        <th width="20%">Partite in difesa<br/>Ultimo Mese</th>        
        <?php if(isset($admincose)) { ?> <th>Modifica</th> <?php } ?>
    </tr>
    </thead>
    <?php
	while( $row = mysqli_fetch_assoc($result) ) {
	if( get_or_zero($giocdifmese,$row["ID"]) >= 10 or isset($completa)) {
	?>
    <tr>
    	<td><?php 
		if($row["PuntiD"] >= $pointbadge) echo "<i class=\"fas fa-crown\"></i> ";
		if($row["PuntiD"] <= $pointshit) echo "<i class=\"fas fa-blender\"></i> ";
		if($giocdifmese[$row["ID"]] < 10 ) echo " <i class=\"fas fa-bed\"></i> ";
		echo "<a href=\"playerstats.php?id=".$row["ID"]."\">".$row["Nome"]."</a>"; 
		?></td>
        <td><?php echo $row["PuntiD"]; ?></td>
        <td><?php echo $giocdif[$row["ID"]]; ?></td>
        <td><?php echo $giocdifmese[$row["ID"]]; ?></td>
         <?php if(isset($admincose)) { ?>
        <td><a href="modgioc.php?id=<?php echo $row["ID"]; ?>"><button class="w3-button"><div class="fa fa-edit"></div></button></a></td> 
        <?php }} ?>
    </tr>
    <?php } ?>
    </table>
</div>