<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/conductor/read.php';
$headers = apache_request_headers();
// var_dump($_POST);

if (
    isset($_POST['cedula']) &&
    // isset($_POST['empresa']) &&
    isset($_SESSION["session_user"]) &&
    count($_POST) == 1 &&
    count($_SESSION['session_user']) == 5
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

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

                $cedula = htmlspecialchars($_POST['cedula']);
                $empresa = $_SESSION['session_user'][2];

                $conductor = new ReadConductor($database->myconn);
                $arrayResponse = $conductor->getConductor(
                    array(
                        'TYPE' => 'DOCUMENTO',
                        'VALUE' => $cedula,
                    ),
                    '0,5',
                    $empresa,
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];

                    // Solo los datos que quiero
                    foreach ($arrayResponse['usuario'] as $key => $value) {
                        array_push(
                            $json_message, array(
                                "nro" => ($key + 1),
                                "documento" => ($value['documento']),
                                "nombre" => ($value['nombre']),
                                "apellido" => ($value['apellido']),
                                "empresa" => ($value['empresa']['nombre']),
                                "opciones" => encrypt($value['id'], 1),
                            )
                        );
                    }

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
            $json_message = htmlspecialchars("Wrong CSRF token.");
        }
    } else {
        $json_status = "error";
        $json_message = htmlspecialchars($json_host['message']);
    }
    echo json_encode(
        array(
            'status' => $json_status,
            'body' => $json_message,
        )
    );
    exit;
} else {

    $json_array = array(
        'status' => "Error",
        'message' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}