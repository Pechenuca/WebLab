$(document).ready(function () {
    if (localStorage.getItem("results") != null) {
        let localData = JSON.parse(localStorage.getItem("results"));
        localData.map(item => addResultRow(item))
    }
});

const valuesX = ['-4', '-3', '-2', '-1', '0', '1', '2', '3', '4'];

for (const number of valuesX) {
    $('#options_x')
        .append(`<input type="button" id="${number}" name="x[]" value="${number}" form="request-form">`)

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
    var validY, validR
    validY = validateY($('input#y').val())

    validR = validateR($('input#r').val())

    $('#submit-btn').attr('disabled', !(validY && validR))

    return validY && validR
}


/*
* send data async
* */
$('#request-form').submit(function (event) {
    event.preventDefault()
    if (!validateInput()) {
        alert('at least one checkbox selected, the radio selected and a nice number for Y');
        return;
    }

    let action = "main.php";
    let data = $(this).serialize();

    $.post(action, data, function (response) {
        if (response.RESULT_CODE === '0') {
            drawCanvas();
            response.RESULTS.map(item => {
                addToLocalStorage(item)
                addResultRow(item)
                drawPoint(item.x, item.y, item.r)
            })
        } else {
            alert(response.RESULTS)
            console.log(response.RESULTS)
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