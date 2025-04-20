/**
 * Sources:
 * https://raw.githack.com/MrRio/jsPDF/master/docs/index.html
 * https://raw.githack.com/MrRio/jsPDF/master/index.html
 * https://stackoverflow.com/questions/17739816/how-to-open-generated-pdf-using-jspdf-in-new-window
 */

async function deleteMonster(ID) {
    let container = document.getElementById("monsterContainer" + ID);
    container.classList.add("d-none");

    let response = await fetch("http://localhost:8080/monster-api.php?command=delete&monster_id=" + ID);
    // let response = await fetch("https://cs4640.cs.virginia.edu/sem9bd/monster-api.php?command=delete&monster_id=" + ID);

    if (response.ok) {
        container.remove();
    }
    else {
        createAlert("danger", "Server Error: Unable to delete the requested monster.")
        container.classList.remove("d-none");
    }
}

function createAlert(type, message) {
    document.getElementById("alerts").appendChild(createElement(
        "<div class=\"alert alert-" + type + " alert-dismissible\" role=\"alert\">\
            <div>" + message + "</div>\
        <button type =\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>\
        </div>\n"
    ));
}

function createElement(htmlFragment) {
    var fragment = document.createDocumentFragment();

    var element = document.createElement('div');
    element.innerHTML = htmlFragment;

    while (element.childNodes[0]) {
        fragment.appendChild(element.childNodes[0]);
    }
    return fragment;
}


const width = 210;
const height = 297;
const border = 20;

function split(item, items) {
    return Math.round((width - (2 * border)) * (2 * item - 1) / (items * 2)) + border;
}

function maximumSpeed(speeds) {
    if (!speeds) return 0;

    let maximum = 0;
    for (speed of speeds) {
        if (Number(speed["range"]) > maximum)
            maximum = Number(speed["range"]);
    }
    return maximum;
}

async function printMonsterSummary(ID) {
    // <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.0/jspdf.umd.min.js"></script>
    response = new Promise(resolve => {
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "http://localhost:8080/monster-api.php?command=viwe&format=json&monster_id=" + ID, true);
        // ajax.open("GET", "https://cs4640.cs.virginia.edu/sem9bd/monster-api.php?command=viwe&format=json&monster_id=" + ID, true);
        ajax.responseType = "json";
        ajax.send(null);

        ajax.addEventListener("load", function () {
            if (this.status == 200) {
                resolve(this.response);
            } else {
                console.log("When trying to get a new word, the server returned an HTTP error code.");
            }
        });

        ajax.addEventListener("error", function () {
            console.log("When trying to get a new word, the connection to the server failed.");
        });
    });

    let data = await response;

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF().setProperties({ title: data["name"] + ".pdf"});

    let y = 25;

    let i = 1;
    let maxY = y;

    doc.setFont("times", "bold");
    doc.setFontSize(40);
    doc.text(data["name"], width / 2, y, null, null, "center");

    y += 10;
    doc.setFont("times", "normal");
    doc.setFontSize(15);
    doc.text(data["size"] + " " + data["type"] + ", " + data["alignment"], width / 2, y, null, null, "center");

    y += 5;
    doc.line(border, y, width - border, y);

    y += 10;
    doc.setFontSize(20);
    doc.text("Armor Class", split(1, 3), y, null, null, "center");
    doc.text("Hitpoints", split(2, 3), y, null, null, "center");
    doc.text("Speed", split(3, 3), y, null, null, "center");

    y += 8;
    doc.setFontSize(15);
    doc.text(data["armor_class"], split(1, 3), y, null, null, "center");
    doc.text(data["health"], split(2, 3), y, null, null, "center");
    doc.text(String(maximumSpeed(data["speed"])) + " ft.", split(3, 3), y, null, null, "center");

    y += 5;
    doc.line(border, y, width - border, y);

    y += 10;
    doc.setFontSize(20);
    doc.text("STR", split(1, 6), y, null, null, "center");
    doc.text("DEX", split(2, 6), y, null, null, "center");
    doc.text("CON", split(3, 6), y, null, null, "center");
    doc.text("INT", split(4, 6), y, null, null, "center");
    doc.text("WIS", split(5, 6), y, null, null, "center");
    doc.text("CHA", split(6, 6), y, null, null, "center");

    y += 8;
    doc.setFontSize(15);
    doc.text(data["strength_modifier"], split(1, 6), y, null, null, "center");
    doc.text(data["dexterity_modifier"], split(2, 6), y, null, null, "center");
    doc.text(data["constitution_modifier"], split(3, 6), y, null, null, "center");
    doc.text(data["intelligence_modifier"], split(4, 6), y, null, null, "center");
    doc.text(data["wisdom_modifier"], split(5, 6), y, null, null, "center");
    doc.text(data["charisma_modifier"], split(6, 6), y, null, null, "center");

    y += 5;
    doc.line(border, y, width - border, y);

    y += 10;
    doc.text("Vulnerabilities", split(1, 3), y, null, null, "center");
    doc.text("Resistances", split(2, 3), y, null, null, "center");
    doc.text("Immunities", split(3, 3), y, null, null, "center");

    y += 5;
    doc.setFontSize(10);

    maxY = y;
    i = 1;
    for (type of ["damageVulnerability", "damageResistance", "damageImmunity"]) {
        let subY = y;

        if (data[type]) {
            for (item of data[type]) {
                doc.text(item["name"], split(i, 3), subY, null, null, "center");
                subY += 4;
            }
        }

        if (maxY < subY) maxY = subY;
        i += 1;
    }
    y = maxY;

    y += 10;
    doc.setFontSize(15);
    doc.text("Proficiencies", split(1, 3), y, null, null, "center");
    doc.text("Expertises", split(2, 3), y, null, null, "center");
    doc.text("Condition Immunities", split(3, 3), y, null, null, "center");

    y += 5;
    doc.setFontSize(10);

    i = 1;
    maxY = y;
    for (type of ["skillProficiency", "skillExpertise", "conditionImmunity"]) {
        let subY = y;

        if (data[type]) {
            for (item of data[type]) {
                doc.text(item["name"], split(i, 3), subY, null, null, "center");
                subY += 4;
            }
        }

        if (maxY < subY) maxY = subY;
        i += 1;
    }
    y = maxY;

    y += 5;
    doc.line(border, y, width - border, y);

    y += 10;
    doc.setFontSize(15);
    doc.text("Abilities", split(1, 4), y, null, null, "center");
    doc.text("Actions", split(2, 4), y, null, null, "center");
    doc.text("Bonus Actions", split(3, 4), y, null, null, "center");
    doc.text("Reactions", split(4, 4), y, null, null, "center");

    y += 5;
    doc.setFontSize(10);

    i = 1;
    maxY = y;
    for (type of ["ability", "action", "bonusAction", "reaction"]) {
        let subY = y;

        if (data[type]) {
            for (item of data[type]) {
                doc.text(item["name"], split(i, 4), subY, null, null, "center");
                subY += 4;
            }
        }

        if (maxY < subY) maxY = subY;
        i += 1;
    }
    y = maxY;

    y += 5;
    doc.line(border, y, width - border, y);

    y += 10;
    doc.setFontSize(20);
    doc.text("Challenge Rating", split(1, 1), y, null, null, "center");

    y += 8;
    doc.setFontSize(15);
    doc.text(data["challenge"], split(1, 1), y, null, null, "center");


    doc.output('dataurlnewwindow', data["name"] + ".pdf");
}