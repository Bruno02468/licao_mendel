<?php

function timeToData($time) {
    return array(
        "dia" => date("j", $time),
        "mes" => date("n", $time),
        "ano" => date("Y", $time)
    );
}

$arr = array();

foreach (scandir("salas/") as $pasta) {
    $id = basename($pasta);
    if ($id[0] === ".") continue;
    $sala = array("horario" => array(), "licoes" => array());
    foreach (file("shadow") as $line) {
        list($rightuser, $hashed, $salt) = explode("§", $line);
        if ($rightuser !== $id) continue;
        $salt = trim($salt);
        $sala["opaque"] = $hashed;
        $sala["salt"] = $salt;
    }
    foreach (file("ademires.txt") as $line) {
        list($salaid, $nomeadm) = explode(":", $line);
        $nomeadm = trim($nomeadm);
        if ($salaid === $id) {
            $sala["ademir"] = trim($nomeadm);
        }
    }
    if (file_exists("./hors/$id.horario")) {
        foreach (file("./hors/$id.horario") as $line) {
            array_push($sala["horario"], trim(str_replace(";", "", $line)));
        }
    }
    foreach (glob("./salas/$id/*") as $full) {
        $licao = array();
        // Testar o nome base do arquivo para pular arquivos padrão.
        $file = basename($full);
        if ("." === basename($full)[0]) continue;
        // Array com as linhas do arquivo.
        $arquivo = file($full);
        // Ler a data de entrega do arquivo.
        $licao["para"] = timeToData(strtotime(trim($arquivo[1])));
        if (!isset($arquivo[1])) {
            error_log("faltou no $full");
        }
        // Ver se é prova...
        $licao["prova"] = false;
        // A matéria a ser mostrada.
        $licao["materia"] = trim($arquivo[0]);
        // Ler as informações e formatá-las.
        unset($arquivo[0]);
        unset($arquivo[1]);
        $licao["info"] = implode($arquivo, "");
        // Ler a data de criação.
        $licao["passada"] = timeToData(filectime($full));
        // Adicionar nossa lição à array.
        array_push($sala["licoes"], $licao);
    }
    $arr[$id] = $sala;
}

file_put_contents("database.json", json_encode($arr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

?>