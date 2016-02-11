<?php

// Usar a timezone daqui.
date_default_timezone_set("America/Sao_Paulo");

// Executa um redirecionamento relativo à URL atual.
function redir($relative) {
    $host  = $_SERVER["HTTP_HOST"];
    $uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/$relative");
}

function jsredir($relative) {
    die("<script>location.href = \"$relative\";</script>");
}

// Traduz dias da semana... -_-'
function semana($dia) {
    switch ($dia) {
        case "Sunday":
            return "domingo";
        case "Monday":
            return "segunda";
        case "Tuesday":
            return "terça";
        case "Wednesday":
            return "quarta";
        case "Thursday":
            return "quinta";
        case "Friday":
            return "sexta";
        case "Saturday":
            return "sábado";
        default:
            return "<i>erro de dia da semana, por favor contatar borginhos</i>";
    }
}

// Formata uma array de linhas.
function formatar_array($arr) {
    foreach ($arr as $key => $line)
        $arr[$key] = formatar($line);
    return implode("<br>" , $arr);
}

// Substicuição global em uma string.
function substituir_global($padrao, $subst, $texto) {
    while (preg_match($padrao, $texto))
        $texto = preg_replace($padrao, $subst, $texto);
    return $texto;
}

// Formata uma string.
function formatar($texto) {
    $not_bracket = "[^\]]";
    $linkreg = "/\[($not_bracket+)\|($not_bracket+)\]/";
    $linkrep = "<a target=\"_blank\" href=\"$1\">$2</a>";
    $nbspreg = "/^ +/";
    $nbsprep = "&nbsp;";
    $imgreg = "/\[imagem:($not_bracket+)\]/";
    $imgrep = "<a target=\"_blank\" title=\"Clique para ver o tamanho completo.\" href=\"$1\"><img src=\"$1\"></a>";
    $h4reg = "/\[big\]/";
    $h4rep = "<div class=\"big\">";
    $hcreg = "/\[\/big\]/";
    $hcrep = "</div>";
    $colorreg = "/\[cor:($not_bracket+)\]/";
    $colorrep = "<span style=\"color: $1;\">";
    $endcolorreg = "/\[\/cor\]/";
    $endcolorrep = "</span>";
    $fourreg = "/    /";
    $fourrep = "&nbsp;&nbsp;&nbsp;&nbsp;";
    $tags = "table|tr|td|sub|sup|b|i|u|s|code|br|hr";
    $tagreg = "/\[(($tags)|(\/($tags)))\]/";
    $tagrep = "<$1>";
    $tablereg = "/<table>/";
    $tablerep = "<table class=\"entrada\">";

    $texto = htmlspecialchars($texto);
    $texto = substituir_global("/\{l\}/", "ℓ", $texto);
    $texto = substituir_global("/\{g\}/", "[sup]↗[/sup]", $texto);
    $texto = substituir_global($fourreg, $fourrep, $texto);
    $texto = substituir_global($linkreg, $linkrep, $texto);
    $texto = substituir_global($nbspreg, $nbsprep, $texto);
    $texto = substituir_global($imgreg, $imgrep, $texto);
    $texto = substituir_global($h4reg, $h4rep, $texto);
    $texto = substituir_global($hcreg, $hcrep, $texto);
    $texto = substituir_global($colorreg, $colorrep, $texto);
    $texto = substituir_global($endcolorreg, $endcolorrep, $texto);
    $texto = substituir_global($tagreg, $tagrep, $texto);
    $texto = substituir_global($tablereg, $tablerep, $texto);

    return $texto;
}

// Exige uma variável GET 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_get($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

function currentDir() {
    return realpath(dirname(__FILE__)) . "/";
}

// Exige uma variável POST 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_post($str) {
    if (!isset($_POST[$str])) {
        die("Variável POST \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_POST[$str];
    }
}

function getFullJSON() {
    return json_decode(file_get_contents(currentDir() . "database.json"), true);
}

