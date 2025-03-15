// Author: Brennen Muller

/**
 * Converts and updates ability modifiers into ability scores.
 * Automatic updates are handled with EventListeners. 
 */

function modifier(score) { 
    return Math.floor((Number(score) - 10) / 2);
}

function updateAbilityModifier (event) {
    console.log(event.target.id.replace("Score", "Modifier"));
    var abilityModifier = document.getElementById(event.target.id.replace("Score", "Modifier"));
    var value = modifier(event.target.value);
    abilityModifier.innerHTML = String(value);
}

function setupAbilityUpdates() {
    for (var ability of new Array("strength", "dexterity", "constitution", "intelligence", "wisdom", "charisma")) {
        var abilityScore = document.getElementById(ability + "Score");
        abilityScore.addEventListener("input", updateAbilityModifier);
    }
}

setupAbilityUpdates();

/**
 * Updates armor class and hitpoints automatically.
 * Enables and disables fields as needed. 
 *
 * Sources: 
 * https://html.spec.whatwg.org/#embedding-custom-non-visible-data-with-the-data-*-attributes
 * https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
 * https://stackoverflow.com/questions/12328144/how-do-i-access-custom-html-attributes-in-javascript
 */
var armor = document.getElementById("armor");
var shield = document.getElementById("shield");
var armorClass = document.getElementById("armorClass");

var size = document.getElementById("size");
var hitDice = document.getElementById("hitDice");
var customHP = document.getElementById("customHP");
var health = document.getElementById("health");

var dexterity = document.getElementById("dexterityScore");
var constitution = document.getElementById("constitutionScore");
 
function updateArmorClass() {
    /**
     * Enables and disables element(s) as necessary.
     * The automatic update is not performed when the user has selected manual entry.
     */
    if (armor.value === "Natural Armor" || armor.value === "Other") {
        armorClass.disabled = false;
        return;    
    } 
    armorClass.disabled = true;

    /**
     * Calculates the update to the monster's armor class
     */
    var AC = Number(armor.options[armor.selectedIndex].getAttribute('data-ac'));
    
    switch (armor.options[armor.selectedIndex].getAttribute('data-type')) {
        case "light":
            AC += modifier(dexterity.value);
            break;

        case "medium":
            AC += Math.min(modifier(dexterity.value), 2);
            break;

        case "heavy":
            break;

        default:
            break;
    }

    if (shield.checked) AC += 2;

    armorClass.value = AC;
}

armor.addEventListener("change", updateArmorClass);
shield.addEventListener("change", updateArmorClass);
dexterity.addEventListener("input", updateArmorClass);

function updateHealthPoints() {
    if (customHP.checked) {
        health.disabled = false;
        hitDice.disabled = true;
        return;    
    }
    health.disabled = true;
    hitDice.disabled = false;
    
    var HP = Number(modifier(constitution.value));

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

size.addEventListener("change", updateHealthPoints);
hitDice.addEventListener("input", updateHealthPoints);
customHP.addEventListener("change", updateHealthPoints);
constitution.addEventListener("input", updateHealthPoints);

// https://stackoverflow.com/questions/62707474/how-to-assign-labels-on-a-range-slider
function updateSliderLabel(event) {
  var label = document.getElementById(event.target.id.replace("range", "rangeLabel"));

  switch (event.target.value) {
    case "-1":
        label.innerHTML = "Detrimental";
        break;
    case "0":
        label.innerHTML = "Neutral";
        break;
    case "1":
        label.innerHTML = "Beneficial";
        break;
    case "2":
        label.innerHTML = "Powerful";
        break;
    default:
        break;
    }
}