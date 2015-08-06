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
    document.getElementById("vlw").innerHTML = ajaxGet(conta.php);
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

var feito;
if (document.cookie.indexOf("feito") < -1) {
    document.cookie = "feito=; path=/licao;";
} else {
    feito = getCookie("feito");
    var n = feito.split(",");
    for (c in n) {
        var id = n[c];
        if (!id)
            continue;
        var check = document.getElementById(id);
        if (!check) {
            toggleFeita(id);
            continue;
        }
        check.checked = true;
    }
}

function toggleFeita(id) {
    if (getCookie("feito").indexOf("," + id) > -1) {
        document.cookie = document.cookie.replace("," + id, "");
    } else {
        document.cookie = "feito=" + getCookie("feito") + "," + id + "; path=/licao;";
    }
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
