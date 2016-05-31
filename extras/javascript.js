/* JavaScript para o site de lições.
 * Escrito pelo Bruno Borges Paschoalinoto.
 * Altas programações :-)
 */

function ajaxGet(url) {
    var request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

var hor = document.getElementById("hor");
var horlink = document.getElementById("horlink");
var showing = false;
function horario() {
    if (showing) {
        hor.style.display = "none";
        horlink.innerHTML = "Ver horário de aulas";
    } else {
        hor.style.display = "inline-block";
        horlink.innerHTML = "Esconder horário";
    }
    showing = !showing;
}

var hojes = document.getElementsByClassName("parahj");''
var hojespan = document.getElementById("hojeslink");
if (hojes.length > 0) {
    hojespan.innerHTML = "<br><a class=\"buttonlink lichj\" href=\"javascript:void(0)\" onclick=\"mostrarHoje(this)\">Lições para hoje ocultas; clique para ver.</a>";
}

function mostrarHoje(but) {
    for (i in hojes) {
        elem = hojes[i];
        if (elem.style) elem.setAttribute("style", "display: block;");
    }
    hojespan.innerHTML = "";
}

var feitas;
if (localStorage["feitas"] === undefined) {
    localStorage["feitas"] = "";
    feitas = [];
} else {
    feitas = localStorage["feitas"].split(",");
}

function toggleFeita(id) {
    var i = feitas.indexOf(id);
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

function escolherSala() {
    localStorage["sala"] = "";
    location.href = "..";
}

function deletar(guid) {
    if (confirm("Você deseja mesmo deletar essa lição?"))
        location.href = "../ademir/reqsala.php?sala=" + sala + "&ir=atuadores%2Fdeleta_licao.php%3Fguid%3D" + guid + "%26admvisao";
}

var admwarn = document.getElementById("admwarn");
var msgadd = document.getElementById("msgadm");
var addstyle = document.createElement("style");
if (localStorage["admvisao"] && localStorage["lastSalaADM"] === sala) {
    addstyle.innerHTML = ".entrada .admvisao { display: block !important; }";
    document.head.appendChild(addstyle);
    admwarn.style.display = "block";
    msgadm.style.display = "inline-block";
}

function desadm() {
    localStorage["admvisao"] = "";
    addstyle.innerHTML = ".admvisao { display: none !important; }";
    admwarn.style.display = "none";
    msgadm.style.display = "none";
}

if (window.localStorage) {
    localStorage["sala"] = sala;
}