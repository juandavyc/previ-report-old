<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_poliza']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";
    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                $id_poliza = encrypt($_POST['id_poliza'], 2);

                require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/poliza_soat/read.php';

                $poliza_soat = new ReadPolizaSoat($database->myconn);
                $arrayResponse = $poliza_soat->getPolizaSoat(
                    array(
                        'TYPE' => 'ID',
                        'VALUE' => $id_poliza,
                    ),
                    '0,1'
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['poliza_soat'];
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
            $json_status = "csrf";
            $json_message = htmlspecialchars("Wrong CSRF token.");
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