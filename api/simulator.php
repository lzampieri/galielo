<?php
/*
2) simulator.php|POST["pt_att1":ptAtt1,"pt_att2":ptAtt2,"pt_dif1":ptDif1,"pt_dif2":ptDif2,"pt1":10,"pt2":pt2]
                        Simulate a match
                        Return the match item with the same properties as above,
                        plus a "success":true and the var_att1, var_att2, var_dif1, var_dif2 which shows the simulated variations
                        or a "success":false and a "error_message":"..."
*/

// Extract data from post
if (
    !array_key_exists("pt_att1", $_POST) ||
    !array_key_exists("pt_att2", $_POST) ||
    !array_key_exists("pt_dif1", $_POST) ||
    !array_key_exists("pt_dif2", $_POST) ||
    !array_key_exists("pt1", $_POST) ||
    !array_key_exists("pt2", $_POST)
) {
    echo json_encode(array("success" => false, "error_message" => "Params not given"));
    exit;
}

$eloa1 = $_POST["pt_att1"];
$eloa2 = $_POST["pt_att2"];
$elod1 = $_POST["pt_dif1"];
$elod2 = $_POST["pt_dif2"];
$pt1 = $_POST["pt1"];
$pt2 = $_POST["pt2"];

// Check for correctness
if ($pt1 != 10 || $pt2 >= 10) {
    echo json_encode(array("success" => false, "error_message" => "Points team 1 one must be 10 and team 2 must be less"));
    exit;
}

$fr = 34.0 * exp(-0.14 * $pt2);
$sq1 = pow(((pow($eloa1, 3) + pow($elod1, 3)) / 2.0), 0.33);
$sq2 = pow(((pow($eloa2, 3) + pow($elod2, 3)) / 2.0), 0.33);

$fp = 1.0 - (1.0 / (1.0 + pow(10.0, ($sq2 - $sq1) / 400.0)));

$coef1 = 2.0 * $elod1 / ($eloa1 + $elod1);
$coef2 = 2.0 * $eloa1 / ($eloa1 + $elod1);
$coef3 = 2.0 * $eloa2 / ($eloa2 + $elod2);
$coef4 = 2.0 * $elod2 / ($eloa2 + $elod2);

$va1 = ceil($fp * $fr * $coef1);
$va2 = -ceil($fp * $fr * $coef3);
$vd1 = ceil($fp * $fr * $coef2);
$vd2 = -ceil($fp * $fr * $coef4);

$output = $_POST;
$output["success"] = true;

$output["var_att1"] = $va1;
$output["var_att2"] = $va2;
$output["var_dif1"] = $vd1;
$output["var_dif2"] = $vd2;

echo json_encode($output, JSON_NUMERIC_CHECK);
exit;
