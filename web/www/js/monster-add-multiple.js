function updateChoices(self) {
    var category = self.getAttribute('data-category');

    // Make all the options visible
    for (var child of document.getElementById(category + "AddContainer").children) {
        child.classList.remove('d-none');
        child.classList.add('d-flex');
    }

    // Disable the options that are already in the form
    for (var child of document.getElementById(category + "Container").children) {
        var addOption = document.getElementById(category + "Add" + child.querySelector('input').value);
        if (addOption !== null) {
            addOption.classList.remove('d-flex');
            addOption.classList.add('d-none');
        }
    }
}