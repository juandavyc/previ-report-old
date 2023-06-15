<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/contacto_emergencia/read.php';
$headers = apache_request_headers();
if (
    isset($_POST['id_contacto_emergencia_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
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

            if (strcmp($database->status(), "bien") == 0) {

                $id_contacto_emergencia = encrypt($_POST['id_contacto_emergencia_conductor'], 2);

                // $mysql_query = "SELECT ";
                // $mysql_query .= "cec.nombre_contacto_de_emergencia_conductor , cec.telefono_contacto_de_emergencia_conductor , cec.parentesco_contacto_de_emergencia_conductor, con.nombre_conductor ";
                // $mysql_query .= "FROM contacto_de_emergencia_conductor cec ";
                // $mysql_query .= "LEFT JOIN conductor con ON con.id_conductor = cec.id_conductor ";
                // $mysql_query .= "WHERE ";
                // $mysql_query .= "cec.id_contacto_de_emergencia_conductor = ? ";
                // $mysql_query .= "ORDER BY cec.id_contacto_de_emergencia_conductor DESC LIMIT 0,1 ; ";

                // // var_dump($mysql_query) ;  

                // $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                // $mysql_stmt->bind_param('i', $id_contacto_emergencia);

                $conductor_emergencia = new ReadContactoEmergencia($database->myconn);
                $arrayResponse = $conductor_emergencia->getContacto(
                    array(
                        'TYPE' => 'ID',
                        'VALUE' => $id_contacto_emergencia,
                    ),
                    '0,20'
                );

                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['contacto_emergencia'];
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