<?php if( !array_key_exists("old",$_GET) ) {
    header("location: /elo/");
    abort();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />



<?php
require_once("script/utilities.php");
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="w3-light-grey">

<?php
require("header.php");
require("allerrors.php");
require("message.php");
require("classif.php");
?>
<br /><br />
</body>
</html>