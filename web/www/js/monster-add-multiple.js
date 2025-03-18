function updateChoices(self) {
    var name = self.getAttribute('data-name');
    var container = document.getElementById(name + "Container");

    for (var child of container.children) {
        // Get first descendant input
        var value = child.querySelector('input').value;
        var option = document.getElementById(name + value);
        if (option) option.remove();
    }
}