<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/contacto_emergencia/create.php';

$headers = apache_request_headers();
if (
    isset($_POST['form_1_nombre_contacto_de_emergencia_conductor']) &&
    isset($_POST['form_1_telefono_contacto_de_emergencia_conductor']) &&
    isset($_POST['form_1_parentesco_contacto_de_emergencia_conductor']) &&
    isset($_POST['id_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 4
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


            $form_2_nombre_contacto_de_emergencia_conductor_datos = htmlspecialchars(strtoupper($_POST["form_1_nombre_contacto_de_emergencia_conductor"]));
            $form_2_telefono_contacto_de_emergencia_conductor_datos = htmlspecialchars(strtoupper($_POST["form_1_telefono_contacto_de_emergencia_conductor"]));
            $form_2_parentesco_contacto_de_emergencia_conductor_datos = htmlspecialchars(strtoupper($_POST["form_1_parentesco_contacto_de_emergencia_conductor"]));
            $form_2_id_conductor_datos = htmlspecialchars(strtoupper(encrypt($_POST["id_conductor"], 2)));
            $form_id_usuario = $_SESSION['session_user'][1];

            $Contacto = new CreateContacto($database->myconn);
            $arrayResponse = $Contacto->setContacto(
                $form_2_id_conductor_datos,
                $form_2_nombre_contacto_de_emergencia_conductor_datos,
                $form_2_telefono_contacto_de_emergencia_conductor_datos,
                $form_2_parentesco_contacto_de_emergencia_conductor_datos,
                $form_id_usuario
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
