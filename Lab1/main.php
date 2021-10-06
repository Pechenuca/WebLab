<?php

$start = microtime(true);
date_default_timezone_set("Europe/Moscow");
$input = json_decode(file_get_contents('php://input'));
$x = $input -> x;
$y = $input -> y;
$r = $input -> r;

$validatedX = true;

if (is_nan($x) or ($r < -1 or $r > 4) or ($y < -3 or $y > 5)
    or filter_var($y, FILTER_VALIDATE_FLOAT) === FALSE
    or filter_var($r, FILTER_VALIDATE_FLOAT) === FALSE) {
    echo "What are u trying to do? something is wrong with input";
    http_response_code(403);
    die();
}
$response = json_encode(['x' => $x, 'y' => $y, 'r' => $r, 'result' => checkInsideFunc($x, $y, $r),
    'currentTime'=> date("Y-m-d H:i:s"),
    'computedTime' => round((microtime(true) - $start) * 1000, 6)]);

echo $response;

function checkInsideFunc($x, $y, $r)
{
    if (($x > 0 && $y > 0) && ($y <= sqrt($r * $r - $x * $x))
        or ($x < 0 && $y > 0) && ($y <= $r / 2 && $x >= $r)
        or ($x < 0 && $y < 0) && ($y <= -$r / 2 && $x >= -$r)
        //or ($x > 0 && $y < 0)
        or ($x==0 && $y == 0))
        return 'true';
    return 'false';


}