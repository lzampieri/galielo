<?php
/*
1) ccup.php             List of all cups
                        A json object with ID, Att, Dif, Hidden, TimeP1, PtP1, TimeP2, PtP2
                        Ordered by ID DESC
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

// Get ccup details
$query_ccup = query("SELECT ccup.ID, ccup.Att, ccup.Dif, partita1.Timestamp as TimeP1, partita1.Pt2 as PtP1, partita2.Timestamp as TimeP2, partita2.Pt2 as PtP2, ccup.Hidden FROM ccup LEFT JOIN partite AS partita1 ON ccup.Match1 = partita1.ID LEFT JOIN partite AS partita2 ON ccup.Match2 = partita2.ID ORDER BY ID DESC");
echo json_encode(array_from_query($query_ccup),JSON_NUMERIC_CHECK);

?>
