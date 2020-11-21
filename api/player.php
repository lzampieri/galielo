<?php
/*
1) player.php?id=$id    Details of the single player
                        A json object with ID, Name, PuntiA, PuntiD, matches
                        where matches is an array, in which each object represent a match,
                        with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2,
                        reverse ordered by Timestamp (most recent first)
2) player.php           List of all players
                        A json object with ID, Nome, PuntiA, PuntiD, CountRecent, CountAll
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

// (1)
if( array_key_exists("id", $_GET)) {
    $id = $_GET["id"];
    // Get player details
    $query_details = query("SELECT * FROM giocatori WHERE id = $id");
    if( mysqli_num_rows($query_details) != 1 ) exit();
    $player_details = mysqli_fetch_assoc($query_details);

    // Get player matches
    $query_matches = query("SELECT * FROM partite WHERE Att1 = $id OR Att2 = $id OR Dif1 = $id OR Dif2 = $id ORDER BY Timestamp DESC");
    $player_details["matches"] = array_from_query($query_matches);
    echo json_encode($player_details,JSON_NUMERIC_CHECK);
} else {
    // Get players details
    $query_players = query("SELECT ID, Nome, PuntiA, PuntiD, COALESCE(CountRecent,0) AS CountRecent, COALESCE(CountAll,0) AS CountAll FROM giocatori LEFT JOIN (SELECT Att1, Count(*) AS CountRecent FROM (SELECT Att1, Timestamp FROM partite UNION ALL SELECT Att2, Timestamp FROM partite UNION ALL SELECT Dif1, Timestamp FROM partite UNION ALL SELECT Dif2, Timestamp FROM partite) AS t WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<100 GROUP BY Att1) AS recent ON giocatori.ID = recent.Att1 LEFT JOIN (SELECT Att1, Count(*) AS CountAll FROM (SELECT Att1, Timestamp FROM partite UNION ALL SELECT Att2, Timestamp FROM partite UNION ALL SELECT Dif1, Timestamp FROM partite UNION ALL SELECT Dif2, Timestamp FROM partite) AS t GROUP BY Att1) AS allmatches ON giocatori.ID = allmatches.Att1 ORDER BY ID");
    echo json_encode(array_from_query($query_players),JSON_NUMERIC_CHECK);
}
?>