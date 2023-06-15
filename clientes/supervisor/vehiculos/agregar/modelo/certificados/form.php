<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
// var_dump($_POST);
if (
    isset($_POST["form_8_entidad_certificado"]) &&
    isset($_POST["form_8_tipo_certificado"]) &&
    isset($_POST["form_8_numero_certificado"]) &&
    isset($_POST["form_8_fecha_expedicion"]) &&
    isset($_POST["form_8_fecha_vencimiento"]) &&
    isset($_POST["form_8_foto_certificado"]) &&
    isset($_POST["form_8_id_vehiculo"]) &&
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

            $form_entidad_certificado = htmlspecialchars($_POST['form_8_entidad_certificado']);
            $form_tipo_certificado = htmlspecialchars($_POST['form_8_tipo_certificado']);
            $form_numero_certificado = htmlspecialchars($_POST['form_8_numero_certificado']);
            $form_fecha_expedicion = getspecialdate($_POST['form_8_fecha_expedicion']);
            $form_fecha_vencimiento = getspecialdate($_POST['form_8_fecha_vencimiento']);
            $form_foto_certificado = htmlspecialchars($_POST['form_8_foto_certificado']);

            $form_id_vehiculo = htmlspecialchars(encrypt($_POST['form_8_id_vehiculo'], 2));
            $form_id_usuario = $_SESSION['session_user'][1];

            if (strcmp($database->status(), "bien") == 0) {

                $mysql_query = "CALL proc_vehiculo_certificado ";
                $mysql_query .= "(?,?,?,?,?,?,?,?,@respuesta);";

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param(
                    'iissisii',
                    $form_entidad_certificado,
                    $form_numero_certificado,
                    $form_fecha_expedicion,
                    $form_fecha_vencimiento,
                    $form_tipo_certificado,
                    $form_foto_certificado,
                    $form_id_vehiculo,
                    $form_id_usuario
                );

                if ($mysql_stmt->execute()) {
                    $mysql_stmt->close();
                    $json_status = "ok";

                    $mysql_query = "SELECT @respuesta As json_proc;";
                    $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

                    if ($mysql_stmt->execute()) {
                        $mysql_result = $mysql_stmt->get_result();
                        $row = $mysql_result->fetch_assoc();
                        $array_decode = json_decode($row['json_proc']);
                        $json_status = $array_decode[0];
                        $json_message = $array_decode[1];
                        $mysql_stmt->close();
                    } else {
                        $json_status = "error";
                        $json_message = "Error al consultar 2 " . htmlspecialchars($mysql_stmt->error);
                    }
                } else {
                    $json_status = "error";
                    $json_message = "Error al consultar 1 " . htmlspecialchars($mysql_stmt->error);
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