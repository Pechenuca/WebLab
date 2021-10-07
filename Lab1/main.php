<?php
$start = microtime(true);
date_default_timezone_set("Europe/Moscow");

$x = $_POST['x'];
$y = $_POST['y'];
$r = $_POST['r'];

$validatedX = true;

if (is_nan($x) or ($r < -1 or $r > 4) or ($y < -3 or $y > 5)
    or filter_var($y, FILTER_VALIDATE_FLOAT) === FALSE
    or filter_var($r, FILTER_VALIDATE_FLOAT) === FALSE) {

    echo "What are u trying to do? something is wrong with input";
    http_response_code(403);
    die();
}

$response = toJSON([

    'x' => $x,
    'y' => $y,
    'r' => $r,
    'result' => checkInsideFunc($x, $y, $r),
    'currentTime' => date("Y-m-d H:i:s"),
    'computedTime' => round((microtime(true) - $start) * 1000, 6)
]);

if(file_exists('results.data')) {
    file_put_contents('results.data', ",".$response, FILE_APPEND | LOCK_EX);
} else {
    file_put_contents('results.data', $response, LOCK_EX);
}

echo($response);

function checkInsideFunc($x, $y, $r)
{
    if (($x > 0 && $y > 0) && ($y <= sqrt($r * $r - $x * $x))
        or ($x < 0 && $y > 0) && ($y <= $r / 2 && $x >= $r)
        or ($x < 0 && $y < 0) && ($y <= -$r / 2 && $x >= -$r)

        or ($x == 0 && $y == 0))
        return 'true';
    return 'false';


}

function toJSON($o)
{
    switch (gettype($o)) {
        case 'NULL':
            return 'null';
        case 'integer':
        case 'double':
            return strval($o);
        case 'string':
            return '"' . addslashes($o) . '"';
        case 'boolean':
            return $o ? 'true' : 'false';
        case 'object':
            $o = (array)$o;
        case 'array':
            $foundKeys = false;

            foreach ($o as $k => $v) {
                if (!is_numeric($k)) {
                    $foundKeys = true;
                    break;
                }
            }

            $result = array();

            if ($foundKeys) {
                foreach ($o as $k => $v) {
                    $result [] = toJSON($k) . ':' . toJSON($v);
                }

                return '{' . implode(',', $result) . '}';
            } else {
                foreach ($o as $k => $v) {
                    $result [] = toJSON($v);
                }
                return '[' . implode(',', $result) . ']';
            }
    }
    return false;
}
