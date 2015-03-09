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