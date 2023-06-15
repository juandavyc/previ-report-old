<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/usuario/update.php';

$headers = apache_request_headers();



if (
    isset($_POST["form_0_nombre"]) &&
    isset($_POST["form_0_apellido"]) &&
    isset($_POST["form_0_telefono"]) &&
    isset($_POST["form_0_correo"]) &&
    isset($_POST["form_0_fecha_nacimiento"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5
) {
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

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

                $id_usuario = $_SESSION['session_user'][1];


                $usuario = new UpdateUsuario($database->myconn);
                $arrayResponse = $usuario->setDatosInformacion(
                    array(
                        'ID' => $id_usuario,
                        'NOMBRE' => htmlspecialchars(strtoupper($_POST["form_0_nombre"])),
                        'APELLIDO' => htmlspecialchars(strtoupper($_POST["form_0_apellido"])),
                        'TELEFONO' => htmlspecialchars($_POST["form_0_telefono"]),
                        'CORREO' => htmlspecialchars(strtoupper($_POST["form_0_correo"])),
                        'FECHA_NACIMIENTO' => getspecialdate($_POST["form_0_fecha_nacimiento"]),
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



/*

if (
    isset($_POST["form_0_foto_usuario"]) &&
    isset($_POST["form_0_nombre"]) &&
    isset($_POST["form_0_apellido"]) &&
    isset($_POST["form_0_telefono"]) &&
    isset($_POST["form_0_correo"]) &&
    isset($_POST["form_0_fecha_nacimiento"]) &&
    isset($_POST["form_0_empresa"]) &&
    isset($_POST["form_0_taller"]) &&
    isset($_POST["form_0_rango"]) &&
    isset($_POST["form_0_firma"]) &&
    isset($_POST["form_0_id_usuario"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 11
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

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

                $form_id_usuario = encrypt($_POST["form_0_id_usuario"], 2);
                $id_usuario = $_SESSION['session_user'][1];

                $form_firma = getSRCImage64($_POST['form_0_firma'], 'firmas/usuarios', $form_id_usuario . '_' . $id_usuario . '_' . time());

                $usuario = new UpdateUsuario($database->myconn);
                $arrayResponse = $usuario->setDatosUsuario(
                    array(
                        'ID' => $form_id_usuario,
                        'FOTO' => htmlspecialchars($_POST["form_0_foto_usuario"]),
                        'NOMBRE' => htmlspecialchars($_POST["form_0_nombre"]),
                        'APELLIDO' => htmlspecialchars($_POST["form_0_apellido"]),
                        'FIRMA' => $form_firma,
                        'TELEFONO' => htmlspecialchars($_POST["form_0_telefono"]),
                        'CORREO' => htmlspecialchars($_POST["form_0_correo"]),
                        'FECHA_NACIMIENTO' => getspecialdate($_POST["form_0_fecha_nacimiento"]),
                        'ID_EMPRESA' => htmlspecialchars($_POST["form_0_empresa"]),
                        'ID_TALLER' => htmlspecialchars($_POST["form_0_taller"]),
                        'ID_RANGO' => htmlspecialchars($_POST["form_0_rango"]),
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
}*/