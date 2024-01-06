<?php
/*
1) backup.php           Create a backup of the database
*/

// Connecting to database
require_once("utilities.php");

$tables = [];

$tables['backup_info'] = [];
$tables['backup_info']['ip'] = $_SERVER['REMOTE_ADDR'];
$tables['backup_info']['date'] = date("c");
$tables['backup_info']['filename'] = "backup_" . str_replace( ':', '-', date("c") ) . ".json";

$tables['giocatori'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM giocatori') );
$tables['partite'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM partite') );

$tables['tornei'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM tornei') );
$tables['torn_direct'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM torn_direct') );
$tables['torn_match'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM torn_match') );
$tables['torn_sq'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM torn_sq') );

$tables['ccup'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM ccup') );

$tables['p12h'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM p12h') );
$tables['t12h'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM t12h') );

$tables['galitweet'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM galitweet') );

$tables['log'] = array_from_query( mysqli_query($db_handle, 'SELECT * FROM log') );

file_put_contents("../backups/" . $tables['backup_info']['filename'], json_encode( $tables ) );

echo "OK";