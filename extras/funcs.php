<?php
// Arquivo comum para funções muito usadas.
// Escrito por Bruno Borges Paschoalinoto.

// Executa um redirecionamento relativo à URL atual.
function redir($relative) {
    $host  = $_SERVER["HTTP_HOST"];
    $uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/$relative");
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
    $texto = trim($texto);
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

// Exige uma variável POST 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_post($str) {
    if (!isset($_POST[$str])) {
        die("Variável POST \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_POST[$str];
    }
}

?>
