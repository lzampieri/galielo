<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />



<?php
require_once("../script/utilities.php");
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="w3-light-grey">

<?php
require("header.php");
$sq1 = $_GET["sq1"];
$sq2 = $_GET["sq2"];
$tornID = $_GET["torn"];
$nome = array();
$torns = query("SELECT * FROM torn_sq WHERE ID IN (".$sq1.", ".$sq2.")");

$t = mysqli_fetch_assoc($torns);
$nome[$t["ID"]] = $t["att"].", ".$t["dif"];
$t = mysqli_fetch_assoc($torns);
$nome[$t["ID"]] = $t["att"].", ".$t["dif"];
?>
<div align="center">

    <div class="w3-card-4 w3-padding width70 w3-margin-bottom">
    <form method="post" action="no_graph/save_tabell.php">
    	<label><?php echo $nome[$sq1]; ?></label> <br />
        <input type="number" name="<?php echo "pti".$sq1; ?>"  /><br /><br />
    	<label><?php echo $nome[$sq2]; ?></label><br />
        <input type="number" name="<?php echo "pti".$sq2; ?>"  /><br /><br />
        <input type="hidden" value="<?php echo $sq1; ?>" name="sq1"  />
        <input type="hidden" value="<?php echo $sq2; ?>" name="sq2"  />
        <input type="hidden" value="<?php echo $tornID; ?>" name="tid" />
        <input type="submit" class="w3-button w3-blue" value="Salva" />
    </form>
    </div>

</div>
</body>
</html>