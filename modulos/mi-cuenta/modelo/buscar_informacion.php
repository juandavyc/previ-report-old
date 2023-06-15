<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/usuario/read.php';

$headers = apache_request_headers();

if (
    isset($_POST['id_consulta']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
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

                $id_accordion = htmlspecialchars($_POST['id_consulta']);
                $id_usuario = $_SESSION['session_user'][1];

                if ($id_accordion == 0) {
                    $usuario = new ReadUsuario($database->myconn);
                    $arrayResponse = $usuario->getUsuarioInformacion(
                        array(
                            'TYPE' => 'ID',
                            'VALUE' => $id_usuario,
                        )
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];

                        foreach ($arrayResponse['usuario'] as $key => $value) {
                            array_push(
                                $json_message,
                                array(
                                    "cedula" => $value['cedula'],
                                    "nombre" => ($value['nombre']),
                                    "apellido" => ($value['apellido']),
                                    "correo" => ($value['correo']),
                                    "telefono" => ($value['telefono']),
                                    "fecha_nacimiento" => ($value['fecha_nacimiento']),
                                    "firma" => ($value['firma']),
                                    "foto" => ($value['foto']),
                                    "empresa" => ($value['empresa']),
                                    "rango" => ($value['rango']),
                                    "taller" => ($value['taller']),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 1) {
                    $json_status = 'bien';
                    $json_message = 'No retorna resultados';
                } else {
                    $json_status = 'error';
                    $json_message = 'Sin tarea asignada.';
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