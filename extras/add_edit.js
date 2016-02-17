var dia = document.getElementById("dia");
var mes = document.getElementById("mes");
var ano = document.getElementById("ano");
var hor = document.getElementById("hor");
var horlink = document.getElementById("horlink");

var showing = false;
function horario() {
    if (showing) {
        hor.style.display = "none";
        horlink.innerHTML = "[Ver horário de aulas]";
    } else {
        hor.style.display = "inline-block";
        horlink.innerHTML = "[Esconder horário]";
    }
    showing = !showing;
}

function setData(string) {
    var arr = string.split("/");
    dia.value = arr[0];
    mes.value = arr[1];
}