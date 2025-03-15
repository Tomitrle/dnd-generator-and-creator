// Author: Brennen Muller

var armor = document.getElementById("armor");
var shield = document.getElementById("shield");
var armorClass = document.getElementById("armorClass");

var dexterity = document.getElementById("dexterityModifier");

// https://htmlcheatsheet.com/js/
// https://html.spec.whatwg.org/#embedding-custom-non-visible-data-with-the-data-*-attributes
// https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
// https://stackoverflow.com/questions/12328144/how-do-i-access-custom-html-attributes-in-javascript
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
            AC += Number(dexterity.innerHTML);
            break;

        case "medium":
            AC += Math.min(Number(dexterity.innerHTML), 2);
            break;

        case "heavy":
            break;

        default:
            break;
    }

    if (shield.checked) AC += 2;

    armorClass.value = AC;
}

armor.onchange = function () {updateArmorClass();}
shield.onchange = function () {updateArmorClass();}

// SHOULD ALSO UPDATE ON DEXTERITY CHANGE