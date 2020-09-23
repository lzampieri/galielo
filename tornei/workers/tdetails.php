<?php
$torns = query("SELECT * FROM tornei WHERE ID = ".$_GET["tid"]);
$sq = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM torn_sq WHERE tornID = ".$_GET["tid"]))["cc"];
 
$torn = mysqli_fetch_assoc($torns);
#echo http_build_query($torn, '', '/');
 
?>
<div align="center">
<div class="w3-card-4 w3-padding width60">
    <h2 class="w3-blue w3-card-4 w3-large"><?php echo $torn["nome"]; ?></h2>
    Inizio: <?php echo $torn["startData"]; ?><br />
    <?php if($torn["stato"] == 0) { ?>Fine: <?php echo $torn["endData"]; ?><br /> <?php } ?>
    Squadre iscritte: <?php echo $sq; ?><br />

</div></div>
<?php
 
// Se ci sono, vincitori
if($torn["stato"] == 0) {
    echo "<br/><h2 class=\"w3-center w3-text-blue\">Vincitori</h2>";
    require("workers/tornwin.php");
}
 
// Tabellone e classifica
echo "<h2 class=\"w3-center w3-text-blue\">Tabellone</h2>";
require("workers/tabellone.php");
 
echo "<br/><h2 class=\"w3-center w3-text-blue\">Classifica parziale</h2>";
require("workers/classif.php");
 
// Se ci sono, scontri diretti
if($torn["stato"] == 2 or $torn["stato"] == 0) {
    echo "<br/><h2 class=\"w3-center w3-text-blue\">Scontri diretti</h2>";
    require("workers/directs.php");
}
?>