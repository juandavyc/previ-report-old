<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

require DOCUMENT_ROOT . '/modulos/assets/clases/usuario/read.php';

if (
    isset($_POST['id_accordion']) &&
    isset($_POST['id_usuario']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
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

                $id_usuario = encrypt($_POST['id_usuario'], 2);
                $id_accordion = htmlspecialchars($_POST['id_accordion']);

                /* data-id = 1 */
                /* Información del vehículo */

                if ($id_accordion == 0) {
                    $usuario = new ReadUsuario($database->myconn);
                    $arrayResponse = $usuario->getUsuarioInformacion(
                        array(
                            'TYPE' => 'ID',
                            'VALUE' => $id_usuario,
                        )
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['usuario'];

                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }

                } else {
                    $json_status = 'bien';
                    $json_message = 'Fallo exitosamente';
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
        'results' => "La sesión fue cerrada, inicie sesión nuevamente.",
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