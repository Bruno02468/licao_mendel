/* JavaScript para o site de lições.
 * Escrito pelo Bruno Borges Paschoalinoto.
 * Altas programações :-)
 */


function ir() {
    var sala = document.getElementById("sala").value;
    location.href = "http://bruno02468.com/licao?sala=" + sala;
}

function ajaxGet(url) {
    var request = null;
    request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

function vlw() {
    document.getElementById("vlw").innerHTML = ajaxGet("http://bruno02468.com/licao/conta.php");
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