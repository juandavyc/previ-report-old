<?php session_start();
header('Content-Type: application/json');

require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/usuario/read.php';

$headers = apache_request_headers();

if (
    isset($_POST['form_1_cedula']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 1

) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                $id_elemento = htmlspecialchars($_POST['form_1_cedula']);
                $empresa = $_SESSION['session_user'][2];

                $usuario = new ReadUsuario($database->myconn);
                $arrayResponse = $usuario->getUsuarioInformacion(
                    array(
                        'TYPE' => 'CEDULA',
                        'VALUE' => $id_elemento,
                    ),'0,5',
                    $empresa
                );
                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    // Solo los datos que quiero
                    foreach ($arrayResponse['usuario'] as $key => $value) {
                        array_push(
                            $json_message, array(
                                "id" => ($value['id']),
                                "cedula" => ($value['cedula']),
                                "nombre" => ($value['nombre']),
                                "apellido" => ($value['apellido']),
                                "empresa" => ($value['empresa']),
                                "rango" => ($value['rango']),
                                "estado" => ($value['estado']),
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
    } else {
        $json_status = "csrf";
        $json_message = htmlspecialchars($json_host['message']);
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