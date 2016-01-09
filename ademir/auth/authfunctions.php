<?php
// Gerencia funções de login. Substitui o login único HTTP: Basic de antes.
// Escrito por Bruno Borges Paschoalinoto.

function make_salt() {
    return uniqid("", true);
}

function makeshadow($user, $pass) {
    $salt = make_salt();
    $hashed = hash("sha512", "$pass:$salt");
    return "${user}§${hashed}§${salt}";
}

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

function headauth($msg) {
    header("WWW-Authenticate: Basic realm=\"$msg\"");
    header("HTTP/1.0 401 Unauthorized");
    echo $msg;
    die();
}

function require_login($sala) {
    $username = null;
    $password = null;

    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $username = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
    }

    if (is_null($username)) {
        headauth("Voce precisa fazer login como $sala para continuar!");
    } else {
        if ($username !== $sala && $sala != "" && $sala !== "borginhos") {
            headauth("Esse login nao e o correto! Faca login como $sala!");
        }
        if (!isright($username, $password)) {
            headauth("Nome de usuario ou senha incorretos!");
        }
    }
}

?>