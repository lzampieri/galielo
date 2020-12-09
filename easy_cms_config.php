<?php
// An example config file, which must be saved as ../easy_cms_config.php
// Hashed (sha256) password to access control panel
$access_password = "15e559ae3df4f3d8cce60e4324880aa84a0325969686a2b42325f722acdbbb9a";
// Database connection parameters
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "my_galielo";
// Editable fields. An associative array, in which each key is the name of a table.
// Each element is itself an associative array, in which each key is the name of an
// editable field and its value is the shown name, plus the '__name' field with the
// shown name of the table and the '__unique' field with the name of the unique field
// in the table. An * at the end of the shown name signal visible-but-non-editable fields.
// As a choice of the author, no removing of rows is available
$tables = array(
    "giocatori" => array(
        "__name" => "Lista giocatori",
        "__unique" => "ID",
        "Nome" => "Nome",
        "PuntiA" => "PuntiA*",
        "PuntiD" => "PuntiD*"
    ),
    "ccup" => array(
        "__name" => "Coppe dei Campioni",
        "__unique" => "ID",
        "Hidden" => "Nascosto?"
    )
);
?>