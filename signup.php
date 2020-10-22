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
$basepoints = trim(file_get_contents('conf/puntibase.txt'));
?>

<div align="center">
	<form action="newplayer.php" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin width60" method="post">
        <h2 class="w3-center">Iscriviti qui</h2>
    
    <?php  if(isset($_GET["iserr"])) { ?>
        <div class="w3-card w3-red w3-margin-top width40">Compila correttamente tutti i campi.</div><br/>
    <?php
    } else if(isset($_GET["giserr"])) { ?>
        <div class="w3-card w3-red w3-margin-top width40">Risulti già iscritto.</div><br/>
    <?php
    }
    ?>
        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
              <input class="w3-input w3-border" name="name" type="text" placeholder="Nome e Cognome">
            </div>
        </div>

		<div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-trophy"></i></div>
            <div class="w3-rest">
              <input class="w3-input w3-border" name="ptibase" type="text" value="Punti: <?php echo $basepoints;?>" disabled />
            </div>
        </div>
        
        <div class="w3-center">
        <div class="w3-bar">
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding" >Invia iscrizione</button>
        </div>
        </div>
    
    </form>
</div>
<br /><br />
</body>
</html>