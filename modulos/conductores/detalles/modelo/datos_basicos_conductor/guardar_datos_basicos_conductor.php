<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/conductor/create.php';
$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST['form_1_nombre_conductor']) &&
    isset($_POST['form_1_apellido_conductor']) &&
    isset($_POST['form_1_tipo_identificacion']) &&
    isset($_POST['form_1_tipo_sangre_conductor']) &&
    isset($_POST['form_1_direccion_conductor']) &&
    isset($_POST['form_1_telefono_conductor']) &&
    isset($_POST['form_1_celular_conductor']) &&
    isset($_POST['form_1_whatsapp_conductor']) &&
    isset($_POST['form_1_correo_electronico_conductor']) &&
    isset($_POST['form_1_ciudad_conductor']) &&
    isset($_POST['form_1_departamento_conductor']) &&
    isset($_POST['form_1_id']) &&
    isset($_POST['form_1_canvas']) &&
    isset($_POST['form_1_foto_conductor']) &&
    isset($_POST['form_1_empresa']) &&
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

            $usuario = $_SESSION['session_user'][1];

            $mantenimiento = new CreateConductor($database->myconn);
            $arrayResponse = $mantenimiento->setConductor(array(
                "NOMBRE" => htmlspecialchars(strtoupper($_POST["form_1_nombre_conductor"])),
                "APELLIDO" => htmlspecialchars(strtoupper($_POST["form_1_apellido_conductor"])),
                "TIPO_DOCUMENTO" => htmlspecialchars(strtoupper($_POST["form_1_tipo_identificacion"])),
                "TIPO_SANGRE" => htmlspecialchars(strtoupper($_POST["form_1_tipo_sangre_conductor"])),
                "DIRECCION" => htmlspecialchars(strtoupper($_POST["form_1_direccion_conductor"])),
                "TELEFONO" => htmlspecialchars(strtoupper($_POST["form_1_telefono_conductor"])),
                "CELULAR" => htmlspecialchars(strtoupper($_POST["form_1_celular_conductor"])),
                "WHATSAPP" => htmlspecialchars(strtoupper($_POST["form_1_whatsapp_conductor"])),
                "CORREO" => htmlspecialchars(strtoupper($_POST["form_1_correo_electronico_conductor"])),
                "CIUDAD" => htmlspecialchars(($_POST["form_1_ciudad_conductor"])),
                "DEPARTAMENTO" => htmlspecialchars(($_POST["form_1_departamento_conductor"])),
                "FIRMA" => getSRCImage64($_POST['form_1_canvas'], 'firmas/conductores', $usuario . '_' . time()),
                "FOTO" => htmlspecialchars(($_POST["form_1_foto_conductor"])),
                "EMPRESA" => htmlspecialchars(($_POST["form_1_empresa"])),
                "USUARIO" => $usuario,
                "ID" => htmlspecialchars(strtoupper(encrypt($_POST["form_1_id"], 2))),
            ));

            if ($arrayResponse['status'] == 'bien') {
                $json_status = $arrayResponse['status'];
                // $json_message = encrypt($arrayResponse['id'], 1);
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
        $json_status = "error";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }



    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
// fin datos POST
// inicio session finalizada
else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'results' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
}
// fin session finalizada
// los datos POST no corresponde

else {
    $json_array = array(
        'status' => "Error",
        'message' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
