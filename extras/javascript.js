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

function vlw() {
    document.getElementById("vlw").innerHTML = ajaxGet("conta.php");
}

var feitas;
eval("feitas = [" + (localStorage["feitas"] || "") + "];");


function toggleFeita(id) {
    id = parseInt(id);
    var i = feitas.indexOf(id);
    if (i > -1)
        feitas.splice(i, 1);
    else
        feitas.push(parseInt(id));
    localStorage["feitas"] = feitas.toString();
}

for (var index in feitas) {
    var id = parseInt(feitas[index]);
    var checkbox = document.getElementById(id);
    if (!checkbox) {
        toggleFeita(id);
        continue;
    }
    checkbox.checked = true;
}

function horario() {
    var hor = document.getElementById("hor");
    var img = "<img class='horario' src='horario.png' alt='Horário do 1º E'><br>";
    if (hor.innerHTML == "") {
        hor.innerHTML = img;
    } else {
        hor.innerHTML = "";
    }
}

function brasil() {
    var hue = document.getElementById("hue");
    hue.play();
}

var link = document.getElementById("meulink");
if (location.href.indexOf("agenda") > -1) {
    link.innerHTML = "[Ver lições por ordem de entrega]";
    link.href = "index.php";
}
