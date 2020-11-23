<?php
/*
1) player.php           List of all matches
                        A json object with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2,
                        reverse ordered by Timestamp (most recent first)
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

// Get matches details
$query_matches = query("SELECT * FROM partite");
echo json_encode(array_from_query($query_matches),JSON_NUMERIC_CHECK);

?>
