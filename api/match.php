<?php
/*
1) player.php           List of all matches
                        A json object with ID, Timestamp, Att1, Att2, Dif1, Dif2, VarA1, VarA2, VarD1, VarD2, Pt1, Pt2,
                        reverse ordered by Timestamp (most recent first)
2) player.php|POST["add","att1":idAtt1,"att2":idAtt2,"dif1":idDif1,"dif2":idDif2,"pt1":10,"pt2":pt2]
                        Add a match
                        Return the match item with the same properties as above, plus a "success":true item
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

if( array_key_exists("add", $_POST)) {

    // Extract data from post
    try {
        $att1 = $_POST["att1"];
        $att2 = $_POST["att2"];
        $dif1 = $_POST["dif1"];
        $dif2 = $_POST["dif2"];
        $pt1 = $_POST["pt1"];
        $pt2 = $_POST["pt2"];
    } catch (Exception $e) {
        echo json_encode(array("success" => false, "error_message" => e->getMessage()));
        exit;
    }

    // Check for correctness
    if ( pt1 != 10 ) {
        echo json_encode(array("success" => false, "error_message" => "Point player one must be 10"));
        exit;
    }

    // Get users
    try {
        $prof_att1 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $att1") );
        $prof_dif1 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $dif1") );
        $prof_att2 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $att2") );
        $prof_dif2 = mysqli_fetch_assoc( query("SELECT * FROM giocatori WHERE id = $dif2") );

        assert( $prof_att1 && $prof_att2 && $prof_dif1 && $prof_dif2)
    }
} else {
    // Get matches details
    $query_matches = query("SELECT * FROM partite");
    echo json_encode(array_from_query($query_matches),JSON_NUMERIC_CHECK);
}
?>
