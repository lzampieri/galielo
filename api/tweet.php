<?php
/*
1) tweet.php            List of first 50 visible tweet
                        A json object with ID, Timestamp, Author, Text, Image, Visible
                        Order by ID DESC
2) tweet.php?below=$id  List of first 50 visible tweet with ID below $id, excluded
                        A json object with ID, Timestamp, Author, Text, Image, Visible
                        Order by ID DESC
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

{
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
