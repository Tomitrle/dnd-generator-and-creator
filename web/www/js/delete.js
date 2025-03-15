// Author: Brennen Muller

/**
 * SOURCES:
 * https://www.w3schools.com/jsref/met_element_remove.asp
 * https://stackoverflow.com/questions/16404327/how-to-pass-event-as-argument-to-an-inline-event-handler-in-javascript
 * https://stackoverflow.com/questions/5898656/check-if-an-element-contains-a-class-in-javascript
*/

function deleteSelf(event, self) {
    if (event.target.getAttribute('data-action') === "delete") {
        self.remove();
    }
}