<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
$headers = apache_request_headers();



if (
    isset($_POST['empresa']) &&
    isset($_POST['filtro']) &&
    isset($_POST['contenido']) &&
    isset($_POST['documento']) &&
    isset($_POST['filtrar_fecha']) &&
    isset($_POST['fecha_inicial']) &&
    isset($_POST['fecha_final']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 7
) {

    $json_status = "error";
    $json_message = "sin iniciar";
    $json_documents = array(
        'arl'=>array()
    );


    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        require DOCUMENT_ROOT . '/modulos/assets/clases/arl/read.php';
        include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
        include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';
         // $_documentos = $_POST['documento'];
        // foreach($_documentos as $key => $value){
        //     echo $key." - ".$value;
        // }

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {
            $json_status = "bien";
            $arl = new ReadArl($database->myconn);
            $json_documents['arl'] = $arl->getArlDocumentos();
        } else {
            $json_status = "error";
            $json_message = "Imposible conectar a la base de datos";
        }
    } else {
        $json_status = "error";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }
    echo json_encode(
        array(
            'status' => $json_status,
            'message' => $json_message,
            'documents' => $json_documents
        ),
        JSON_FORCE_OBJECT
    );
    exit;
} else if (!isset($_SESSION["session_user"])) {
    echo json_encode(
        array(
            'status' => "session",
            'results' => "La sesión fue cerrada, inicie sesión nuevamente."
        ),
        JSON_FORCE_OBJECT
    );
    exit;
} else {
    echo json_encode(
        array(
            'status' => "Error",
            'message' => "Formulario incompleto",
        ),
        JSON_FORCE_OBJECT
    );
    exit;
}