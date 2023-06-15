<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

require DOCUMENT_ROOT . '/modulos/assets/clases/empresa/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/certificado_empresa/read.php';

if (
    isset($_POST['id_accordion']) &&
    isset($_POST['id_empresa']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();


    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $id_empresa = encrypt($_POST['id_empresa'], 2);
            $id_accordion = htmlspecialchars($_POST['id_accordion']);

            /* data-id = 1 */
            /* Información del vehículo */

            if ($id_accordion == 0 || $id_accordion == 2) {
                $empresa = new ReadEmpresa($database->myconn);
                $arrayResponse = $empresa->getEmpresaInformacion(
                    array(
                        'TYPE' => 'ID',
                        'VALUE' => $id_empresa,
                    )
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['empresa'];
                } else {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                }
            } else if ($id_accordion == 1) {
                $certificado = new ReadCertificado($database->myconn);
                $arrayResponse = $certificado->getCertificado(
                    array(
                        'TYPE' => 'ID_EMPRESA',
                        'VALUE' => $id_empresa,
                    )
                );

                if ($arrayResponse['status'] == 'bien') {

                    $json_status = $arrayResponse['status'];

                    foreach ($arrayResponse['certificado'] as $key => $value) {
                        array_push(
                            $json_message,
                            array(
                                "Nro" => ($key + 1),
                                "Tipo" => ($value['tipo']),
                                "Nombre" => ($value['nombre']),
                                "Entidad" => ($value['entidad']),
                                "Expedicion" => ($value['fecha_expedicion']),
                                "Vencimiento" => ($value['fecha_vencimiento']),
                                "opciones" => encrypt($value['id'], 1),
                            )
                        );
                    }
                } else {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                }
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
