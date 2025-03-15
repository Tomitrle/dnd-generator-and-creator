// Author: Brennen Muller

var size = document.getElementById("size");
var hitDice = document.getElementById("hitDice");
var customHP = document.getElementById("customHP");
var health = document.getElementById("health");

var constitution = document.getElementById("constitutionModifier");

function updateHealthPoints() {
    /**
     * Enables and disables elements as necessary.
     * The automatic update is not performed when the user has selected manual entry.
     */
    if (customHP.checked) {
        health.disabled = false;
        hitDice.disabled = true;
        return;    
    }
    health.disabled = true;
    hitDice.disabled = false;
    
    /**
     * Calculates the update to the monster's health points
     */
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

    // Round to the nearest valid integer
    if (HP < 1) HP = 1;
    HP = Math.floor(HP);

    health.value = HP;
}

size.onchange = function () {updateHealthPoints();}
hitDice.oninput = function () {updateHealthPoints();}
customHP.onchange = function () {updateHealthPoints();}

// SHOULD ALSO UPDATE ON CONSTITUTION CHANGE