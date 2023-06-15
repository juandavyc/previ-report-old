<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

if (
    isset($_POST["form_5_nombre_preventiva"]) &&
    isset($_POST["form_5_numero_preventiva"]) &&
    isset($_POST["form_5_fecha_expedicion_preventiva"]) &&
    isset($_POST["form_5_fecha_vencimiento_preventiva"]) &&
    isset($_POST["form_5_foto_revision_preventiva"]) &&
    isset($_POST["form_5_id_vehiculo"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 6
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

        $form_id_preventiva = htmlspecialchars($_POST['form_5_nombre_preventiva']);
        $form_numero_preventiva = htmlspecialchars($_POST['form_5_numero_preventiva']);
        $form_fecha_expedicion_preventiva = getspecialdate($_POST['form_5_fecha_expedicion_preventiva']);
        $form_fecha_vencimiento_preventiva = getspecialdate($_POST['form_5_fecha_vencimiento_preventiva']);
        $form_foto_revision_preventiva = htmlspecialchars($_POST['form_5_foto_revision_preventiva']);
        $form_id_vehiculo = htmlspecialchars(encrypt($_POST['form_5_id_vehiculo'], 2));
        $form_id_usuario = $_SESSION['session_user'][1];

        if (strcmp($database->status(), "bien") == 0) {

            require DOCUMENT_ROOT . '/modulos/assets/clases/revision_preventiva/create.php';

            $preventiva = new CreateRevisionPreventiva($database->myconn);

            $arrayResponse = $preventiva->setRevisionPreventiva(
                $form_id_preventiva,
                $form_numero_preventiva,
                $form_fecha_expedicion_preventiva,
                $form_fecha_vencimiento_preventiva,
                $form_foto_revision_preventiva,
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
