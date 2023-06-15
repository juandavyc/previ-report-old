<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "../../hoja_config.php";
// elementos otros
include DOCUMENT_ROOT . '/assets/php/hdv_database.php';

require DOCUMENT_ROOT . '/pdfs/clases/poliza.php';
// Capacitaciones
$database = new dbconnection();
$database->connect();
if (strcmp($database->status(), "bien") == 0) {

    $poliza = new Poliza($database->myconn);
    $array_poliza = $poliza->getPolizaVehiculo(1);
    echo json_encode($array_poliza, JSON_FORCE_OBJECT);

    $database->close();
} else {
    $json_status = "error";
    $json_message = "Imposible conectar a la base de datos";
}

exit;