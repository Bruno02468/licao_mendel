// Tudo programado por Bruno Borges Paschoalinoto!

// Vai conter o banco de dados do site na forma JSON.
var banco = null;

// Baixa o banco de dados na variável window.banco.
function baixarBanco() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            window.banco = JSON.parse(request.responseText);
        }
    };
    request.open("GET", "../extras/database.json", false);
    request.send(null);
}

// Objetos tirados do document ficam aqui.
var in_sala = document.getElementById("b_sala");
var in_materia = document.getElementById("b_materia");
var in_data_min = document.getElementById("b_data_min");
var in_data_max = document.getElementById("b_data_max");
var in_data_para = document.getElementById("b_data_para");
var txtresult = document.getElementById("txtresult");

// Determinar valores sãos para os limites de datas nas entradas.
var ano = new Date().getFullYear();
in_data_min.value = ano + "-01-01";
in_data_max.value = ano + "-12-31";

// Converte uma array de lições num texto bem bonitinho.
var dotsy = "----------------------------------------------------------------";
function licao_to_txt(arr) {
    var result = "Foram encontradas " + arr.length + " lições correspondentes:\n\n";
    for (var i in arr) {
        if (!arr.hasOwnProperty(i)) continue;
        result += dotsy + "\nMatéria: " + arr[i].materia
            + "\nPassada em: " + arr[i].passada.dia + "/" + arr[i].passada.mes + "/" + arr[i].passada.ano
            + "\n\n" + arr[i].info.replace(/\[[^\]]+\]/g, "") + "\n"+ dotsy + "\n\n";
    }
    return result;
}

// Converte uma array de lições nas tabelas usualmente vistas no site.
function licao_to_tables(arr) {
    var result = "Foram encontradas <b>" + arr.length + "</b> lições correspondentes:<br><br>";
    for (var i in arr) {
        if (!arr.hasOwnProperty(i)) continue;
        result += "<table class=\"entrada\">"
            + "<tr><td>Matéria:</td><td>" + arr[i]["materia"] + "</td></tr>"
            + "<tr><td>Passada em:</td><td>" + arr[i]["passada"]["dia"] + "/" + arr[i]["passada"]["mes"] + "/" + arr[i]["passada"]["ano"] + "</td></tr>"
            + "<tr><td>Para:</td><td>" + arr[i]["para"]["dia"] + "/" + arr[i]["para"]["mes"] + "/" + arr[i]["para"]["ano"] + "</td></tr>"
            + "<tr><td>Informações:<td>" + arr[i].info.replace(/\[[^\]]+\]/g, "").replace(/\n/g, "<br>") + "</td></tr>"
            + "</table>";
    }
    return result;
}


// Função por trás das restrições impostas pelo usuário.
function iniciarBusca(txtformat) {
    // Baixar o banco caso necessário.
    if (banco == null) baixarBanco();
    
    // Recebe os últimos valores digitados nos campos.
    var sala = in_sala.value;
    var materia = in_materia.value.toLowerCase();
    var data_min = new Date(in_data_min.value).getTime();
    var data_max = new Date(in_data_max.value).getTime();
    var data_para = in_data_para.value;
    
    // Lições do universo de pesquisa -- serão mais restritas depois.
    var licoes = [];
    
    // Restringir por sala -- ou não.
    if (sala !== "" && banco.hasOwnProperty(sala)) {
        licoes = banco[sala]["licoes"];
    } else {
        for (var index in banco) {
            if (!banco.hasOwnProperty(index)) continue;
            licoes = licoes.concat(banco[index]["licoes"]);
        }
    }
    console.log(licoes);
    
    // Limpar lições inválidas.
    var newlicoes = [];
    for (var index in licoes) {
        if (!licoes.hasOwnProperty(index)) continue;
        if (!licoes[index].hasOwnProperty("materia")) continue;
        newlicoes.push(licoes[index]);
    }
    licoes = newlicoes;
    newlicoes = undefined;
    
    // Restringir por matéria -- ou não.
    if (materia !== "") {
        var newlicoes = [];
        for (var index in licoes) {
            if (!licoes.hasOwnProperty(index)) continue;
            if (licoes[index]["materia"].toLowerCase().indexOf(materia) > -1) {
                newlicoes.push(licoes[index]);
            }
        }
        licoes = newlicoes;
    }
    
    // Restringir por data passada.
    var newlicoes = [];
    for (var index in licoes) {
        if (!licoes.hasOwnProperty(index)) continue;
        var passada = new Date(licoes[index].passada.ano + "-" + licoes[index].passada.mes + "-" + licoes[index].passada.dia);
        if (passada.getTime() >= data_min && passada <= data_max) {
            newlicoes.push(licoes[index]);
        }
    }
    licoes = newlicoes;
    newlicoes = undefined;
    
    // Restringir por data de entrega -- ou não.
    if (data_para !== "") {
        var newlicoes = [];
        for (var index in licoes) {
            if (!licoes.hasOwnProperty(index)) continue;
            var para = licoes[index].para.ano + "-" + licoes[index].para.mes + "-" + licoes[index].para.dia;
            if (para == data_para) {
                newlicoes.push(licoes[index]);
            }
        }
        licoes = newlicoes;
    }
    
    console.log(licoes);
    
    // Hora de colocar esses dados em ordem.
    if (txtformat) {
        txtresult.innerHTML = "<textarea style=\"width: 100%; height: 350px;\">" + licao_to_txt(licoes) + "</textarea>";
    } else {
        txtresult.innerHTML = licao_to_tables(licoes);
    }
    
}