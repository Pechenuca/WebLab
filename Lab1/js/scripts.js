let data = {
    x:0, y:0, r:0
}
$(document).ready(function () {
    if (localStorage.getItem("results") != null) {
        let localData = JSON.parse(localStorage.getItem("results"));
        localData.map(item => addResultRow(item))
    }
});

function set_x(value) {
    data.x = value
}

function set_y(value) {
    data.y = parseFloat(value)
}

function set_r(value) {
    data.r = parseFloat(value)
}

function validateX() {
    return true
}

function validateY(input) {
    let val = parseFloat(input)
    if (isNaN(input))
        return false;

    return (val >= -3 && val <= 5)
}

function validateR(input) {
    let val = parseFloat(input)
    if (isNaN(input))
        return false;

    return (val >= 1 && val <= 4)
}

function validateInput() {
    var validX, validY, validR;
    validY = validateY(data.y);
    validR = validateR(data.r);
    validX = validateX(data.x);
    console.log(validX + ' ' + validY + ' ' + validR + ' ' + data.x)

    $('#submit-btn').attr('disabled', !(validX && validY && validR));

    return validX && validY && validR;

}
let form = $('#request-form')

form.submit(function (event) {
    event.preventDefault()
    if (!validateInput()) {
        alert('Заполните все поля формы');
        return;
    }

    let action = "main.php";

    $.post(action, data, function (response) {
        response = JSON.parse(response)
        if (response.RESULT_CODE === '0') {
            drawCanvas();
            response.RESULTS.map(item => {
                addToLocalStorage(item)
                addResultRow(item)
                drawPoint(item.x, item.y, item.r)
            })
        } else {
            console.log(response)

        }
    });
});


function addToLocalStorage(item) {
    let localData = localStorage.getItem("results")
    localData = localData ? JSON.parse(localData) : []
    localData.push(item)
    localStorage.setItem("results", JSON.stringify(localData))
}

/*
* Adding results to the table
* */
function addResultRow(response) {
    let rowStyle = (response.result === 'true') ? 'green-row' : 'red-row';
    $('.results-table #results_table_body').append(
        "<tr>" +
        "<td>" + response.x + "</td>" +
        "<td>" + response.y + "</td>" +
        "<td>" + response.r + "</td>" +
        "<td class=" + rowStyle + ">" + response.result + "</td>" +
        "<td>" + response.currentTime + "</td>" +
        "<td>" + response.computedTime + "</td>" +
        "</tr>"
    );
}

$(window).resize(drawCanvas)
$(window).on("load", drawCanvas)
$("input:button").change(drawCanvas)