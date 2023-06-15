<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/modulos/assets/clases/mantenimiento/supervisor/create.php';

$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST['form_1_vehiculo']) &&
    isset($_POST['form_1_orden_servicio']) &&
    isset($_POST['form_1_numero_orden_servicio']) &&
    isset($_POST['form_1_firma']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 4
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";



    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $vehiculo = htmlspecialchars($_POST['form_1_vehiculo']);
            $orden = htmlspecialchars($_POST['form_1_orden_servicio']);
            $numero = htmlspecialchars($_POST['form_1_numero_orden_servicio']);
            $id_usuario = $_SESSION['session_user'][1];

            $firma = getSRCImage64($_POST['form_1_firma'], 'mantenimiento/firma', 'autoriza_' . $id_usuario . '_' . time());

            $mantenimiento = new CreateMantenimientoSuper($database->myconn);
            $arrayResponse = $mantenimiento->setMantenimiento($vehiculo, $orden, $numero, $firma, $id_usuario);

            if ($arrayResponse['status'] == 'bien') {
                $json_status = $arrayResponse['status'];
                $json_message = encrypt($arrayResponse['id'], 1);
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
