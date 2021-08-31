<?php
$db_handle = NULL;
$params = [];

function dbconnect() {
	if($GLOBALS['db_handle'] != NULL) return $GLOBALS['db_handle'];
    $server = "localhost";
    if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') $username = "root";
    else $username = "galielo";
    $password = "";
    $database = "my_galielo";
 
    $GLOBALS['db_handle'] = mysqli_connect($server, $username, $password);
	echo mysqli_error($GLOBALS['db_handle']);
    mysqli_select_db($GLOBALS['db_handle'], $database);
	echo mysqli_error($GLOBALS['db_handle']);
	return $GLOBALS['db_handle'];
}

function query($sql) {
    if($GLOBALS['db_handle'] == NULL) dbconnect();
    $result = mysqli_query($GLOBALS['db_handle'],$sql);
    if( !$result ) {
        $error = mysqli_error($GLOBALS['db_handle']);
        log_to_database("Query error!");
        log_to_database($sql);
        log_to_database($error);
    }
    return $result;
}

function affected_rows() {
    if($GLOBALS['db_handle'] == NULL) return 0;
    else return mysqli_affected_rows($GLOBALS['db_handle']);
}

function log_to_database($message) {
    if($GLOBALS['db_handle'] == NULL) dbconnect();
    $escaped_message = mysqli_real_escape_string($GLOBALS['db_handle'],$message);
    $ip = $_SERVER['REMOTE_ADDR'];
    mysqli_query($GLOBALS['db_handle'],"INSERT INTO log(IP,Query) VALUES (\"" .$ip. "\", \"" .$escaped_message. "\")");
}

function php_to_db_escape($string) {
    if($GLOBALS['db_handle'] == NULL) dbconnect();
	return mysqli_real_escape_string($GLOBALS['db_handle'],$string);
}

function get_game_param($name) {
    if( count($GLOBALS['params']) == 0 ) {
        $result = query("SELECT * FROM elo_params");
        while( $row = mysqli_fetch_assoc($result) ) {
            $GLOBALS['params'][ $row['Name'] ] = $row['Value'];
        }
    }
    return $GLOBALS['params'][$name];
}

function swap(&$x,&$y) {
    $tmp=$x;
    $x=$y;
    $y=$tmp;
}

function array_from_query($query_results) {
    $emparray = array();
    while($row =mysqli_fetch_assoc($query_results))
    {
        $emparray[] = $row;
    }
    return $emparray;
}

function check_if_admin() {
    session_start();
    if(isset($_SESSION["code"])) {
        $userkey = trim(file_get_contents("/membri/galielo/conf/userkey.txt"));
        if($_SESSION["code"] == $userkey) {
            return true;
        }
    }
    return false;
}

function get_last_id() {
    return $GLOBALS['db_handle']->insert_id;
}

if(!$db_handle) {
    dbconnect();
}
?>