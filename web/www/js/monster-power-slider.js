// https://stackoverflow.com/questions/62707474/how-to-assign-labels-on-a-range-slider

var slider = document.getElementById("range");
var display = document.getElementById("display");
var getVal = slider.value;

slider.oninput = function () {
    switch (this.value) {
        case "-1":
            display.innerHTML = "Detrimental";
            break;
        case "0":
            display.innerHTML = "Neutral";
            break;
        case "1":
            display.innerHTML = "Beneficial";
            break;
        case "2":
            display.innerHTML = "Powerful";
            break;
        default:
            break;
    }
}