<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

if (
    isset($_POST["form_3_id_vehiculo"]) &&
    isset($_POST["form_3_aseguradora_soat"]) &&
    isset($_POST["form_3_numero_soat"]) &&
    isset($_POST["form_3_fecha_expedicion_soat"]) &&
    isset($_POST["form_3_foto_poliza_soat"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5
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

        $form_id_aseguradora = htmlspecialchars($_POST['form_3_aseguradora_soat']);
        $form_numero_soat = htmlspecialchars($_POST['form_3_numero_soat']);
        $form_fecha_expedicion_soat = getspecialdate($_POST['form_3_fecha_expedicion_soat']);
        $form_fecha_vencimiento_soat = adddaysdate($form_fecha_expedicion_soat, 365);
        $form_id_vehiculo = htmlspecialchars(encrypt($_POST['form_3_id_vehiculo'], 2));
        $form_foto_soat = htmlspecialchars($_POST['form_3_foto_poliza_soat']);

        $form_id_usuario = $_SESSION['session_user'][1];

        if (strcmp($database->status(), "bien") == 0) {
            require DOCUMENT_ROOT . '/modulos/assets/clases/poliza_soat/create.php';

            $soat = new CreatePolizaSOAT($database->myconn);

            $arrayResponse = $soat->setPolizaSOAT(
                $form_id_aseguradora,
                $form_numero_soat,
                $form_fecha_expedicion_soat,
                $form_fecha_vencimiento_soat,
                $form_foto_soat,
                $form_id_vehiculo,
                $form_id_usuario,
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
