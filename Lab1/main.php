<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$start = microtime();
$x = $_POST['x'];
$y = $_POST['y'];
$r = $_POST['r'];
header('Content-type: application/json');

$argsX = array('-4', '-3', '-2', '-1', '0', '1', '2', '3', '4');


$validatedX = true;
foreach ($x as $val) {
    if (!in_array($val, $argsX)) {
        $validatedX = false;
        break;
    }
}
if (!$validatedX or ($r < 1 or $r > 4) or ($y < -5 or $y > 3)
    or filter_var($y, FILTER_VALIDATE_FLOAT) === FALSE or filter_var($r, FILTER_VALIDATE_FLOAT) === FALSE) {
    echo "{\"RESULT_CODE\": \"". 1 ."\", \"RESULTS\": \"What are u trying to do? something is wrong with input\"}";
    die();
}

function isHit($x, $y, $r)
{
    $quarter = 0;
    if ($x > 0 && $y > 0) $quarter = 1;
    if ($x < 0 && $y > 0) $quarter = 2;
    if ($x < 0 && $y < 0) $quarter = 3;
    if ($x > 0 && $y < 0) $quarter = 4;

    if ($quarter == 3) {
        if ($y <= -$r / 2 && $x >= -$r) {
            return 'true';
        } else {
            return 'false';
        }
    }

    if ($quarter == 2) {
        $y_function = $x + $r;
        if ($y_function >= $y) {
            return 'true';
        } else {
            return 'false';
        }
    }

    if ($quarter == 3) {
        $distance = $x * $x + $y * $y;
        $distance = sqrt($distance);
        if ($distance <= $r) {
            return 'true';
        } else {
            return 'false';
        }

    }

    if ($quarter == 4) {
        return 'false';
    }

    if ($quarter == 0) {
        return 'true';
    }

    $response = "{\"RESULT_CODE\":\"" . 0 . "\", \"RESULTS\": [";
    foreach ($x as $valX) {
        $data = "{ \"x\":" . "\"" . $valX . "\""
            . ", \"y\":" . "\"" . $y . "\""
            . ", \"r\":" . "\"" . $r . "\""
            . ", \"result\":" . "\"" . isHit($valX, $y, $r) . "\""
            . ", \"currentTime\":" . "\"" . date("Y-m-d H:i:s") . "\""
            . ", \"computedTime\":" . "\"" . (microtime(true) - $start) . "\""
            . "}";
        $data .= ($valX === end($x)) ? "" : ",";
        $response .= $data;
    }
    $response .= "]}";

    echo $response;
}