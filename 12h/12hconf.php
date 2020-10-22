<?php
if( !isset($_GET["sq"]) or !isset($_GET["tid"])) {
	header("location: 12h.php");
	exit();
}
else {
	$sq = $_GET["sq"];
	$tid = $_GET["tid"];
}
?>
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

<?php
require("../header.php");
?>

<br /><br />
<div align="center">
<div class="width70" align="center">
    1 gol per la squadra <?php if($sq==0) echo "blu"; else echo "rossa"; ?><br/>
    <a href="12hadd.php?sq=<?php echo $sq; ?>&tid=<?php echo $tid; ?>" class="w3-button w3-blue">Conferma</a>
</div>
</div>

</body>
</html>