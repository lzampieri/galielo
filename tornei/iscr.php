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
<div align="center">
<?php
require("header.php");

$torns = query("SELECT * FROM tornei WHERE iscr = 1 ORDER BY ID DESC");

if(array_key_exists("err",$_GET)) {
?>
<div class="w3-card w3-red w3-margin-top width40">Errore di inserimento</div>
<?php	
}

if(mysqli_num_rows($torns) == 0) {
	?>
    Nessun torneo con iscrizioni aperte al momento.
    <?php
    } else {
		while($torn = mysqli_fetch_assoc($torns) ) {
			?>
            <form class="w3-card-4 width60" method="post" action="no_graph/iscr.php">
                <h2 class="w3-text-blue">Torneo <?php echo $torn["nome"]; ?></h2>
                
                <div class="w3-row w3-section">
                  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
                    <div class="w3-rest">
                      <input class="w3-input w3-border" name="att" type="text" placeholder="Attaccante">
                    </div>
                </div>
                
                <div class="w3-row w3-section">
                  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
                    <div class="w3-rest">
                      <input class="w3-input w3-border" name="dif" type="text" placeholder="Difensore">
                    </div>
                </div>
                
                <input type="hidden" name="tid" value="<?php echo $torn["ID"]; ?>"  />
                
                <div class="w3-center">
                <div class="w3-bar">
                <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding" >Invia iscrizione</button>
                </div>
                </div>
            </form>
	    <?php
		}
}
?>
<br /><br />
</div>
</body>
</html>