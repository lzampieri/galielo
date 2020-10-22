<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />



<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
require_once("script/utilities.php");
?>

</head>

<body class="w3-light-grey">
<?php
require("header.php");
?>

<div align="center">
<div class="width60 w3-right-align">
<a href="newmatch.php"><button class="w3-button w3-blue">Aggiungi »</button></a><br /><br />
</div>
</div>

<?php
require("matchlist.php");
?>

<br /><br />
</body>
</html>