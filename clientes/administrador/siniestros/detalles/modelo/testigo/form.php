<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/testigo/create.php';

$headers = apache_request_headers();

// var_dump($_POST);
if (
    isset($_POST["form_2_nombre"]) &&
    isset($_POST["form_2_telefono"]) &&
    isset($_POST["form_2_correo"]) &&
    isset($_POST["form_2_direccion"]) &&
    isset($_POST["form_2_id_siniestro"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5
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

                $testigo = new CreateTestigo($database->myconn);
                $arrayResponse = $testigo->setTestigo(
                    array(
                        'NOMBRE' => htmlspecialchars($_POST['form_2_nombre']),
                        'TELEFONO' => htmlspecialchars($_POST['form_2_telefono']),
                        'CORREO' => htmlspecialchars($_POST['form_2_correo']),
                        'DIRECCION' => htmlspecialchars($_POST['form_2_direccion']),
                        'ID_SINIESTRO' => encrypt($_POST['form_2_id_siniestro'], 2),
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