function createAlert(type, message) {
    let alerts = document.getElementById("alerts");
    if (alerts === null) {
        console.log("Could not generate an alert because no element 'alerts' was found.");
        return;
    }

    alerts.appendChild(createElement(
        "<div class=\"alert alert-" + type + " alert-dismissible\" role=\"alert\">\
            <div>" + message + "</div>\
        <button type =\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>\
        </div>\n"
    ));
}

// https://stackoverflow.com/questions/3662821/how-to-correctly-use-innerhtml-to-create-an-element-with-possible-children-fro
function createElement(htmlFragment) {
    var fragment = document.createDocumentFragment();

    var element = document.createElement('div');
    element.innerHTML = htmlFragment;

    while (element.childNodes[0]) {
        fragment.appendChild(element.childNodes[0]);
    }
    return fragment;
}