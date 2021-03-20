<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

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
<table>
    <tr>
        <td>
    <tr>
        <td>
            <svg width="300" height="300" class="svg-graph">

                <!--            Линии оси-->

                <line class="axis" x1="0" x2="300" y1="150" y2="150" stroke="green"></line>
                <line class="axis" x1="150" x2="150" y1="0" y2="300" stroke="black"></line>
                <polygon points="150,0 144,15 156,15" stroke="black"></polygon>
                <polygon points="300,150 285,156 285,144" stroke="black"></polygon>

                <line class="coor-line" x1="200" x2="200" y1="155" y2="145" stroke="black"></line>
                <line class="coor-line" x1="250" x2="250" y1="155" y2="145" stroke="black"></line>

                <line class="coor-line" x1="50"  x2="50"  y1="155" y2="145" stroke="black"></line>
                <line class="coor-line" x1="100" x2="100" y1="155" y2="145" stroke="black"></line>

                <line class="coor-line" x1="145" x2="155" y1="100" y2="100" stroke="black"></line>
                <line class="coor-line" x1="145" x2="155" y1="50"  y2="50"  stroke="black"></line>

                <line class="coor-line" x1="145" x2="155" y1="200" y2="200" stroke="black"></line>
                <line class="coor-line" x1="145" x2="155" y1="250" y2="250" stroke="black"></line>

                <text class="coor-text" x="195" y="140">R/2</text>
                <text class="coor-text" x="248" y="140">R</text>

                <text class="coor-text" x="40" y="140">-R</text>
                <text class="coor-text" x="90" y="140">-R/2</text>

                <text class="coor-text" x="160" y="105">R/2</text>
                <text class="coor-text" x="160" y="55">R</text>

                <text class="coor-text" x="160" y="205">-R/2</text>
                <text class="coor-text" x="160" y="255">-R</text>

                <text class="axis-text" x="290" y="170">X</text>
                <text class="axis-text" x="160" y="13">Y</text>

                <!-- first figure-->
                <polygon class="rectangle-figure" points="50,150 50,200 150,200, 150,150"
                         fill="wheat"  fill-opacity="0.5" ></polygon>

                <!-- second figure-->
                <polygon class="triangle-figure" points="150,150 150,100 200,150"
                         fill="wheat" fill-opacity="0.5" ></polygon>

                <!-- third figure-->
                <path class="circle-figure" d="M 250 150 A 100 100, 180, 0, 1, 150 250 L 150 150 Z"
                      fill="wheat" fill-opacity="0.5" ></path>

                <circle r="0" cx="150" cy="150" id="target-dot"></circle>

            </svg>
        </td>
    </tr>

</table>
<table>
    <tbody>


    <form class = "validateForm" action="main.php" method="GET">
        <tr class="checkBoxX">
            <td class="form-control-title" id="enterx"> X:</td>
            <td>
                <label for="checkboxX-4">-4</label><input id="checkboxX-4" name="checkboxX" type="radio" value="-4"
                />
                <label for="checkboxX-3">-3</label><input id="checkboxX-3" name="checkboxX" type="radio" value="-3"
                />
                <label for="checkboxX-3">-2</label><input id="checkboxX-2" name="checkboxX" type="radio" value="-2"
                />
                <label for="checkboxX-1">-1</label><input id="checkboxX-1" name="checkboxX" type="radio" value="-1"
                />
                <label for="checkboxX0">0</label><input id="checkboxX0" name="checkboxX" type="radio" value="0"
                />
                <label for="checkboxX1">1</label><input id="checkboxX1" name="checkboxX" type="radio" value="1"
                />
                <label for="checkboxX2">2</label><input id="checkboxX2" name="checkboxX" type="radio" value="2"
                />
                <label for="checkboxX3">3</label><input id="checkboxX3" name="checkboxX" type="radio" value="3"
                />
                <label for="checkboxX4">4</label><input id="checkboxX4" name="checkboxX" type="radio" value="4"
                />
            </td>
        </tr>

        <tr class="textY">
            <td class="form-control-title" id=" entery"> Y:</td>
            <td>
                <input type="text" id="textY" name="textY" oninput="validate(this)" required>
            </td>
        </tr>

        <tr class="checkBoxR">
            <td class="form-control-title" id="enterr"> R:</td>
            <td>
                <label for="r1">1</label><input id="r1" name="radius" type="radio" value="1"/>
                <label for="r2">2</label><input id="r2" name="radius" type="radio" value="2"/>
                <label for="r3">3</label><input id="r3" name="radius" type="radio" value="3"/>
                <label for="r4">4</label><input id="r4" name="radius" type="radio" value="4"/>
                <label for="r5">5</label><input id="r5" name="radius" type="radio" value="5"/>
            </td>
        </tr>

        <td id="button">
            <button class="butt" name="sendButton" type="submit">Отправить...</button>
        </td>

    </form>
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
        return "<span style='color: red'>Мимо</span>";
    }

    if ($quarter == 2) {
        $y_function = -$x + $r / 2;
        if ($y_function >= $y) {
            return "<span style='color: green'>Попал</span>";
        } else {
            return "<span style='color: red'>Мимо</span>";
        }
    }

    if ($quarter == 3) {
        $distance = $x * $x + $y * $y;
        $distance = sqrt($distance);
        if ($distance <= $r) {
            return "<span style='color: green'>Попал</span>";
        } else {
            return "<span style='color: red'>Мимо</span>";
        }

    }

    if ($quarter == 4) {
        if ($y <= -$r / 2 && $x >= -$r) {
            return "<span style='color: green'>Попал</span>";
        } else {
            return "<span style='color: red'>Мимо</span>";
        }
    }

    if ($quarter == 0) {
        return "<span style='color: green'>Попал</span>";
    }
}

function checkParametres($x, $y, $r)
{
    if (!in_array($x, array(-4, -3, -2, -1, 0, 1, 2, 3, 4,)) || !is_numeric($y) || !is_numeric($x) || !is_numeric($r) || $y < -5 || $y > 5 || !in_array($r, array(1, 2, 3, 4, 5))) return false;
    else return true;
}

$start = microtime(true);
date_default_timezone_set("Europe/Moscow");

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
<table>
    <tr class="manageButtons">
        <td>
            <form action="clearHistory.php" method="get">
                <button>Очистить сессионную историю</button>
            </form>
        </td>
    </tr>
</table>

<table class="results">
    <?php foreach ($_SESSION['allResults'] as $value) { ?>
    <br>
    <tr>
        <td>X</td>
        <td><?php echo $value[0] ?></td>
        <td>Y</td>
        <td><?php echo $value[1] ?></td>
        <td>R</td>
        <td><?php echo $value[2] ?></td>
        <td>Результат</td>
        <td><?php echo $value[3] ?></td>
        <td>Время</td>
        <td><?php echo $value[4] ?></td>
        <td>Работа с крипта (с)</td>
        <td><?php echo $value[5] ?></td>

    </tr>
</table>

<?php
}
?>

</body>
</html>
