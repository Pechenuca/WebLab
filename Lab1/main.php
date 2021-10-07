<?php
session_start(true);
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

//if(file_exists('results.data')) {
//    file_put_contents('results.data', ",".$response, FILE_APPEND | LOCK_EX);
//} else {
//    file_put_contents('results.data', $response, LOCK_EX);
//}

$response = toJSON([

    'x' => $x,
    'y' => $y,
    'r' => $r,
    'result' => checkInsideFunc($x, $y, $r),
    'currentTime' => date("Y-m-d H:i:s"),
    'computedTime' => round((microtime(true) - $start) * 1000, 6)
]);
$now = date("H:i:s");

$answer = array($x, $y, $r, checkInsideFunc($x, $y, $r), $now, microtime(true) - $start);

if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = array();
}
array_push($_SESSION['data'], $answer);
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = array();
}
array_push($_SESSION['data'], $answer);
?>
<table align="center" class="not-main-table">
    <tr>
        <th class="variable">X</th>
        <th class="variable">Y</th>
        <th class="variable">R</th>
        <th>Result</th>
        <th>Time</th>
        <th>Script time</th>
    </tr>
    <?php foreach ($_SESSION['data'] as $word) { ?>
        <tr>
            <td><?php echo $word[0] ?></td>
            <td><?php echo $word[1] ?></td>
            <td><?php echo $word[2] ?></td>
            <td><?php echo $word[3] ?></td>
            <td><?php echo $word[4] ?></td>
            <td><?php echo number_format($word[5], 10, ".", "") ?></td>
        </tr>
    <?php }?>
</table>
<?php
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
    }
    return false;
}


