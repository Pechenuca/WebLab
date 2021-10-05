let data = {
    x: 0, y: 0, r: 0
}
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

function inRange(low, input, high, inclusive) {
    console.log(input)
    inclusive = (typeof inclusive === "undefined") ? false : inclusive;
    if (inclusive && input >= low && input <= high) return true;
    if (input > low && input < high) return true;
    return false;
}
function validateX() {
    return true
}

function validateY(input) {
    let val = parseFloat(input)
    return !inRange(-3, val, 5, false)

}

function validateR(input) {
    let val = parseFloat(input)
    return !inRange(-3, val, 5, false)

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

let form = document.forms.form

function submit_form(event) {
    event.preventDefault()
    if (!validateInput()) {
        alert('Заполните все поля формы');
        return;
    }
    axios.post('main.php', data)
        .then(function (response) {
            let result = response.data
            cache.push(result)
            sessionStorage.setItem('results', JSON.stringify(cache))

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
let cache = JSON.parse(sessionStorage.getItem('results'))
if (cache == null) {
    cache = []
}
cache.forEach(function (result) {
    addResultRow(result)
    drawPoint(result.x, result.y, result.r)
})