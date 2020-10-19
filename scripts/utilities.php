<?php
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
?>