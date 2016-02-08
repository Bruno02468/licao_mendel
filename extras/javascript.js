/* JavaScript para o site de lições.
 * Escrito pelo Bruno Borges Paschoalinoto.
 * Altas programações :-)
 */

console.log("confia no borginhos e para de ler o console javascript po");

function ajaxGet(url) {
    var request = null;
    request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

var hojes = document.getElementsByClassName("parahj");
var hojespan = document.getElementById("hojeslink");
if (hojes.length > 0) {
    for (i in hojes) {
        elem = hojes[i];
        if (elem.style) elem.style.display = "none";
    }
    hojespan.innerHTML = "<a href=\"javascript:void(0)\" onclick=\"mostrarHoje(this)\"><br>[Mostrar lições para hoje]</a>";
} else {

}
function mostrarHoje(but) {
    for (i in hojes) {
        elem = hojes[i];
        if (elem.style) elem.style.display = "";
    }
    but.style.display = "none";
}

var feitas = localStorage["feitas"].split(",");

function toggleFeita(id) {
    var i = feitas.indexOf(id);
    console.log("toogled " + id);
    if (i > -1)
        feitas.splice(i, 1);
    else
        feitas.push(id);
    localStorage["feitas"] = feitas.toString();
}

for (var index in feitas) {
    var id = feitas[index];
    var checkbox = document.getElementById(id);
    if (!checkbox) {
        toggleFeita(id);
        continue;
    }
    checkbox.checked = true;
}

function clearFeitas() {
    localStorage["feitas"] = "";
}

var hor = document.getElementById("hor");
function horario() {
    var got = ajaxGet("../extras/horario2html.php?sala=" + sala);
    if (hor.innerHTML == "") {
        hor.innerHTML = got;
    } else {
        hor.innerHTML = "";
    }
}

var link = document.getElementById("meulink");
if (location.href.indexOf("agenda") > -1) {
    link.innerHTML = "[Ver lições por ordem de entrega]";
    link.href = "index.php";
}