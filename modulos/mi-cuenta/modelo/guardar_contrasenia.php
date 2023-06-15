<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/usuario/update.php';

$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST["form_1_antigua_contrasenia"]) &&
    isset($_POST["form_1_nueva_contrasenia"]) &&
    isset($_POST["form_1_confirmar_contrasenia"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 3
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

            $id_usuario = $_SESSION['session_user'][1];

            // asi se me dio la pta gana 
            $old_pass = htmlspecialchars($_POST['form_1_antigua_contrasenia']);
            $new_pass = htmlspecialchars($_POST['form_1_nueva_contrasenia']);
            $con_pass = htmlspecialchars($_POST['form_1_confirmar_contrasenia']);


            if (strcmp($new_pass, $con_pass) == 0) {

                $usuario = new UpdateUsuario($database->myconn);
                $arrayResponse = $usuario->setContrasenia(
                    $old_pass,
                    $new_pass,
                    $id_usuario,
                );
                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                } else {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                }
            } else {
                $json_message = "Las contraseñas no son identicas (Nueva y Confirmar)";
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
