<?php session_start();
header('Content-Type: application/json');

require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/habeas/save.php';
// var_dump($_POST);

$headers = apache_request_headers();

if (
    isset($_POST['canvas_firma_habeas']) &&
    isset($_POST['url']) &&
    isset($_POST['id']) &&
    isset($_POST['task']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 4
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

            // var_dump($database);

            if (strcmp($database->status(), "bien") == 0) {

                $usuario = $_SESSION['session_user'][1];
                $firma_habeas = getSRCImage64($_POST['canvas_firma_habeas'], 'firmas/habeas', $usuario . '_' . time());
                // var_dump($firma_habeas);
                $path = htmlspecialchars($_POST['url']);
                $id = htmlspecialchars($_POST['id']);
                $task = htmlspecialchars($_POST['task']);

                // var_dump($database->myconn);

                $habeas = new Habeas($database->myconn);
                $arrayResponse = $habeas->saveHabeas(
                    $firma_habeas,
                    $usuario,
                    $id,
                    $task,
                    $path,
                );

                // var_dump($arrayResponse);
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