<?php
$db_handle = NULL;

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
	return mysqli_query($GLOBALS['db_handle'],$sql);
}

function php_to_db_escape($string) {
    if($GLOBALS['db_handle'] == NULL) dbconnect();
	return mysqli_real_escape_string($GLOBALS['db_handle'],$string);
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

if(!$db_handle) {
    dbconnect();
}
?>