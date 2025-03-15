// Author: Brennen Muller

function deleteSelf(event, self) {
    if (event.target.getAttribute('data-action') === "delete") {
        self.remove();
    }
}