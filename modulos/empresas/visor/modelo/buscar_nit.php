<?php session_start();
header('Content-Type: application/json');

require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/empresa/read.php';

$headers = apache_request_headers();

if (
    isset($_POST['form_1_nit']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 1
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

            $id_elemento = htmlspecialchars($_POST['form_1_nit']);

            $empresa = new ReadEmpresa($database->myconn);
            $arrayResponse = $empresa->getEmpresaInformacion(
                array(
                    'TYPE' => 'NIT',
                    'VALUE' => $id_elemento,
                )
            );
            if ($arrayResponse['status'] == 'bien') {
                $json_status = $arrayResponse['status'];
                // Solo los datos que quiero
                foreach ($arrayResponse['empresa'] as $key => $value) {
                    array_push(
                        $json_message,
                        array(
                            "id" => ($value['id']),
                            "nit" => ($value['nit']),
                            "nombre" => ($value['nombre']),
                            "direccion" => ($value['direccion']),
                            "opciones" => encrypt($value['id'], 1),
                        )
                    );
                }
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
        $json_status = "error";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }

    $datos = array(
        'status' => $json_status,
        'body' => $json_message,
    );
    echo json_encode($datos);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'body' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'body' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
