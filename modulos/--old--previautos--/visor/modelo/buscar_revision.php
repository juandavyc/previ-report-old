<?php session_start();
header('Content-Type: application/json');

require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/previautos/clases/revision_read.php';

$headers = apache_request_headers();

if (
    isset($_POST['id_vehiculo']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 1

) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                $revision = new ReadRevision($database->myconn);
                $arrayResponse = $revision->getRevison(
                    encrypt($_POST['id_vehiculo'], 2),
                    'VEHICULO'
                );

                if ($arrayResponse['status'] == 'bien') {
                    $con = 1;

                    $json_status = $arrayResponse['status'];
                    foreach ($arrayResponse['revision'] as $key => $value) {

                        array_push(
                            $json_message,
                            array(
                                "nro" => ($con++),
                                "tipo" => ($value['tipo']),
                                "biemensual" => ($value['bimensual']),
                                "ingeniero" => ($value['usuario']),
                                "exp" => ($value['expedicion']),
                                "ven" => ($value['vencimiento']),
                                "opciones" => array(
                                    'id' => encrypt($value['id'], 1),
                                    'archivo' => ($value['archivo']),
                                )
                            )
                        );
                    }
                }

                $database->close();
            } else {
                $json_status = "error";
                $json_message = "Imposible conectar a la base de datos";
            }
        } else {
            $json_status = "error";
            $json_message = htmlspecialchars("Wrong CSRF token.");
        }
    } else {
        $json_status = "csrf";
        $json_message = htmlspecialchars($json_host['message']);
    }
    $datos = array(
        'status' => $json_status,
        'message' => $json_message,
    );
    echo json_encode($datos);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'message' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'message' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}