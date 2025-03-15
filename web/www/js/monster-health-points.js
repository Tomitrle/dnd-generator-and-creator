// Author: Brennen Muller

var size = document.getElementById("size");
var hitDice = document.getElementById("hitDice");
var customHP = document.getElementById("customHP");
var health = document.getElementById("health");

var constitution = document.getElementById("constitutionModifier");

function healthUpdate() {
    if (customHP.checked) {
        health.disabled = false;
        hitDice.disabled = true;
        return;    
    } 
    
    health.disabled = true;
    hitDice.disabled = false;
    
    var HP = Number(constitution.innerHTML);

    switch (size.value) {
        case "tiny": // d4 
            HP += 2.5 * Number(hitDice.value);
            break;

        case "small": // d6
            HP += 3.5 * Number(hitDice.value);
            break;

        case "medium": // d8
            HP += 4.5 * Number(hitDice.value);
            break;

        case "large": // d10 
            HP += 5.5 * Number(hitDice.value);
            break;

        case "huge": // d12
            HP += 6.5 * Number(hitDice.value);
            break;

        case "gargantuan": // d20 
            HP += 10.5 * Number(hitDice.value);
            break;

        default:
            break;
    }

    if (HP < 0) HP = 0;
    HP = Math.floor(HP);

    health.value = HP;
}

size.onchange = function () {healthUpdate();}
hitDice.oninput = function () {healthUpdate();}
customHP.onchange = function () {healthUpdate();}