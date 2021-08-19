// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        var elements = document.getElementsByClassName('nav-link'); // get all elements
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.color = "#27A5F0";
            elements[elements.length - 1].style.color = "#fff";
        }
        document.getElementById("navbar").style.backgroundColor = "#fff";
        document.getElementById("navbar").style.padding = "0px";
        document.getElementById("logo-rb").style.width = "60%";
        document.getElementById("logos").style.padding = "15px";
        document.getElementById("logos").style.backgroundColor = "transparent";
        // document.getElementById("menu").style.color = "#000";
    } else {
        var elements = document.getElementsByClassName('nav-link'); // get all elements
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.color = "white";
        }
        document.getElementById("navbar").style.backgroundColor = "transparent";
        document.getElementById("navbar").style.padding = "0 50px";
        document.getElementById("logo-rb").style.width = "75%";
        document.getElementById("logos").style.padding = "15px 0 50px 0";
        document.getElementById("logos").style.backgroundColor = "#FEF6B8";
    }
}

/*
* Start Config Vars
*/

var yPosMax = 125;
var yPosMin = 125;
var yPosStart = 150;
var xPosStart = -50;
var yPosChangeMultiplier = 60;
var xPosChangeMin = 125;
var xPosChangeMultiplier = 25;
var yControlMultiplier = 20;
var yControlMin = 40;

/*
* End Config Vars
*/

canvas = document.getElementById('canvas');
context = canvas.getContext('2d');
context.fillStyle = '#FFFFFF';
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvas.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvas.width, yPos);
context.lineTo(canvas.width, canvas.height);
context.lineTo(0, canvas.height);
context.fill();


canvasGrey = document.getElementById('canvasGrey');
context = canvasGrey.getContext('2d');
context.fillStyle = '#F2F3F4';
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvasGrey.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvasGrey.width, yPos);
context.lineTo(canvasGrey.width, canvasGrey.height);
context.lineTo(0, canvasGrey.height);
context.fill();

canvasGrad = document.getElementById('canvasGrad');
context = canvasGrad.getContext('2d');
context.fillStyle = "#ABD3EB"
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvasGrad.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvasGrad.width, yPos);
context.lineTo(canvasGrad.width, canvasGrad.height);
context.lineTo(0, canvasGrad.height);
context.fill();

canvasWhite = document.getElementById('canvasWhite');
context = canvasWhite.getContext('2d');
context.fillStyle = "#FFFFFF"
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvasWhite.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvasWhite.width, yPos);
context.lineTo(canvasWhite.width, canvasWhite.height);
context.lineTo(0, canvasWhite.height);
context.fill();

canvasFooter = document.getElementById('canvasFooter');
context = canvasFooter.getContext('2d');
context.fillStyle = "#F2F3F4"
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvasFooter.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvasFooter.width, yPos);
context.lineTo(canvasFooter.width, canvasFooter.height);
context.lineTo(0, canvasFooter.height);
context.fill();

canvasBlue = document.getElementById('canvasBlue');
context = canvasBlue.getContext('2d');
context.fillStyle = "#ABD3EB"
var xPos = xPosStart;
var yPos = yPosStart;
context.beginPath();
context.moveTo(xPos, yPos);
while (xPos < canvasBlue.width) {
    lastX = xPos;
    xPos += Math.floor(Math.random() * xPosChangeMultiplier + xPosChangeMin);
    yPos += Math.floor(Math.random() * yPosChangeMultiplier - yPosChangeMultiplier / 2);
    while (yPos < yPosMin) {
        yPos += Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    while (yPos > yPosMax) {
        yPos -= Math.floor(Math.random() * yPosChangeMultiplier / 2);
    }
    controlX = (lastX + xPos) / 2;
    controlY = yPos - Math.floor(Math.random() * yControlMultiplier + yControlMin);
    context.quadraticCurveTo(controlX, controlY, xPos, yPos);
}
context.lineTo(canvasBlue.width, yPos);
context.lineTo(canvasBlue.width, canvasBlue.height);
context.lineTo(0, canvasBlue.height);
context.fill();