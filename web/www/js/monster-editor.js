// Author: Brennen Muller

/**
 * SOURCES:
 * https://www.w3schools.com/jsref/met_element_remove.asp
 * https://stackoverflow.com/questions/16404327/how-to-pass-event-as-argument-to-an-inline-event-handler-in-javascript
 * https://stackoverflow.com/questions/5898656/check-if-an-element-contains-a-class-in-javascript
 * https://www.fwait.com/how-to-add-and-remove-readonly-attribute-in-javascript/
*/

// MARK: FORM VALIDATION
// https://getbootstrap.com/docs/5.0/forms/validation/
(function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

// MARK: DELETE SELF
function deleteSelf(event, self) {
    if (event.target.getAttribute('data-action') === "delete") {
        self.remove();
    }
}

function setupEventHandlers() {
    document.getElementById("dexterityScore").addEventListener("input", updateArmorClass);
    document.getElementById("constitutionScore").addEventListener("input", updateHealthPoints);
}

/**
 * MARK: ABILITY SCORES
 * Converts and updates ability modifiers into ability scores.
 * Automatic updates are handled with EventListeners.
 */
function modifier(score) {
    return Math.floor((Number(score) - 10) / 2);
}

function updateAbilityModifier(event) {
    let abilityModifier = document.getElementById(event.target.id.replace("Score", "Modifier"))
    let abilityModifierLabel = document.getElementById(event.target.id.replace("Score", "ModifierLabel"));
    let value = modifier(event.target.value);
    abilityModifier.value = value;
    abilityModifierLabel.innerHTML = String(value);
}

/**
 * MARK: AC & HP
 * Updates armor class and hitpoints automatically.
 * Enables and disables fields as needed.
 *
 * Sources:
 * https://html.spec.whatwg.org/#embedding-custom-non-visible-data-with-the-data-*-attributes
 * https://stackoverflow.com/questions/1085801/get-selected-value-in-dropdown-list-using-javascript
 * https://stackoverflow.com/questions/12328144/how-do-i-access-custom-html-attributes-in-javascript
 */

function updateArmorClass() {
    let armor = document.getElementById("armor");
    let shield = document.getElementById("shield");
    let armorClass = document.getElementById("armorClass");

    let dexterity = document.getElementById("dexterityScore");

    /**
     * Enables and disables element(s) as necessary.
     * The automatic update is not performed when the user has selected manual entry.
     */
    if (armor.value === "Natural Armor" || armor.value === "Other") {
        armorClass.removeAttribute("readonly");
        return;
    }
    armorClass.setAttribute("readonly", true);

    /**
     * Calculates the update to the monster's armor class
     */
    let AC = Number(armor.options[armor.selectedIndex].getAttribute('data-ac'));

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

function updateHealthPoints() {
    let size = document.getElementById("size");
    let hitDice = document.getElementById("hitDice");
    let customHP = document.getElementById("customHP");
    let health = document.getElementById("health");

    let constitution = document.getElementById("constitutionScore");

    if (customHP.checked) {
        health.removeAttribute("readonly");
        hitDice.setAttribute("readonly", true);
        return;
    }
    health.setAttribute("readonly", true);
    hitDice.removeAttribute("readonly", true);

    let HP = Number(modifier(constitution.value));

    switch (size.value) {
        case "Tiny": // d4
            HP += 2.5 * Number(hitDice.value);
            break;

        case "Small": // d6
            HP += 3.5 * Number(hitDice.value);
            break;

        case "Medium": // d8
            HP += 4.5 * Number(hitDice.value);
            break;

        case "Large": // d10
            HP += 5.5 * Number(hitDice.value);
            break;

        case "Huge": // d12
            HP += 6.5 * Number(hitDice.value);
            break;

        case "Gargantuan": // d20
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

// MARK: BENEFIT SLIDER
// https://stackoverflow.com/questions/62707474/how-to-assign-labels-on-a-range-slider
function updateSliderLabel(event) {
    let label = document.getElementById(event.target.id.replace("Benefit", "BenefitLabel"));

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

// MARK: TOGGLE LEGENDARY
// https://stackoverflow.com/questions/26325278/how-can-i-get-all-descendant-elements-for-parent-container
function legendaryToggle() {
    let legendaryBlock = document.getElementById("legendaryBlock");
    let legendaryCheckbox = document.getElementById("legendaryCheckbox");

    let inputs = legendaryBlock.querySelectorAll("input, textarea");

    if (legendaryCheckbox.checked) {
        legendaryBlock.style.display = 'block';
        for (input of inputs) {
            input.setAttribute("aria-required", "true");
            input.setAttribute("aria-disabled", "false");
            input.required = true;
            input.disabled = false;
        }
        return;
    }

    legendaryBlock.style.display = 'none';
    for (input of inputs) {
        input.setAttribute("aria-required", "false");
        input.setAttribute("aria-disabled", "true");
        input.required = false;
        input.disabled = true;
    }
}

// MARK: UPDATE ATTRIBUTES
function updateAttributeChoices(self) {
    const category = self.getAttribute('data-category');

    // Make all the options visible
    for (let attributeChoice of document.getElementById(category + "AddContainer").children) {
        showChoice(attributeChoice);
    }

    // Disable the options that are already in the form
    for (let selectedAttribute of document.getElementById(category + "Container").children) {
        let attributeChoice = document.getElementById(category + "Add" + selectedAttribute.querySelector('input').value.replace(" ", ""));
        hideChoice(attributeChoice);
    }
}

// https://stackoverflow.com/questions/195951/how-can-i-change-an-elements-class-with-javascript
function showChoice(choice) {
    if (choice !== null) {
        choice.classList.remove('d-none');
        choice.classList.add('d-flex');
    }
}

function hideChoice(choice) {
    if (choice !== null) {
        choice.classList.remove('d-flex');
        choice.classList.add('d-none');
    }
}

function addSelectedAttribute(self) {
    const category = self.getAttribute('data-category');
    const attributeName = self.getAttribute('data-attribute');
    const ID = uniqueID();

    let selectedAttribute;

    switch (category) {
        case "speed":
            // speed.php
            selectedAttribute = createElement(
                "<div class=\"row\" onclick=\"deleteSelf(event, this)\">\
                    <div class= \"col-sm-2 mb-1 d-flex justify-content-sm-center align-items-center text-center\" >\
                        <label class=\"form-label\" for=\"" + category + ID + "\" style=\"margin-bottom:0;\">" + attributeName + "</label>\
                    </div>\
                    <div class=\"col-sm-9 col-11 mb-1 d-flex justify-content-sm-center align-items-center\">\
                        <input id=\"" + category + "Name" + ID + "\" name=\"" + category + "[name][]\" type=\"hidden\" value=\"" + attributeName + "\">\
                        <input id=\"" + category + "Range" + ID + "\" name=\"" + category + "[range][]\" class=\"form-control\" type=\"number\" min=\"0\" step=\"5\" placeholder=\"0 ft\" aria-required=\"true\" required>\
                    </div>\
                    <div class=\"col-1 mb-1 d-flex justify-content-start align-items-center gx-0\">\
                        <button type=\"button\" class=\"btn-close\" aria-label=\"Delete\" data-action=\"delete\"></button>\
                    </div>\
                </div>"
            );

            hideChoice(document.getElementById(category + "Add" + attributeName.replace(" ", "")));
            break;

        case "sense":
            // sense.php
            selectedAttribute = createElement(
                "<div class=\"row mb-1\" onclick=\"deleteSelf(event, this)\">\
                    <div class= \"col-6 d-flex align-items-center text-wrap text-break\">\
                        <label class=\"form-label\" for=\"senseName" + category + "Name" + ID + "\" style=\"margin-bottom: 0;\">" + attributeName + "</label>\
                    </div>\
                    <div class=\"col-5 text-wrap text-break\">\
                        <input id=\"" + category + "Name" + ID + "\" name=\"" + category + "[name][]\" type=\"hidden\" value=\"" + attributeName + "\">\
                        <input id=\""  + category + "Range" + ID + "\" name=\"" + category + "[range][]\" class=\"form-control\" type=\"number\" min=\"0\" max=\"1000\" step=\"5\" placeholder=\"0 ft\" aria-required=\"true\" required>\
                    </div>\
                    <div class=\"col-1 gx-0 d-flex align-items-center\">\
                        <button type=\"button\" class=\"btn-close\" aria-label=\"Delete\" data-action=\"delete\"></button>\
                    </div>\
                </div>"
            );

            hideChoice(document.getElementById(category + "Add" + attributeName.replace(" ", "")));
            break;

        case "ability":
        case "action":
        case "bonusAction":
        case "reaction":
        case "legendaryFeature":
            // ability.php
            selectedAttribute = createElement(
                "<div class=\"col-sm-6 col-lg-4\" onclick=\"deleteSelf(event, this)\">\
                    <div class=\"row mb-1\">\
                        <label class=\"form-label\" for=\"" + category + "Name" + ID + "\">Name</label>\
                        <div class=\"col-10\">\
                            <input id=\"" + category + "Name" + ID + "\" name=\"" + category + "[name][]\" class=\"form-control\" type=\"text\" pattern=\"[\\w\\s]+\" value=\"" + attributeName + "\" aria-required=\"true\" required>\
                        </div>\
                        <div class=\"col-2 gx-0 d-flex align-items-center justify-content-center\">\
                            <button type=\"button\" class=\"btn-close\" aria-label=\"Delete\" data-action=\"delete\"></button>\
                        </div>\
                    </div>\
                    <label class=\"form-label\" for=\"" + category + "Description" + ID + "\">Description</label>\
                    <textarea id=\"" + category + "Description" + ID + "\" name=\"" + category + "[description][]\" class=\"form-control\" rows=\"5\" aria-required=\"true\" required></textarea>\
                    <label class=\"form-label\" for=\"" + category + "Benefit" + ID + "\">Power Level:</label><strong id=\"" + category + "BenefitLabel" + ID + "\" class=\"ms-1\">Neutral</strong>\
                    <input id=\"" + category + "Benefit" + ID + "\" name=\"" + category + "[benefit][]\" class=\"form-range\" type=\"range\" min=\"-1\" max=\"2\" value=\"0\" oninput=\"updateSliderLabel(event)\">\
                </div>"
            );
            break;

        default:
            // basic.php
            selectedAttribute = createElement(
                "<div class=\"row mb-1\" onclick=\"deleteSelf(event, this)\">\
                    <input id=\"" + category + "Name" + ID + "\" name=\"" + category + "[name][]\" type=\"hidden\" value=\"" + attributeName + "\">\
                    <div class= \"col-11 d-flex align-items-center text-wrap text-break\">\
                        <label class=\"form-label\" for=\"senseName" + category + "Name" + ID + "\" style=\"margin-bottom: 0;\">" + attributeName + "</label>\
                    </div>\
                    <div class=\"col-1 gx-0 d-flex align-items-center\">\
                        <button type=\"button\" class=\"btn-close\" aria-label=\"Delete\" data-action=\"delete\"></button>\
                    </div>\
                </div>"
            );

            hideChoice(document.getElementById(category + "Add" + attributeName.replace(" ", "")));
            break;
    }

    document.getElementById(category + "Container").appendChild(selectedAttribute);
}

function uniqueID() {
    return document.getElementById("IDCounter").value++;
}

function createElement(htmlFragment) {
    let fragment = document.createDocumentFragment();

    let element = document.createElement('div');
    element.innerHTML = htmlFragment;

    while (element.childNodes[0]) {
        fragment.appendChild(element.childNodes[0]);
    }
    return fragment;
}

// MARK: UPDATE CR
// TODO: Implement automatic CR updates