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
if (isset($_SESSION["session_user"]) &&
    (count($_SESSION["session_user"]) == 5)) {
    echo "<script> window.location = '" . ROOT . "/modulos/';</script>";

}