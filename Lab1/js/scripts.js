let data = {
    x: 0, y: 0, r: 0
}
let max_y = parseFloat('5')
let min_y = parseFloat('-3')
let max_r = parseFloat('4')
let min_r = parseFloat('-1')
const button = document.getElementById('submit-btn')

function set_x(value) {
    data.x = value
}

function set_y(value) {
    data.y = parseFloat(value)
}

function set_r(value) {
    data.r = parseFloat(value)
}

function check_if_undefined(x, y, r) {
    if ((x === 'undefined' || null) && (y === 'undefined' || null) && (r === 'undefined' || null)) {
        alert("Value is undefined")
    }

}

function inRange(low, input, high, inclusive) {
    inclusive = (typeof inclusive === "undefined") ? false : inclusive;
    if (inclusive && input >= low && input <= high) return true;
    return input > low && input < high;

}

function validateX() {
    return true
}

function validateY(input) {

    let val = parseFloat(input).toPrecision(8)
    console.log(val)
    check_if_undefined(val)
    return inRange(min_y, val, max_y, false)
}

function validateR(input) {
    let val = parseFloat(input).toPrecision(8)
    console.log(val)
    check_if_undefined(val)
    return inRange(min_r, val, max_r, false)
}

function validateInput() {
    let validX, validY, validR
    validY = validateY(data.y)
    validR = validateR(data.r)
    validX = validateX(data.x)

    console.log(validX + ' ' + validY + ' ' + validR + ' ' + data.x)
    button.disabled = !(validX && validY && validR)
    return validX && validY && validR
}

function submit_form(event) {

    let body = new FormData();
    for (let [key, value] of Object.entries(data)) {
        body.append(key, value);
    }
    event.preventDefault()
    if (!validateInput()) {
        alert('Заполните все поля формы')
        return;
    }
    axios.post('/~s282351/main.php', body, {
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(function (response) {
            let result = response.data

            //sessionStorage.setItem('results', JSON.stringify(cache))

            drawCanvas();

            console.log(response)

            addResultRow(result)
            drawPoint(result.x, result.y, result.r)

            console.log(response)
        })
        .catch(function (error) {

            console.log(error)
        });
}


/*
* Adding results to the table
* */
function addResultRow(response) {
    console.log(response)

    let rowStyle = (response.result === 'true') ? 'green-row' : 'red-row'
    document.getElementById('results_table_body').innerHTML +=
        "<tr>" +
        "<td>" + response.x + "</td>" +
        "<td>" + response.y + "</td>" +
        "<td>" + response.r + "</td>" +
        "<td class=" + rowStyle + ">" + response.result + "</td>" +
        "<td>" + response.currentTime + "</td>" +
        "<td>" + response.computedTime + "</td>" +
        "</tr>"
}

window.addEventListener('resize', drawCanvas)
window.addEventListener("load", drawCanvas)
button.addEventListener('change', drawCanvas)
