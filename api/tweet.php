<?php
/*
1) tweet.php            List of first 50 visible tweet
                        A json object with ID, Timestamp, Author, Text, Image, Visible
                        Order by ID DESC
2) tweet.php?below=$id  List of first 50 visible tweet with ID below $id, excluded
                        A json object with ID, Timestamp, Author, Text, Image, HUID, Visible
                        Order by ID DESC
3) tweet.php|POST["hide","id"=$id,"uuid"=$uuid]
                        Hide the tweet $id, only if its huid coincide with the hashing of uuid.
                        Return a json object with ID and success=true|false
4) tweet.php|POST["add","author"=$author,"text"=$text,"image"=$image_filename,"huid"=$huid]
                        Add a tweet. Image parameter is facultative.
                        If success, return a json object with ID, Timestamp, Author, Text,
                        Image, HUID, Visible plus a success=true
                        Else return a json object with success=false
e) If error return nothing
*/

// Connecting to database
require_once("utilities.php");

if( array_key_exists('add',$_POST) ) {
    // Get params
    if( !array_key_exists('author',$_POST) || !array_key_exists('text',$_POST) || !array_key_exists('huid',$_POST) ) {
        echo json_encode(array("success" => false));
        exit;
    }
    $author = php_to_db_escape($_POST["author"]);
    $text = php_to_db_escape($_POST["text"]);
    if( array_key_exists('image',$_POST))
        $image = "\"" . $_POST["image"] . "\"";
    else $image = "NULL";
    $huid = $_POST["huid"];
    // Save tweet
    log_to_database("New tweet (Author, Text, Image, HUID) = ($author, $text, $image, $huid)");
    query("INSERT INTO galitweet (Author, Text, Image, HUID) VALUES (\"$author\", \"$text\", $image, \"$huid\")");
    // Get saved match
    $tweetid = get_last_id();
    $output = mysqli_fetch_assoc( query( "SELECT * FROM galitweet WHERE ID = ". $tweetid ) );
    $output["success"] = true;
    echo json_encode( $output, JSON_NUMERIC_CHECK);
} else if( array_key_exists('hide',$_POST) ) {
    if( !array_key_exists('id',$_POST) || !array_key_exists('uuid',$_POST) ) {
        echo json_encode(array("success" => false));
        exit;
    }
    query("UPDATE galitweet SET Visible = 0 WHERE ID = ".$_POST["id"]." AND HUID = \"".hash('sha256',$_POST["uuid"])."\"");
    log_to_database("Hidden tweet ". $_POST["id"]);
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
        $query = "SELECT * FROM galitweet WHERE Visible = 1 AND ID < ". $_GET['below'] ." ORDER BY ID DESC LIMIT 50";
    else
        $query = "SELECT * FROM galitweet WHERE Visible = 1 ORDER BY ID DESC LIMIT 50";
    // Get tweets details
    $tweets = query($query);
    echo json_encode(array_from_query($tweets),JSON_NUMERIC_CHECK);
}
?>
