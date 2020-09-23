<?php
	$final = mysqli_fetch_assoc(query("SELECT * FROM torn_direct WHERE tornID = ".$torn["ID"]));
	$winners = mysqli_fetch_assoc(query("SELECT * FROM torn_sq WHERE ID = ".$final["winfin"]));	
?>
<div align="center">
	<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin width60">
        <table>
        <tr>
        <td>
        <i class="w3-xxxlarge fa fa-trophy"></i>
        </td>
        <td>
        <h2 align="center"><?php echo $winners["att"]."<br/>".$winners["dif"]; ?></h2>
        </td>
        </tr>
        </table>
        Vincitori del torneo <?php echo $torn["nome"]; ?> conclusosi in data <?php echo $torn["endData"]; ?>
    </div>
</div>