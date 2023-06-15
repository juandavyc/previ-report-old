<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

if (
    isset($_POST["form_2_id_vehiculo"]) &&
    isset($_POST["form_2_nombre_cda"]) &&
    isset($_POST["form_2_numero_rtm"]) &&
    isset($_POST["form_2_fecha_expedicion_rtm"]) &&
    isset($_POST["form_2_foto_certificado_rtm"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5
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

            $form_id_cda = htmlspecialchars($_POST['form_2_nombre_cda']);
            $form_numero_rtm = htmlspecialchars($_POST['form_2_numero_rtm']);
            $form_fecha_expedicion_rtm = getspecialdate($_POST['form_2_fecha_expedicion_rtm']);
            $form_fecha_evencimiento_rtm = adddaysdate($form_fecha_expedicion_rtm, 365);
            $form_id_vehiculo = htmlspecialchars(encrypt($_POST['form_2_id_vehiculo'], 2));
            $form_foto_certificado_rtm = htmlspecialchars($_POST['form_2_foto_certificado_rtm']);
            $form_id_usuario = $_SESSION['session_user'][1];

            if (strcmp($database->status(), "bien") == 0) {

                require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/certificado_rtm/create.php';

                $certificado = new CreateCertificadoRTM($database->myconn);
                $arrayResponse = $certificado->setCertificadoRTM(
                    $form_id_cda,
                    $form_numero_rtm,
                    $form_fecha_expedicion_rtm,
                    $form_fecha_evencimiento_rtm,
                    $form_foto_certificado_rtm,
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