<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
// var_dump($_POST);
if (
    isset($_POST["form_7_aseguradora"]) &&
    isset($_POST["form_7_tipo_poliza"]) &&
    isset($_POST["form_7_numero_poliza"]) &&
    isset($_POST["form_7_fecha_expedicion"]) &&
    isset($_POST["form_7_fecha_vencimiento"]) &&
    isset($_POST["form_7_foto_poliza"]) &&
    isset($_POST["form_7_id_vehiculo"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 7
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

            $form_aseguradora = htmlspecialchars($_POST['form_7_aseguradora']);
            $form_tipo_poliza = htmlspecialchars($_POST['form_7_tipo_poliza']);
            $form_numero_poliza = htmlspecialchars($_POST['form_7_numero_poliza']);
            $form_fecha_expedicion = getspecialdate($_POST['form_7_fecha_expedicion']);
            $form_fecha_vencimiento = getspecialdate($_POST['form_7_fecha_vencimiento']);
            $form_foto_poliza = htmlspecialchars($_POST['form_7_foto_poliza']);
            $form_id_vehiculo = encrypt($_POST['form_7_id_vehiculo'], 2);
            $form_id_usuario = $_SESSION['session_user'][1];

            if (strcmp($database->status(), "bien") == 0) {

                require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/poliza/create.php';

                $poliza = new CreatePoliza($database->myconn);

                $arrayResponse = $poliza->setPoliza(
                    $form_aseguradora,
                    $form_numero_poliza,
                    $form_fecha_expedicion,
                    $form_fecha_vencimiento,
                    $form_tipo_poliza,
                    $form_foto_poliza,
                    $form_id_vehiculo,
                    $form_id_usuario
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