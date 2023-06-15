<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/previautos/clases/consulta_read.php';
$headers = apache_request_headers();


if (
    isset($_POST['sede']) &&
    isset($_POST['placa']) &&
    isset($_POST['documento']) &&
    count($_POST) == 3
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";

    $_sede = htmlspecialchars($_POST['sede']);
    $_placa = htmlspecialchars($_POST['placa']);
    $_documento = htmlspecialchars($_POST['documento']);


    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {
            // SQL
            $json_status = "SQL";
            $json_message = "START - END SQL";

            $revision = new ReadRevision($database->myconn);
            $arrayResponse = $revision->getRevison($_placa, $_documento);


            if ($arrayResponse['status'] == 'bien') {
                $json_status = $arrayResponse['status'];
                $json_message = ($arrayResponse['revision']);
            } else {
                $json_status = $arrayResponse['status'];
                $json_message = $arrayResponse['message'];
            }



            // END SQL
            $database->close();
        } else {
            $json_status = "error";
            $json_message = "Imposible conectar a la base de datos";
        }
    } else {
        $json_status = "error";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }



    echo json_encode(array(
        'status' => $json_status,
        'message' => $json_message,
        'placa' => $_placa,
        'documento' => $_documento,

    ), JSON_FORCE_OBJECT);
    exit;
} else {

    echo json_encode(array(
        'status' => "Error",
        'body' => "Formulario incompleto",
    ), JSON_FORCE_OBJECT);
    exit;
}