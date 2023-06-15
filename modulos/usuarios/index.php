<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
if (isset($_SESSION["session_user"])) {
    echo "<script> window.location = '" . ROOT . "/modulos/usuarios/visor';</script>";
} else {
    echo "<script> window.location = '" . ROOT . "/';</script>";
}
