<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/modulos/assets/clases/siniestro/update.php';
// var_dump($_POST);
$headers = apache_request_headers();
if (
    isset($_POST["form_0_tipo"]) &&
    isset($_POST["form_0_fecha"]) &&
    isset($_POST["form_0_hora"]) &&
    isset($_POST["form_0_ciudad"]) &&
    isset($_POST["form_0_lugar"]) &&
    isset($_POST["form_0_heridos"]) &&
    isset($_POST["form_0_muertos"]) &&
    isset($_POST["form_0_vehiculos_implicados"]) &&
    isset($_POST["form_0_descripcion"]) &&
    isset($_POST["form_0_foto_1"]) &&
    isset($_POST["form_0_foto_2"]) &&
    isset($_POST["form_0_foto_3"]) &&
    isset($_POST["form_0_foto_4"]) &&
    isset($_POST["form_0_firma"]) &&
    isset($_POST["form_0_id_siniestro"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 15
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

            $id_siniestro = encrypt($_POST['form_0_id_siniestro'], 2);
            $id_usuario = $_SESSION['session_user'][1];

            $form_firma = getSRCImage64($_POST['form_0_firma'], 'siniestro/firma', $id_siniestro . '_' . $id_usuario . '_' . time());

            $siniestro = new UpdateSiniestro($database->myconn);
            $arrayResponse = $siniestro->setInformacionSiniestro(
                array(
                    'ID' => $id_siniestro,
                    'ID_TIPO' => htmlspecialchars($_POST['form_0_tipo']),
                    'FECHA' => getspecialdate($_POST['form_0_fecha']),
                    'HORA' => htmlspecialchars($_POST['form_0_hora']),
                    'CIUDAD' => htmlspecialchars($_POST['form_0_ciudad']),
                    'DIRECCION' => htmlspecialchars($_POST['form_0_lugar']),
                    'HERIDOS' => htmlspecialchars($_POST['form_0_heridos']),
                    'MUERTOS' => htmlspecialchars($_POST['form_0_muertos']),
                    'VEHICULOS' => htmlspecialchars($_POST['form_0_vehiculos_implicados']),
                    'DESCRIPCION' => htmlspecialchars($_POST['form_0_descripcion']),
                    'FOTO_1' => htmlspecialchars($_POST['form_0_foto_1']),
                    'FOTO_2' => htmlspecialchars($_POST['form_0_foto_2']),
                    'FOTO_3' => htmlspecialchars($_POST['form_0_foto_3']),
                    'FOTO_4' => htmlspecialchars($_POST['form_0_foto_4']),
                    'FIRMA' => $form_firma,
                    'ID_USUARIO' => $id_usuario,
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
