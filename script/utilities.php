<?php
$db_handle = NULL;

function dbconnect() {
	if($GLOBALS['db_handle'] != NULL) return $GLOBALS['db_handle'];
    $server = "localhost";
    $username = "galielo";
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

function swap(&$x,&$y) {
    $tmp=$x;
    $x=$y;
    $y=$tmp;
}
?>