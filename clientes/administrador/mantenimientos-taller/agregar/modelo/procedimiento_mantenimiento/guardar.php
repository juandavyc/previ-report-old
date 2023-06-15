<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/mantenimiento/mecanico/update.php';
// var_dump($_POST);
$headers = apache_request_headers();
if (
    isset($_POST["form_2_repuesto_mantenimiento"]) &&
    isset($_POST["form_2_fecha_inicial_mantenimiento"]) &&
    isset($_POST["form_2_hora_inicio_mantenimiento"]) &&
    isset($_POST["form_2_descripcion_trabajo_a_realizar"]) &&
    isset($_POST["form_2_descripcion_procedimiento_realizado"]) &&
    isset($_POST["form_2_fecha_final_mantenimiento"]) &&
    isset($_POST["form_1_canvas"]) &&
    isset($_POST["form_2_hora_final_mantenimiento"]) &&
    isset($_POST["id_mantenimiento"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 9     
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

                $form_id_usuario = $_SESSION['session_user'][1];

                $empresa = new UpdateMantenimiento($database->myconn);
                $arrayResponse = $empresa->setProcedimientoMantenimiento(
                    array(
                        'ID' => htmlspecialchars(encrypt($_POST['id_mantenimiento'],2)),
                        'REPUESTO' => htmlspecialchars($_POST['form_2_repuesto_mantenimiento']),
                        'FECHA_INICIAL' => getspecialdate($_POST['form_2_fecha_inicial_mantenimiento']),
                        'HORA_INICIAL' => htmlspecialchars($_POST['form_2_hora_inicio_mantenimiento']),
                        'FECHA_FINAL' => getspecialdate($_POST['form_2_fecha_final_mantenimiento']),
                        'FIRMA' => getSRCImage64($_POST['form_1_canvas'], 'firmas/mantenimiento_mecanico', $form_id_usuario . '_' . time()),
                        //  getSRCImage64($_POST['form_0_firma'], 'firmas/usuarios', $form_id_usuario . '_' . $id_usuario . '_' . time());
                        'HORA_FINAL' => htmlspecialchars($_POST['form_2_hora_final_mantenimiento']),
                        'DESCRIPCION_REALIZAR' => htmlspecialchars($_POST['form_2_descripcion_trabajo_a_realizar']),
                        'DESCRIPCION_REALIZADO' => htmlspecialchars($_POST['form_2_descripcion_procedimiento_realizado']),
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