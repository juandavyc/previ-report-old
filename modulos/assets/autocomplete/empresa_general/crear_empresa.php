<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

$datos = array(
    'status' => 'error',
    'id' => 'Pulse el boton ( Agregar empresa )',
);
echo json_encode($datos, JSON_FORCE_OBJECT);
exit;