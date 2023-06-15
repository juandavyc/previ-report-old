<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

$json_array = array(
    'status' => "Error",
    'id' => "Elemento desactivado en este modulo",
);
echo json_encode($json_array, JSON_FORCE_OBJECT);