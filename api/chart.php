<?php

require_once("../scripts/database.php");
require_once("../scripts/utilities.php");


$query = "SELECT giocatori.ID as ID, giocatori.Nome AS Nome, giocatori.PuntiA as PuntiA, giocatori.PuntiD as PuntiD, ContAtt.Cont AS PartiteAttacco, ContDif.Cont AS PartiteDifesa, ContMeseAtt.Cont AS PartiteMeseAttacco, ContMeseDif.Cont AS PartiteMeseDifesa FROM giocatori LEFT JOIN ( SELECT Att, COUNT(Att) AS Cont FROM ( SELECT Att1 AS Att FROM partite UNION ALL SELECT Att2 AS Att FROM partite) AS partiteAttacco GROUP BY Att ) AS ContAtt ON giocatori.ID = ContAtt.Att LEFT JOIN ( SELECT Dif, COUNT(Dif) AS Cont FROM ( SELECT Dif1 AS Dif FROM partite UNION ALL SELECT Dif2 AS Dif FROM partite) AS partiteDifesa GROUP BY Dif ) AS ContDif ON giocatori.ID = ContDif.Dif LEFT JOIN ( SELECT Att, COUNT(Att) AS Cont FROM ( SELECT Att1 AS Att FROM partite WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 UNION ALL SELECT Att2 AS Att FROM partite WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31) AS partiteMeseAttacco GROUP BY Att ) AS ContMeseAtt ON giocatori.ID = ContMeseAtt.Att LEFT JOIN ( SELECT Dif, COUNT(Dif) AS Cont FROM ( SELECT Dif1 AS Dif FROM partite WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 UNION ALL SELECT Dif2 AS Dif FROM partite WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31) AS partiteMeseDifesa GROUP BY Dif ) AS ContMeseDif ON giocatori.ID = ContMeseDif.Dif";

$result = query($query);

$array = array_from_query($result);

echo json_encode($array, JSON_NUMERIC_CHECK);

?>