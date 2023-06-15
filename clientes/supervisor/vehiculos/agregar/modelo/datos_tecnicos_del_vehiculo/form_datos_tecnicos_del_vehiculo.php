<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

// var_dump($_POST);
if (
    isset($_POST["form_4_capacidad_de_carga"]) &&
    isset($_POST["form_4_peso_bruto_vehicular"]) &&
    isset($_POST["form_4_capacidad_de_pasajeros"]) &&
    isset($_POST["form_4_capacidad_de_pasajeros_sentados"]) &&
    isset($_POST["form_4_numero_de_ejes"]) &&
    isset($_POST["form_4_id_vehiculo"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 6
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

                $form_4_capacidad_de_carga = htmlspecialchars($_POST['form_4_capacidad_de_carga']);
                $form_4_peso_bruto_vehicular = htmlspecialchars($_POST['form_4_peso_bruto_vehicular']);
                $form_4_capacidad_de_pasajeros = htmlspecialchars($_POST['form_4_capacidad_de_pasajeros']);
                $form_4_capacidad_de_pasajeros_sentados = htmlspecialchars($_POST['form_4_capacidad_de_pasajeros_sentados']);
                $form_4_numero_de_ejes = htmlspecialchars($_POST['form_4_numero_de_ejes']);
                $form_4_id_vehiculo = (encrypt($_POST['form_4_id_vehiculo'], 2));
                $form_4_id_usuario = $_SESSION['session_user'][1];

                require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/datos_tecnicos_vehiculo/update.php';

                $certificado = new UpdateDatosTecnicos($database->myconn);
                $arrayResponse = $certificado->setDatosTecnicos(
                    $form_4_capacidad_de_carga,
                    $form_4_peso_bruto_vehicular,
                    $form_4_capacidad_de_pasajeros,
                    $form_4_capacidad_de_pasajeros_sentados,
                    $form_4_numero_de_ejes,
                    $form_4_id_vehiculo,
                    $form_4_id_usuario,
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