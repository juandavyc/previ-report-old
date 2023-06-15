<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

if (isset($_POST["nombre_elemento"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();

    $nombre_elemento = htmlspecialchars(strtoupper($_POST["nombre_elemento"]));

    if (isset($headers['csrf-token']) && hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {
            $mysql_query = "INSERT INTO ";
            $mysql_query .= "lugar_preventiva ";
            $mysql_query .= "(nombre_lugar_preventiva) ";
            $mysql_query .= "VALUES(?) ";

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('s', $nombre_elemento);

            $json_result = array();
            if ($mysql_stmt->execute()) {
                $json_status = "bien";
                $json_message = $database->myconn->insert_id;
            } else {
                $json_status = "error";
                $json_message = "Error en la consulta " . htmlspecialchars($mysql_stmt->error);
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
    $datos = array(
        'status' => $json_status,
        'id' => $json_message,
        'nombre' => $nombre_elemento,
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'id' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'id' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}