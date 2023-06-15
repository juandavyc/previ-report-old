<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

$datos = array(
    'status' => 'error',
    'id' => 'Tarea no permitida en este modulo',
);
echo json_encode($datos, JSON_FORCE_OBJECT);
exit;