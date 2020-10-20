<?php

require_once("../scripts/database.php");
require_once("../scripts/utilities.php");


$query = "SELECT partite.*, GA1.Nome AS NomeAtt1, GA2.Nome AS NomeAtt2, GD1.Nome AS NomeDif1, GD2.Nome AS NomeDif2  FROM partite JOIN giocatori AS GA1 ON partite.Att1 = GA1.ID JOIN giocatori AS GA2 on partite.Att2 = GA2.ID JOIN giocatori AS GD1 ON partite.Dif1 = GD1.ID JOIN giocatori AS GD2 ON partite.Dif2 = GD2.ID";

$result = query($query);

$array = array_from_query($result);

echo json_encode($array, JSON_NUMERIC_CHECK);

?>