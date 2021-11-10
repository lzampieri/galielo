<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require('.env.php');

if( !array_key_exists("token", $_GET) || $_GET['token'] !== $env["token"] ) {
    http_response_code(401);
    die();
}

$conn = new mysqli($env["db_server"], $env["db_user"], "", $env["db_name"]);

if ( !$conn ) {
    die("Connection failed: " . mysqli_connect_error());
}

if( array_key_exists("get", $_GET) ) {
    $result = $conn -> query(" SELECT team, COUNT(ID) as points FROM 24h WHERE valid = 1 GROUP BY team ");
    if( $result ) {
        $data = array( "success" => true );
        while( $row = mysqli_fetch_assoc($result) ) {
            $data[ "team" . $row["team"] ] = $row["points"];
        }
        if( !array_key_exists("team0",$data) ) $data["team0"] = 0;
        if( !array_key_exists("team1",$data) ) $data["team1"] = 0;
        echo json_encode( $data );
    } else {
        echo "{\"success\": false, \"error\": \"" . $conn -> error . "\"}";
    }
    exit();
}

if( array_key_exists("details", $_GET) ) {
    $result = $conn -> query(" SELECT * FROM 24h WHERE valid = 1");
    if( $result ) {
        $data = array();
        while( $row = $result->fetch_assoc() ) {
            $data[] = $row;
        };
        echo json_encode( array( "success" => true, "data" => $data ) );
    } else {
        echo "{\"success\": false, \"error\": \"" . $conn -> error . "\"}";
    }
    exit();
}

if( array_key_exists("add", $_GET) ) {
    $result = $conn -> query(" INSERT INTO 24h (team) VALUES (" . $_GET["add"] . ")" );
    if( $result ) {
        echo "{\"success\": true}";
    } else {
        echo "{\"success\": false, \"error\": \"" . $conn -> error . "\"}";
    }
    exit();
}

if( array_key_exists("reset", $_GET) ) {
    $result = $conn -> query(" UPDATE 24h SET valid = 0 ");
    if( $result ) {
        echo "{\"success\": true}";
    } else {
        echo "{\"success\": false, \"error\": \"" . $conn -> error . "\"}";
    }
    exit();
}

echo "{\"success\": false, \"error\": \"Query not recognized\"}";