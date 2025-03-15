var armor = document.getElementById("armor");
var shield = document.getElementById("shield");
var dexterity = document.getElementById("dexterityModifier");
var armorClass = document.getElementById("armorClass");

// https://htmlcheatsheet.com/js/
// https://html.spec.whatwg.org/#embedding-custom-non-visible-data-with-the-data-*-attributes
// https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
// https://stackoverflow.com/questions/12328144/how-do-i-access-custom-html-attributes-in-javascript
function armorUpdate() {
    if (armor.value === "Natural Armor" || armor.value === "Other") {
        armorClass.disabled = false;
        return;    
    } 
    
    armorClass.disabled = true;
    var AC = Number(armor.options[armor.selectedIndex].getAttribute('data-ac'));
    
    if (shield.checked) AC += 2;
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

    armorClass.value = AC;
}

armor.oninput = function () {
    armorUpdate();
}

shield.oninput = function () {
    armorUpdate();
}
