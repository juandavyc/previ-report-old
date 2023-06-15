<?php
// Verificar las sesiones
if (!defined('ROOT')) {
    define("ROOT", 'http://' . $_SERVER['HTTP_HOST']);
}
if (!defined('DOCUMENT_ROOT')) {
    define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT'] . "");
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// redirrecion

function required_session()
{
    if (
        !isset($_SESSION["session_user"]) ||
        (count($_SESSION["session_user"]) != 5)
    ) {
        session_unset();
        session_destroy();
        echo "<script> window.location = '" . ROOT . "/inicio_sesion/';</script>";
    } 
    else {
        // var_dump($_SESSION["session_user"][4]);
        if (
            $_SESSION["session_user"][4] === '4'
        ) {
        } else {

            echo "<script> window.location = '" . ROOT . "/clientes/';</script>";
        }

    }
}
