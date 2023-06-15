<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/vehiculo_implicado/create.php';

$headers = apache_request_headers();

// var_dump($_POST);
if (
    isset($_POST["form_3_placa"]) &&
    isset($_POST["form_3_marca"]) &&
    isset($_POST["form_3_modelo"]) &&
    isset($_POST["form_3_conductor"]) &&
    isset($_POST["form_3_telefono"]) &&
    isset($_POST["form_3_correo"]) &&
    isset($_POST["form_3_direccion"]) &&
    isset($_POST["form_3_aseguradora"]) &&
    isset($_POST["form_3_telefono_aseguradora"]) &&
    isset($_POST["form_3_tipo_poliza"]) &&
    isset($_POST["form_3_aseguradora_poliza"]) &&
    isset($_POST["form_3_fecha_expedicion_poliza"]) &&
    isset($_POST["form_3_fecha_vencimiento_poliza"]) &&
    isset($_POST["form_3_id_siniestro"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 14
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

        if (strcmp($database->status(), "bien") == 0) {

            $testigo = new CreateVehiculoImplicado($database->myconn);
            $arrayResponse = $testigo->setVehiculo(
                array(
                    'PLACA' => htmlspecialchars($_POST['form_3_placa']),
                    'MARCA' => htmlspecialchars($_POST['form_3_marca']),
                    'MODELO' => htmlspecialchars($_POST['form_3_modelo']),
                    'CONDUCTOR' => htmlspecialchars($_POST['form_3_conductor']),
                    'TELEFONO' => htmlspecialchars($_POST['form_3_telefono']),
                    'CORREO' => htmlspecialchars($_POST['form_3_correo']),
                    'DIRECCION' => htmlspecialchars($_POST['form_3_direccion']),
                    'ASEGURADORA' => htmlspecialchars($_POST['form_3_aseguradora']),
                    'ASEGURADORA_TELEFONO' => htmlspecialchars($_POST['form_3_telefono_aseguradora']),
                    'POLIZA' => htmlspecialchars($_POST['form_3_tipo_poliza']),
                    'POLIZA_ASEGURADORA' => htmlspecialchars($_POST['form_3_aseguradora_poliza']),
                    'FECHA_EXPEDICION' => getspecialdate($_POST['form_3_fecha_expedicion_poliza']),
                    'FECHA_VENCIMIENTO' => getspecialdate($_POST['form_3_fecha_vencimiento_poliza']),
                    'ID_SINIESTRO' => encrypt($_POST['form_3_id_siniestro'], 2),
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
