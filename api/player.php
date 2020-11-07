<?php
/*
1) player.php?id=$id    Details of the single player
                        A json object with ID, Name, PuntiA, PuntiD, matches
                        where matches is an array, in which each object represent a match,
                        with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2
2) player.php           List of all players
                        A json object with ID, Name, PuntiA, PuntiD
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
    $query_matches = query("SELECT * FROM partite WHERE Att1 = $id OR Att2 = $id OR Dif1 = $id OR Dif2 = $id");
    $player_details["matches"] = array_from_query($query_matches);
    echo json_encode($player_details,JSON_NUMERIC_CHECK);
} else {
    // Get players details
    $query_players = query("SELECT * FROM giocatori");
    echo json_encode(array_from_query($query_players),JSON_NUMERIC_CHECK);
}
?>