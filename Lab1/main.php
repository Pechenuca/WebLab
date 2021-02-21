<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$start = microtime(true);
session_start();

if (!isset($_SESSION['requests']) || !is_array($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
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


<script type="text/javascript">
    function validate(input) {
        input.value = input.value.replace(/[^0-9,.-]/g, '').replace(/,/, ".");
        if (isNaN(input.value) && input.value !== "-")
            input.value = "";

        if (input === document.getElementsByName("textY")[0] && input.value <= -5) {
            input.value = -4.99999;
        } else if (input === document.getElementsByName("textY")[0] && input.value >= 5) {
            input.value = 4.99999;
        }

        if (input.value.length > 8) {
            input.value = input.value.slice(0, -1);

        }
    }

    function verify() {
        const lbl = document.getElementById('enterr');
        if (!Array.prototype.some.call(document.querySelectorAll('input[type=checkbox]'), elem => elem.checked)) {
            lbl.style.fontWeight = 'bold';
            lbl.style.color = 'red';
            alert('А поч не ввел радиус?');
            event.preventDefault();
        } else {
            lbl.style.fontWeight = 'inherit';
            lbl.style.color = 'inherit';
        }
    }
</script>
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
            <div class="form-row">

                <img id="task-img" src="picture.jpg" alt="" width="50%">

            </div>
        </td>
    </tr>

</table>
<table>
    <tbody>




    <form action="main.php" method="get" onsubmit="verify()">
        <tr class="checkBoxX">
            <td class="form-control-title" id="enterx"> X:</td>
            <td>
                <label for="checkboxX-4">-4</label><input id="checkboxX-4" name="checkboxX" type="checkbox" value="-4"
                />
                <label for="checkboxX-3">-3</label><input id="checkboxX-3" name="checkboxX" type="checkbox" value="-3"
                />
                <label for="checkboxX-3">-2</label><input id="checkboxX-2" name="checkboxX" type="checkbox" value="-2"
                />
                <label for="checkboxX-1">-1</label><input id="checkboxX-1" name="checkboxX" type="checkbox" value="-1"
                />
                <label for="checkboxX0">0</label><input id="checkboxX0" name="checkboxX" type="checkbox" value="0"
                />
                <label for="checkboxX1">1</label><input id="checkboxX1" name="checkboxX" type="checkbox" value="1"
                />
                <label for="checkboxX2">2</label><input id="checkboxX2" name="checkboxX" type="checkbox" value="2"
                />
                <label for="checkboxX3">3</label><input id="checkboxX3" name="checkboxX" type="checkbox" value="3"
                />
                <label for="checkboxX4">4</label><input id="checkboxX4" name="checkboxX" type="checkbox" value="4"
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
                <label for="r1">1</label><input id="r1" name="radius" type="checkbox" value="1"/>
                <label for="r2">2</label><input id="r2" name="radius" type="checkbox" value="2"/>
                <label for="r3">3</label><input id="r3" name="radius" type="checkbox" value="3"/>
                <label for="r4">4</label><input id="r4" name="radius" type="checkbox" value="4"/>
                <label for="r5">5</label><input id="r5" name="radius" type="checkbox" value="5"/>
            </td>
        </tr>

        <td id="buttons">
            <button id="suputton" name="suputton" type="submit">Отправить...</button>
        </td>

    </form>
</table>


<table>
    <tr class="manageButtons">
        <td>
            <form action="clearHistory.php" method="get">
                <button>Очистить сессионную историю</button>
            </form>
        </td>
    </tr>
</table>


<?php
if (isset($_GET["checkboxX"]) && isset($_GET["textY"]) && isset($_GET["radius"])) {
    $checkboxX = htmlspecialchars($_GET["checkboxX"]);
    $textY = htmlspecialchars($_GET["textY"]);
    $radius = htmlspecialchars($_GET["radius"]);

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

    date_default_timezone_set("Europe/Moscow");

    $validX = is_numeric($checkboxX) && $checkboxX >= -4 && $checkboxX <= 4;
    $validY = is_numeric($textY) && $textY > -5 && $checkboxX < 5 && filter_var($textY, FILTER_VALIDATE_INT);
    $validR = is_numeric($radius) && filter_var($radius, FILTER_VALIDATE_INT) && $radius >= 1 && $radius <= 5;

    if ($validX && $validY && $validR) {
        array_unshift($_SESSION['requests'], [
            "y" => $textY,
            "x" => $checkboxX,
            "r" => $radius,
            "res" => isHit($checkboxX, $textY, $radius),
            "date" => date('m/d/Y h:i:s a', time()),
            "runtime" => round(microtime(true) - $start, 5)
        ]);
    } else {
        if (!$validR) {
            echo "НЕ ВАЛИДНЫЙ РАДИУССС!";
        }

        if (!$validY) {
            echo("НЕ ВАЛИДНЫЙ ИГРИК!");
        }

        if (!$validX) {
            echo("НЕ ВАЛИДНЫЙ ИКККС!");
        }

    }
}

foreach ($_SESSION["requests"] as $request) {
    ?>
    <br>
    <table class="results">
        <tr>
            <td>Координата X</td>
            <td><?= $request["x"] ?></td>
            <td>Координата Y</td>
            <td><?= $request["y"] ?></td>
            <td>Радиус</td>
            <td><?= $request["r"] ?></td>
            <td>Результат</td>
            <td><?= $request["res"] ?></td>
            <td>Текущее время</td>
            <td><?= $request["date"] ?></td>
            <td>Время работы скрипта</td>
            <td><?= $request["runtime"] ?></td>
        </tr>
    </table>
</body>
</html>
    <?php
}
?>


