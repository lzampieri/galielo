<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"  />

<?php
require_once("script/utilities.php");
?>

<?php
$query_best_attacco = "SELECT Nome FROM giocatori RIGHT JOIN ( SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Att1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Att2, Timestamp AS Gioc FROM partite) AS t1 WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 GROUP BY Gioc ) AS conteggi ON giocatori.ID = conteggi.Gioc WHERE conteggi.cc >= 10 ORDER BY PuntiA DESC LIMIT 1";
$query_best_difesa = "SELECT Nome FROM giocatori RIGHT JOIN ( SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Dif1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Dif2, Timestamp AS Gioc FROM partite) AS t1 WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 GROUP BY Gioc ) AS conteggi ON giocatori.ID = conteggi.Gioc WHERE conteggi.cc >= 10 ORDER BY PuntiD DESC LIMIT 1";
$query_best_total = "SELECT Nome FROM (SELECT Nome, PuntiA+PuntiD AS PuntiSomma FROM giocatori RIGHT JOIN ( SELECT Gioc, COUNT(ID) AS cc FROM (SELECT ID, Dif1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Dif2, Timestamp AS Gioc FROM partite UNION SELECT ID, Att1 AS Gioc, Timestamp FROM partite UNION SELECT ID, Att2, Timestamp AS Gioc FROM partite) AS t1 WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<31 GROUP BY Gioc ) AS conteggi ON giocatori.ID = conteggi.Gioc WHERE conteggi.cc >= 10 ORDER BY PuntiSomma DESC LIMIT 1 ) AS temp";
$query_coppa_campioni = "SELECT c.ID AS ID, c.Att AS AttID, a.Nome AS AttName, c.Dif AS DifID, d.Nome AS DifName, c.Match1 as p1ID, p1.Timestamp AS Match1Time, p1.Pt2 AS Match1Points, p2.Timestamp AS Match2Time, p2.Pt2 AS Match2Points FROM ccup AS c LEFT JOIN giocatori AS a ON a.ID = c.Att LEFT JOIN giocatori AS d ON d.ID = c.Dif LEFT JOIN partite AS p1 ON p1.ID = c.Match1 LEFT JOIN partite AS p2 ON p2.ID = c.Match2 WHERE c.Hidden = 0 ORDER BY ID DESC LIMIT 1";
$query_last_match = "SELECT p.*, a1.Nome as a1Name, a2.Nome as a2Name, d1.Nome as d1Name, d2.Nome as d2Name FROM partite AS p JOIN giocatori AS a1 ON a1.ID = Att1 JOIN giocatori AS a2 ON a2.ID = Att2 JOIN giocatori AS d1 ON d1.ID = Dif1 JOIN giocatori AS d2 ON d2.ID = Dif2 ORDER BY Timestamp DESC LIMIT 1";

$best_attacco = mysqli_fetch_assoc( query($query_best_attacco) )["Nome"];
$best_difesa = mysqli_fetch_assoc( query($query_best_difesa) )["Nome"];
$best_total = mysqli_fetch_assoc( query($query_best_total) )["Nome"];
$campioni = mysqli_fetch_assoc( query($query_coppa_campioni) );
$last_match = mysqli_fetch_assoc( query($query_last_match) );
?>

<script>
if (screen.width <= 576) {
    document.location = "monitor_mobile.php";
}
</script>

<style>
body{
    position: absolute;
    top: 0px;
    bottom: 0px;
    width: 100%;
    text-align: center;
}

.athird{
    height: 30%;
    margin: 1.5% !important;
    width: 97%;
    padding: 0.1%;
}

.anhalf{
    height: 47%;
    margin: 1.5% !important;
    width: 97%;
    padding: 0.1%;
}

h2{
    opacity: 50%;
}
</style>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="w3-light-grey" onload="setTimeout(function() { location.reload(); }, 60000)">

<img src="/img/logoConSub.png" class="w3-padding" style="height: 30%"  />

<table style="height: 70%;width: 100%;">
    <tr style="height: 100%">
        <td style="width: 50%">
        <div class="w3-card w3-blue athird">
            <h2>Miglior Giocatore</h2>
            <h1><?php echo $best_total ?></h1>
        </div>
        <div class="w3-card w3-red athird">
            <h2>Miglior Attaccante</h2>
            <h1><?php echo $best_attacco ?></h1>
        </div>
        <div class="w3-card w3-blue athird">
            <h2>Miglior Difensore</h2>
            <h1><?php echo $best_difesa ?></h1>
        </div>
        </td>
        <td style="width: 50%">
        <div class="w3-card w3-red anhalf">
            <h2><span class="w3-xxlarge fa fa-trophy"/> Coppa dei Campioni <span class="w3-xxlarge fa fa-trophy"/></h2>
            <h1><?php echo $campioni["AttName"] ?></h1>
            <h1><?php echo $campioni["DifName"] ?></h1>
        </div>
        <div class="w3-card w3-blue anhalf" >
            <h2>Ultima Partita Giocata</h2>
            <h3><?php echo $last_match["a1Name"] . " - " . $last_match["d1Name"] ?></h3>
            vincono <?php echo $last_match["Pt1"] . " - " . $last_match["Pt2"] . " in data ". $last_match["Timestamp"] ?> contro
            <h3><?php echo $last_match["a2Name"] . " - " . $last_match["d2Name"]  ?></h3>
        </div>
        </td>
    </tr>
</table>

</body>
</html>