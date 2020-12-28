<?php
/*
1) tweet.php            List of first 50 visible tweet
                        A json object with ID, Timestamp, Author, Text, Image, Visible
                        Order by ID DESC
2) tweet.php?below=$id  List of first 50 visible tweet with ID below $id, excluded
                        A json object with ID, Timestamp, Author, Text, Image, Visible
                        Order by ID DESC
3) tweet.php|POST["hide","id"=$id,"uuid"=$uuid]
                        Hide the tweet $id, only if its huid coincide with the hashing of uuid.
                        Return a json object with ID and success=true|false
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

if( array_key_exists('hide',$_POST) ) {
    if( !array_key_exists('id',$_POST) || !array_key_exists('uuid',$_POST) ) {
        echo json_encode(array("success" => false));
        exit;
    }
    query("UPDATE galitweet SET Visible = 0 WHERE ID = ".$_POST["id"]." AND HUID = \"".hash('sha256',$_POST["uuid"])."\"");
    if( affected_rows() > 0 ) {
        echo json_encode(array("success" => true, "id" => $_POST["id"]));
        exit;
    } else {
        echo json_encode(array("success" => false, "id" => $_POST["id"]));
        exit;
    }
} else {
    // Check if below
    if( array_key_exists('below',$_GET) )
        $query = "SELECT * FROM galitweet WHERE Visible = 1 AND ID < ".$_GET['below']." ORDER BY ID DESC LIMIT 50";
    else
        $query = "SELECT * FROM galitweet WHERE Visible = 1 ORDER BY ID DESC LIMIT 50";
    // Get tweets details
    $tweets = query($query);
    echo json_encode(array_from_query($tweets),JSON_NUMERIC_CHECK);
}
?>
