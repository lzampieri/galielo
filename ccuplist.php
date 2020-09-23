<?php
require_once("script/utilities.php");
$list = query("SELECT c.ID AS ID, c.Att AS AttID, a.Nome AS AttName, c.Dif AS DifID, d.Nome AS DifName, c.Match1 as p1ID, p1.Timestamp AS Match1Time, p1.Pt2 AS Match1Points, p2.Timestamp AS Match2Time, p2.Pt2 AS Match2Points FROM ccup AS c LEFT JOIN giocatori AS a ON a.ID = c.Att LEFT JOIN giocatori AS d ON d.ID = c.Dif LEFT JOIN partite AS p1 ON p1.ID = c.Match1 LEFT JOIN partite AS p2 ON p2.ID = c.Match2 WHERE c.Hidden = 0 ORDER BY ID DESC");
$winners = mysqli_fetch_assoc($list);
?>

<div align="center">


	<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin width60">
        <h2 class="w3-center">Campioni in carica</h2>
        <table>
        <tr>
        <td>
        <i class="w3-xxxlarge fa fa-trophy"></i>
        </td>
        <td>
        <h2 align="center"><?php echo $winners["AttName"]."<br/>".$winners["DifName"]; ?></h2>
        </td>
        </tr>
        </table>
        <?php if($winners["p1ID"] > 0) { ?>    
        Vincitori del titolo con le partite:
		<ul>
        <li><?php echo $winners["Match1Time"]." vinta 10-".$winners["Match1Points"]; ?></li>
        <li><?php echo $winners["Match2Time"]." vinta 10-".$winners["Match2Points"]; ?></li>
        </ul>
        <?php } else echo "Assegnata da Krökel"; ?>
        <?php
		if(isset($admincose)) {
			echo "<td><a href=\"?tohide=".$winners["ID"]."\" onclick=\"return confirm('Sei sicuro di voler eliminare questo evento? L\'eliminazione è irreversibile');\">Elimina</a></td>";
		}
		?>
    </div>
    
    <br/><br />
    <table class="w3-card-4 w3-table-all width60">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Detentori precedenti</th>
        <th>Partite per la vittoria del titolo</th>
    </tr>
    </thead>
    <?php
	while( ($row = mysqli_fetch_assoc($list)) != NULL ) {
		?>
        <tr>
        <td><?php echo $row["AttName"]."<br/>".$row["DifName"]; ?></td>
        <td><?php 
		if($row["p1ID"] > 0)
		echo $row["Match1Time"]." vinta 10-".$row["Match1Points"]."<br/>".$row["Match2Time"]." vinta 10-".$row["Match2Points"];
		else echo "Assegnata da Krökel"; ?></td>
        <?php
		if(isset($admincose)) {
			echo "<td><a href=\"?tohide=".$row["ID"]."\" onclick=\"return confirm('Sei sicuro di voler eliminare questo evento? L\'eliminazione è irreversibile');\">Elimina</a></td>";
		}
		?>
        </tr>
        <?php
	}
	?></table>
</div>


