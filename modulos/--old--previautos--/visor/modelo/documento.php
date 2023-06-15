<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();


if (
    isset($_POST['form_2_documento']) &&
    isset($_POST['form_2_id_vehiculo']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

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


                $_id_vehiculo = encrypt($_POST['form_2_id_vehiculo'], 2);
                $_documento = htmlspecialchars($_POST['form_2_documento']);
                $_id_usuario = $_SESSION['session_user'][1];

                $mysqlQuery = "UPDATE previautos_vehiculo ";
                $mysqlQuery .= "SET documento_previautos_vehiculo = ?,id_usuario = ? ";
                $mysqlQuery .= "WHERE id_previautos_vehiculo = ?; ";


                $mysqlStmt = mysqli_prepare($database->myconn, $mysqlQuery);
                $mysqlStmt->bind_param('sii', $_documento, $_id_usuario, $_id_vehiculo);

                if ($mysqlStmt->execute()) {
                    $json_status = "bien";
                    $json_message = "Documento actualizado";
                } else {

                    $json_status = "error";
                    $json_message =  'Error en la consulta : ' . htmlspecialchars($mysqlStmt->error);
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