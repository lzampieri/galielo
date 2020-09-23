<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />


<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php
require_once("../script/utilities.php");
?>

</head>

<body class="w3-light-grey">
<br /><br />
<div align="center">

<?php
require("../header.php");


$torns = query("SELECT t.ID AS ID, t.closeTime AS closeTime, t.stato AS stato, t.sq0 AS sq0, t.sq1 AS sq1, p0.pt AS pt0, p1.pt AS pt1 FROM t12h AS t LEFT JOIN ( SELECT COUNT(ID) AS pt, torneo AS tid0 FROM p12h WHERE sq = 0 GROUP BY torneo ) AS p0 ON t.ID = p0.tid0 LEFT JOIN ( SELECT COUNT(ID) AS pt, torneo AS tid1 FROM p12h WHERE sq = 1 GROUP BY torneo ) AS p1 ON t.ID = p1.tid1 WHERE stato = 1");

if(mysqli_num_rows($torns)==0) echo "Nessuna 12h in corso al momento.<br/>";
while( $torn = mysqli_fetch_assoc($torns) ) {
?>

<div class="width70" align="center">
    <div class="w3-card-4 w3-padding width40 float w3-margin-bottom">
    <p class="w3-blue w3-card-4 w3-large"><?php echo $torn["sq0"]; ?></p>
    <p class="w3-large"><?php echo ($torn["pt0"]==NULL?"0":$torn["pt0"]); ?></p>
    <a href="12hconf.php?sq=0&tid=<?php echo $torn["ID"]; ?>" class="w3-button w3-blue">Gol!</a>
    </div>
    <div class="width20collapse float">Placeholder</div>
    <div class="w3-card-4 width40 w3-padding float w3-margin-bottom">
    <p class="w3-red w3-card-4 w3-large"><?php echo $torn["sq1"]; ?></p>
    <p class="w3-large"><?php echo ($torn["pt1"]==NULL?"0":$torn["pt1"]); ?></p>
    <a href="12hconf.php?sq=1&tid=<?php echo $torn["ID"]; ?>" class="w3-button w3-red">Gol!</a>
    </div>
</div>
<?php } ?>
<br/>
<?php require("workers/list.php"); ?>
<br/><br/>
</div>
</body>
</html>