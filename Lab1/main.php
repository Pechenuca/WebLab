<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PIPi</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<table class="header-table">
    <tbody>
    <tr class="header-tr">
        <h1 class="header-text">
            <span> Epifanov Maxim P3232 Var 2806 </span>
        </h1>
    </tr>
    </tbody>
</table>
<?php

function isHit($x, $y, $r)
{
    $quarter = 0;
    if ($x < 0 && $y > 0) $quarter = 1;
    if ($x > 0 && $y > 0) $quarter = 2;
    if ($x > 0 && $y < 0) $quarter = 3;
    if ($x < 0 && $y < 0) $quarter = 4;


    if ($quarter == 1) {
        return "NO";
    }

    if ($quarter == 2) {
        $y_function = -$x + $r / 2;
        if ($y_function >= $y) {
            return "YES";
        } else {
            return "NO";
        }
    }

    if ($quarter == 3) {
        $distance = $x * $x + $y * $y;
        $distance = sqrt($distance);
        if ($distance <= $r) {
            return "YES";
        } else {
            return "NO";
        }

    }

    if ($quarter == 4) {
        if ($y <= -$r / 2 && $x >= -$r) {
            return "YES";
        } else {
            return "NO";
        }
    }

    if ($quarter == 0) {
        return "YES";
    }
}

function checkParametres($x, $y, $r)
{
    if (!in_array($x, array(-4, -3, -2, -1, 0, 1, 2, 3, 4,)) || !is_numeric($y) || !is_numeric($x) || !is_numeric($r) || $y < -5 || $y > 5 || !in_array($r, array(1, 2, 3, 4, 5))) return false;
    else return true;
}

$start = microtime(true);
date_default_timezone_set("Europe/Moscow");
session_start();

$x = (int)$_GET["checkboxX"];
$y = (double)$_GET["textY"];
$r = (int)$_GET["radius"];

if ($x == 0 && $_GET["checkboxX"] != "0" || $y == 0 && $_GET["textY"] != "0" || $r == 0 && $_GET["radius"] != "0") {
    $x = $_GET["checkboxX"];
    $y = $_GET["textY"];
    $r = $_GET["radius"];
}


$current_time = date("H:i:s");
$result = isHit($x, $y, $r);

if (!checkParametres($x, $y, $r)) {
    $result = "<span style ='color: red'>Данные не верны</span>";
}

$time_of_exec = round((microtime(true) - $start) * 1000000, 2);

$finalResult = array($x, $y, $r, $time_of_exec, $current_time, $result);

if (!isset($_SESSION['allResults'])) {
    $_SESSION['allResults'] = array();
}

array_push($_SESSION['allResults'], $finalResult)
?>

<table class="results">
    <?php foreach ($_SESSION['allResults'] as $value) { ?>
    <tr>

        <td><?php echo $value[0] ?></td>
        <td><?php echo $value[1] ?></td>
        <td><?php echo $value[2] ?></td>
        <td><?php echo $value[3] ?></td>
        <td><?php echo $value[4] ?></td>
        <td><?php echo $value[5] ?></td>

    </tr>
</table>

<?php
}
?>
</body>
</html>
