<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/mantenimiento/supervisor/read.php';

$headers = apache_request_headers();

if (
    isset($_POST['id_elemento']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
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

                $id_mantenimiento = encrypt($_POST['id_elemento'], 2);

                // echo $id_mantenimiento;
                $mantenimiento = new ReadMantenimientoSuper($database->myconn);

                $arrayResponse = $mantenimiento->getMantenimientoSuper(
                    array(
                        'TYPE' => 'ID',
                        'VALUE' => $id_mantenimiento,
                        'LIMITE' => '0,1',
                    )
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['mantenimiento'];

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