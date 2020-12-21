<table>
<?php
// Simply print all the log
require_once("utilities.php");
$result = query("SELECT * FROM log");
while( $row = mysqli_fetch_array($result) ) {
    echo "<tr><td>" .$row[0]. "</td><td>" .$row[1]. "</td><td>" .$row[2]. "</td><td>" .$row[3]. "</td></tr>";
}
?>
</table>