function setNewJSON($new_json) {
    file_put_contents(currentDir() . "database.json", json_encode($new_json, JSON_HEX_TAG
    | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
}

function addSala($id, $opaque, $salt, $ademir) {
    $sala = array(
        "opaque" => $opaque,
        "salt" => $salt,
        "ademir" => $ademir,
        "horario" => array(),
        "licoes" => array()
    );
    $json = getFullJSON();
    $json[$id] = $sala;
    setNewJSON($json);
}

function rmSala($id) {
    $json = getFullJSON();
    unset($json[$id]);
    setNewJSON($json);
}

function nomeSala($id) {
    return $id[0] . "º " . $id[1];
}

function getProperty($sala, $name) {
    if (!getFullJSON()[$sala][$name]) error_log("error getting $sala :: $nome");
    return getFullJSON()[$sala][$name];
}

function setProperty($sala, $nome, $value) {
    $json = getFullJSON();
    $json[$sala][$nome] = $value;
    setNewJSON($json);
}

function salaExists($sala) {
    return array_key_exists($sala, getFullJSON());
}

function dataToDateTime($data) {
    $obj = new DateTime();
    $obj->setDate($data["ano"], $data["mes"], $data["dia"]);
    return $obj;
}

function timeToData($time) {
    return array(
        "dia" => date("j", $time),
        "mes" => date("n", $time),
        "ano" => date("Y", $time)
    );
}

function dataToTime($data) {
    return dataToDateTime($data)->getTimestamp();
}

function addDias($data, $add) {
    $obj = dataToDateTime($data);
    $obj->add(new DateInterval("P${add}D"));
    return array(
        "dia" => $obj->format("j"),
        "mes" => $obj->format("n"),
        "ano" => $obj->format("Y")
    );
}

function subDias($data, $sub) {
    $obj = dataToDateTime($data);
    $obj->sub(new DateInterval("P${add}D"));
    return array(
        "dia" => $obj->format("j"),
        "mes" => $obj->format("n"),
        "ano" => $obj->format("Y")
    );
}

function dataIgual($a, $b) {
    return $a["dia"] === $b["dia"]
        && $a["mes"] === $b["mes"]
        && $a["ano"] === $b["ano"];
}

function getIndexByGuid($sala, $guid) {
    $licoes = getProperty($sala, "licoes");
    foreach ($licoes as $index => $licao) {
        if ($licao["guid"] === $guid) return $index;
    }
}

function addLicao($sala, $materia, $prova, $para, $infos) {
    $json = getFullJSON();
    $licao = array(
        "materia" => $materia,
        "prova" => $prova,
        "para" => $para,
        "passada" => timeToData(time()),
        "info" => $infos,
        "guid" => make_guid(),
        "removed" => false
    );
    array_push($json[$sala]["licoes"], $licao);
    setNewJSON($json);
}

function editLicao($sala, $guid, $materia, $prova, $para, $infos) {
    $json = getFullJSON();
    $index = getIndexByGuid($sala, $guid);
    $licao = array(
        "materia" => $materia,
        "prova" => $prova,
        "para" => $para,
        "info" => $infos,
        "removed" => $json[$sala]["licoes"][$index]["removed"],
        "passada" => $json[$sala]["licoes"][$index]["passada"],
        "guid" => $json[$sala]["licoes"][$index]["guid"]
    );
    $json[$sala]["licoes"][$index] = $licao;
    setNewJSON($json);
}

function removeLicao($sala, $guid) {
    $json = getFullJSON();
    $json[$sala]["licoes"][getIndexByGuid($sala, $guid)]["removed"] = true;
    setNewJSON($json);
}

function hasHorario($sala) {
    return getProperty($sala, "horario") !== [];
}

// Gera um salt mais ou menos seguro.
function make_salt() {
    return uniqid(rand(), true);
}

function make_guid() {
    mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid =
         substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);
    return $uuid;
}

// Checa se um login consta no banco de dados.
function isright($user, $pass) {
    if (!salaExists($user) && $user !== "borginhos") return false;
    
    list($opaque, $salt) = file(currentDir() . ".supershadow");
    $opaque = trim($opaque);
    $salt = trim($salt);
    if ($user !== "borginhos") {
        $opaque = getProperty($user, "opaque");
        $salt = getProperty($user, "salt");
    }
    $newopaque = hash("sha512", "${pass}${salt}");
    return $opaque === $newopaque;
}

// Insere o header de login na resposta do servidor.
function headauth($msg) {
    header("WWW-Authenticate: Basic realm=\"$msg\"");
    header("HTTP/1.0 401 Unauthorized");
    echo $msg;
    die();
}

// Exige um certo login para a exibição da página.
// Se $wanted == "", aceita qualquer login menos "borginhos".
function require_login($wanted = "") {
    $username = null;
    $password = null;

    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $username = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
    }

    if (is_null($username)) {
        headauth("Voce precisa fazer login para continuar!");
    } else {
        if (!salaExists($username) && $username !== "borginhos") {
            headauth("Esse usuario nao existe!");
        }
        if (($username !== $wanted && $wanted != "") || ($username == "borginhos" && $wanted == ""))  {
            headauth("Esse login nao e o correto! Faca login!");
        }
        if (!isright($username, $password)) {
            headauth("Nome de senha incorreta!");
        }
    }
}

function getUser() {
    return $_SERVER["PHP_AUTH_USER"];
}

?>