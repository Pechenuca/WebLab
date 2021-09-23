<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$start = microtime(true);
$x = $_POST['x'];
$y = $_POST['y'];
$r = $_POST['r'];


$validatedX = true;

if (is_nan($x) or ($r < 1 or $r > 4) or ($y < -3 or $y > 5)
    or filter_var($y, FILTER_VALIDATE_FLOAT) === FALSE
    or filter_var($r, FILTER_VALIDATE_FLOAT) === FALSE) {
    echo "{\"RESULT_CODE\": \"" . 1 . "\", \"RESULTS\": \"What are u trying to do? something is wrong with input\"}";
    die();
}

$response = "{\"RESULT_CODE\":\"" . 0 . "\", \"RESULTS\": [";

$data = "{ \"x\":" . "\"" . $x . "\""
    . ", \"y\":" . "\"" . $y . "\""
    . ", \"r\":" . "\"" . $r . "\""
    . ", \"result\":" . "\"" . checkInsideFunc($x, $y, $r) . "\""
    . ", \"currentTime\":" . "\"" . date("Y-m-d H:i:s") . "\""
    . ", \"computedTime\":" . "\"" . round((microtime(true) - $start) * 1000, 6) . "\""
    . "}";

$response .= $data;

$response .= "]}";

echo $response;

function checkInsideFunc($x, $y, $r)
{
    if (($x > 0 && $y > 0) && ($y <= sqrt($r * $r - $x * $x))
        or ($x < 0 && $y > 0) && ($y <= $r / 2 && $x >= $r)
        or ($x < 0 && $y < 0) && ($y <= -$r / 2 && $x >= -$r)
        or ($x > 0 && $y < 0))
        return 'true';
    return 'false';


}