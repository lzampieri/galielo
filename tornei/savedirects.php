<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="w3-light-grey">


<?php
require("header.php");
?>

<div align="center">

    <div class="w3-card-4 w3-padding width70 w3-margin-bottom">
    <form method="post" action="no_graph/savedirects.php">
    	<label><?php echo $_POST["nome1"]; ?></label> <br />
        <input type="number" name="pti1"  /><br /><br />
    	<label><?php echo $_POST["nome2"]; ?></label><br />
        <input type="number" name="pti2"  /><br /><br />
        <input type="hidden" value="<?php echo $_POST["id1"]; ?>" name="sq1"  />
        <input type="hidden" value="<?php echo $_POST["id2"]; ?>" name="sq2"  />
        <input type="hidden" value="<?php echo $_POST["tid"]; ?>" name="tid" />
        <input type="hidden" value="<?php echo $_POST["match"]; ?>" name="match" />
        <input type="submit" class="w3-button w3-blue" value="Salva" />
    </form>
    </div>

</div>
</body>
</html>