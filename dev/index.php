<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', "D:/xampp/htdocs/web/php_error_log");

require_once "models/DatabaseConnection.php";
require_once "controllers/RoutesController.php";

$database = new DatabaseConnection();
$database->setConexion();
$estadoConexion = $database->getEstadoConexion();

if ($estadoConexion['statusCode'] == 200) {
    $index = new RoutesController();
    $index->index($database);

} else {
    echo json_encode(
        $estadoConexion,
        http_response_code($estadoConexion['statusCode'])
    );
}
