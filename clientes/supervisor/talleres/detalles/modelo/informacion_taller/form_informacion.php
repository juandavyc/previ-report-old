<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/taller/update.php';
// var_dump($_POST);
$headers = apache_request_headers();
if (
    isset($_POST["form_0_nombre"]) &&
    isset($_POST["form_0_telefono"]) &&
    isset($_POST["form_0_direccion"]) &&
    isset($_POST["form_0_correo"]) &&
    isset($_POST["form_0_ciudad"]) &&
    isset($_POST["form_0_id_taller"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 6
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

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

                $taller = new UpdateTaller($database->myconn);
                $arrayResponse = $taller->setDatosTaller(
                    array(
                        'ID' => encrypt($_POST['form_0_id_taller'], 2),
                        'NOMBRE' => htmlspecialchars($_POST['form_0_nombre']),
                        'TELEFONO' => htmlspecialchars($_POST['form_0_telefono']),
                        'DIRECCION' => htmlspecialchars($_POST['form_0_direccion']),
                        'CORREO' => htmlspecialchars($_POST['form_0_correo']),
                        'ID_CIUDAD' => htmlspecialchars($_POST['form_0_ciudad']),
                        'ID_USUARIO' => $_SESSION['session_user'][1],
                    )
                );
                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
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