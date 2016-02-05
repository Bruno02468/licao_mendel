<?php
// Gerencia funções de login. Substitui o login único HTTP: Basic de antes.
// Escrito por Bruno Borges Paschoalinoto.

// Gera um salt mais ou menos seguro.
function make_salt() {
    return uniqid("", true);
}

// Gera uma linha para o shadowfile com salt aleatório.
function makeshadow($user, $pass) {
    $salt = make_salt();
    $hashed = hash("sha512", "$pass:$salt");
    return "${user}§${hashed}§${salt}";
}

// Checa se um login consta no banco de dados.
function isright($user, $pass) {
    $shadowfile = dirname(__FILE__) . "/.shadow";
    $lines = file($shadowfile);
    foreach ($lines as $line) {
        list($rightuser, $hashed, $salt) = explode("§", $line);
        $salt = trim($salt);
        if ($user !== $rightuser) continue;
        $tryhash = hash("sha512", "$pass:$salt");
        if ($hashed !== $tryhash) break;
        return true;
    }
    return false;
}

// Insere o header de login na resposta do servidor.
function headauth($msg) {
    header("WWW-Authenticate: Basic realm=\"$msg\"");
    header("HTTP/1.0 401 Unauthorized");
    echo $msg;
    die();
}

// Exige um certo login para a exibição da página.
// Se $sala == "", aceita qualquer login menos "borginhos".
function require_login($sala = "") {
    $username = null;
    $password = null;

    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $username = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
    }

    if (is_null($username)) {
        headauth("Voce precisa fazer login para continuar!");
    } else {
        if (($username !== $sala && $sala != "") || ($username == "borginhos" && $sala == ""))  {
            error_log("login incorreto, sala = $sala, username = $username");
            headauth("Esse login nao e o correto! Faca login!");
        }
        if (!isright($username, $password)) {
            headauth("Nome de usuario ou senha incorretos!");
        }
    }
}

?>