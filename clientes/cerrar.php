<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
if (isset($_SESSION["session_user"])) {
    session_unset();
    session_destroy();
    echo "<script> window.location = '" . ROOT . "/';</script>";
} else {
    echo "<script> window.location = '" . ROOT . "/';</script>";
}
