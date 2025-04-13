async function deleteMonster(ID) {
    let container = document.getElementById("monsterContainer" + ID);
    container.classList.add("d-none");

    let response = await fetch("http://localhost:8080/monster-api.php?command=delete&monster_id=" + ID);
    console.log(response);

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