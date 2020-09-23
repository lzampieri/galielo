<?php
session_start();
if(isset($_GET["logout"])) {
	$_SESSION["code"] = "";
	session_destroy();
}
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		header("location: admin.php");
		abort();
	}
}
if(isset($_POST["pass"])) {
	$hashed_real = trim(file_get_contents("../conf/privatepassword.txt"));
	if(hash('sha256', $_POST["pass"]) == $hashed_real) {
		$userkey = trim(file_get_contents("../conf/userkey.txt"));
		$_SESSION["code"] = $userkey;
		header("location: admin.php");
		abort();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Amministrazione - GaliElo</title>

<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<body class="w3-light-grey">

<?php
require("../header.php");
?>

<div align="center">
<form action="login.php" method="post" class="w3-card-4 width40 w3-padding">
<div class="w3-jumbo fa fa-user-secret"></div><br /><br />
<label for="pass"><b>Password:</b></label><br />
<input type="password" name="pass" /><br /><br />
<button type="submit" class="w3-btn w3-blue"><i class="w3-xl fa fa-key"></i></button>
</form><br/><br/>
<a href="../" class="w3-btn w3-blue">« Home page</a>
</div>

</body>
</html>

