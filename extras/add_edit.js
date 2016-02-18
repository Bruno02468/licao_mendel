var calendario = document.getElementById("calendario");
var materia = document.getElementById("materia");

function setDataMat(mat, dia) {
    materia.value = mat;
    document.getElementById("dialink-" + dia).onclick();
}