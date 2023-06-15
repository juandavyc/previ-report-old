<?php session_start();
header('Content-Type: application/json');
include $_SERVER["DOCUMENT_ROOT"] . "/modulos/assets/php/hoja_private_config.php";

$headers = apache_request_headers();
require DOCUMENT_ROOT . '/assets/php/empresa/get.php';

$headers = apache_request_headers();

if (
    isset($_POST['dato'])
) {
    include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "Sin inciar"; 
    $json_array = "Sin inciar";

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {
        
            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                // $id_vehiculo = htmlspecialchars(encrypt($_POST['id_vehiculo'], 2));

                $empresas = new ReadEmpresas($database->myconn);
                $arrayResponse = $empresas->getEmpresas(
                    array(
                        'TYPE' => 'ID',
                        'VALUE' => 1,
                    ),
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['empresa'];

                } else {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                }
                $database->close();
            } else {
                $json_status = "error";
                $json_message = "Imposible conectar a la base de datos";
            }

    } else {
        $json_status = "error";
        $json_message = htmlspecialchars($json_host['message']);
    }
    
    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
} else {

    $json_array = array(
        'status' => 'error',
        'message' => 'Formulario incompleto',
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}