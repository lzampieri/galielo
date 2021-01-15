<?php
/*
1) player.php|POST["add","name":name]
                        Add a player
                        Return the player item with the name, the ID and the points
2) player.php?id=$id    Details of the single player
                        A json object with ID, Name, PuntiA, PuntiD, matches
                        where matches is an array, in which each object represent a match,
                        with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2,
                        reverse ordered by Timestamp (most recent first)
3) player.php           List of all players
                        A json object with ID, Nome, PuntiA, PuntiD, CountRecentA, CountRecentD, CountA, CountD

e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

if( array_key_exists("add", $_POST) ) {
    $points = get_game_param("starting_points");
    if ( ! array_key_exists("name", $_POST) ) exit;
    $name = php_to_db_escape( $_POST['name'] );
    query("INSERT INTO giocatori(Nome,PuntiA,PuntiD) VALUES( \"$name\", $points, $points )");
    $id = get_last_id();
    log_to_database("New player $name with ID $id and points $points, $points");
    $player = [ "ID" => $id, "Nome" => $name, "PuntiA" => $points, "PuntiD" => $points];
    echo json_encode($player,JSON_NUMERIC_CHECK);
} else if( array_key_exists("id", $_GET)) {
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
    $query_players = query("SELECT ID, Nome, PuntiA, PuntiD, COALESCE(CountRecentA,0) AS CountRecentA, COALESCE(CountRecentD,0) AS CountRecentD, COALESCE(CountA,0) AS CountA, COALESCE(CountD,0) AS CountD FROM giocatori LEFT JOIN (SELECT Att1, Count(*) AS CountRecentA FROM (SELECT Att1, Timestamp FROM partite UNION ALL SELECT Att2, Timestamp FROM partite) AS t WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<30 GROUP BY Att1) AS recentA ON giocatori.ID = recentA.Att1 LEFT JOIN (SELECT Dif1, Count(*) AS CountRecentD FROM (SELECT Dif1, Timestamp FROM partite UNION ALL SELECT Dif2, Timestamp FROM partite) AS t WHERE TIMESTAMPDIFF(DAY,Timestamp,CURRENT_TIMESTAMP)<30 GROUP BY Dif1) AS recentD ON giocatori.ID = recentD.Dif1 LEFT JOIN (SELECT Att1, Count(*) AS CountA FROM (SELECT Att1, Timestamp FROM partite UNION ALL SELECT Att2, Timestamp FROM partite) AS t GROUP BY Att1) AS allmatchesA ON giocatori.ID = allmatchesA.Att1 LEFT JOIN (SELECT Dif1, Count(*) AS CountD FROM (SELECT Dif1, Timestamp FROM partite UNION ALL SELECT Dif2, Timestamp FROM partite) AS t GROUP BY Dif1) AS allmatchesD ON giocatori.ID = allmatchesD.Dif1 ORDER BY ID");
    echo json_encode(array_from_query($query_players),JSON_NUMERIC_CHECK);
}
?>