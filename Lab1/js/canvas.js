let canvasCtx = $('#canvas')[0].getContext('2d');
const width = canvasCtx.canvas.width;
const height = canvasCtx.canvas.height;
let R = height / 3;

// side boundaries of the logical viewport
const maxX = 10;
const minX = -10;
const maxY = maxX * height / width;
const minY = minX * height / width

// Returns the physical x-coordinate of a logical x-coordinate:
function getPhysicalX(x) {
    return (x - minX) / (maxX - minX) * width ;
}

// Returns the physical y-coordinate of a logical y-coordinate:
function getPhysicalY(y) {
    return height - (y - minY) / (maxY - minY) * height ;
}


function drawCanvas() {
    if (!canvasCtx) {
        alert('your browser doesn\'t support canvas');
        return;
    }

    canvasCtx.clearRect(0, 0, width, height);
    canvasCtx.font='8px sans-serif';
    canvasCtx.strokeStyle = '#212529';
    canvasCtx.fillStyle = "#e4a663";

    //circle on the right up
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.arc(getPhysicalX(0), getPhysicalY(0), R/2, 0, -Math.PI / 2, true);
    canvasCtx.closePath();
    canvasCtx.fill();
    canvasCtx.stroke();

    //square in the right down
    canvasCtx.fillRect(getPhysicalX(0)-R, getPhysicalY(0), R, R/2);

    //triangle*
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0)-R, getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(0), getPhysicalY(0)-R);
    canvasCtx.closePath();
    canvasCtx.fill();
    canvasCtx.stroke();


    //draw Axis
    const limitMargin = 15;
    canvasCtx.save();
    canvasCtx.strokeStyle = "#e4a663";
    canvasCtx.fillStyle = "#e4a663";

    // +Y axis
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(0), getPhysicalY(maxY)+limitMargin);
    canvasCtx.stroke();

    // -Y axis
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(0), getPhysicalY(minY)-limitMargin);
    canvasCtx.stroke();

    // +X axis
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(maxX)+limitMargin, getPhysicalY(0));
    canvasCtx.stroke();

    // -X axis
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0), getPhysicalY(0));
    canvasCtx.lineTo(getPhysicalX(minX)-limitMargin, getPhysicalY(0));
    canvasCtx.stroke();

    // axis names and arrows
    canvasCtx.fillText('X', width - limitMargin, getPhysicalY(0) - 3)
    canvasCtx.fillText('Y', getPhysicalX(0) - 10, maxY + limitMargin)

    // drawing tick marks
    let valR = data.r;
    const startTickX = width / 1.95, finishTickX = width / 2.05;
    const startTickY = height / 1.9, finishTickY = height / 2.1;

    // Y axis tick marks
    canvasCtx.fillText(-valR/2, width / 2.05+8, getPhysicalY(0) + R / 2+2)
    canvasCtx.fillText(-valR, width / 2.05+8, getPhysicalY(0) + R+2)
    canvasCtx.fillText(valR/2, width / 2.05+8, getPhysicalY(0) - R / 2+2)
    canvasCtx.fillText(valR, width / 2.05+8, getPhysicalY(0) - R+2)
    canvasCtx.beginPath();
    canvasCtx.moveTo(startTickX, getPhysicalY(0) + R);
    canvasCtx.lineTo(finishTickX, getPhysicalY(0) + R);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(startTickX, getPhysicalY(0) + R / 2);
    canvasCtx.lineTo(finishTickX, getPhysicalY(0) + R / 2);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(startTickX, getPhysicalY(0) - R);
    canvasCtx.lineTo(finishTickX, getPhysicalY(0) - R);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(startTickX, getPhysicalY(0) - R / 2);
    canvasCtx.lineTo(finishTickX, getPhysicalY(0) - R / 2);
    canvasCtx.stroke();

    // X tick marks
    canvasCtx.fillText(-valR/2, getPhysicalX(0) - R / 2-6, height / 2.2)
    canvasCtx.fillText(-valR, getPhysicalX(0) - R-3, height / 2.2)
    canvasCtx.fillText(valR/2, getPhysicalX(0) + R / 2-6, height / 2.2)
    canvasCtx.fillText(valR, getPhysicalX(0) + R-3, height / 2.2)
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0) + R, startTickY);
    canvasCtx.lineTo(getPhysicalX(0) + R, finishTickY);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0) + R / 2, startTickY);
    canvasCtx.lineTo(getPhysicalX(0) + R / 2, finishTickY);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0) - R, startTickY);
    canvasCtx.lineTo(getPhysicalX(0) - R, finishTickY);
    canvasCtx.stroke();
    canvasCtx.beginPath();
    canvasCtx.moveTo(getPhysicalX(0) - R / 2, startTickY);
    canvasCtx.lineTo(getPhysicalX(0) - R / 2, finishTickY);
    canvasCtx.stroke();
}


function drawPoint(x, y, r) {
    let R = height / 3 / r;

    canvasCtx.beginPath();
    canvasCtx.moveTo(width / 2+R*x, height / 2-R*y);
    canvasCtx.arc(width / 2+R*x, height / 2-R*y, width/300,0,2*Math.PI);
    canvasCtx.closePath();
    canvasCtx.strokeStyle = "red";
    canvasCtx.fillStyle = "red";
    canvasCtx.fill();
    canvasCtx.stroke();
}