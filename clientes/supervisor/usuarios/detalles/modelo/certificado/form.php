<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/certificado_empresa/create.php';

$headers = apache_request_headers();

// var_dump($_POST);
if (
    isset($_POST["form_1_entidad_certificado"]) &&
    isset($_POST["form_1_tipo_certificado"]) &&
    isset($_POST["form_1_numero_certificado"]) &&
    isset($_POST["form_1_fecha_expedicion"]) &&
    isset($_POST["form_1_fecha_vencimiento"]) &&
    isset($_POST["form_1_foto_certificado"]) &&
    isset($_POST["form_1_id_empresa"]) &&
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

            if (strcmp($database->status(), "bien") == 0) {

                $certificado = new CreateCertificadoEmpresa($database->myconn);
                $arrayResponse = $certificado->setCertificado(
                    array(
                        'ID_ENTIDAD' => htmlspecialchars($_POST['form_1_entidad_certificado']),
                        'NUMERO' => htmlspecialchars($_POST['form_1_numero_certificado']),
                        'FECHA_EXP' => getspecialdate($_POST['form_1_fecha_expedicion']),
                        'FECHA_VEN' => getspecialdate($_POST['form_1_fecha_vencimiento']),
                        'ID_TIPO' => htmlspecialchars($_POST['form_1_tipo_certificado']),
                        'FOTO' => htmlspecialchars($_POST['form_1_foto_certificado']),
                        'ID_EMPRESA' => htmlspecialchars($_POST['form_1_id_empresa']),
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