function updateChoices(self) {
    var category = self.getAttribute('data-category');
    var container = document.getElementById(category + "Container");

    for (var child of container.children) {
        var value = child.querySelector('input').value;
        var addOption = document.getElementById(category + value);
        if (addOption) addOption.setAttribute('display', 'none');
    }
}