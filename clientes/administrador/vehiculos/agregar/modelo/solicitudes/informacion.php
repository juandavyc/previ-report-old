<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_elemento']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/administrador
    /assets/php/hdv_resources.php';

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

                $id_elemento = htmlspecialchars($_POST['id_elemento']);

                $mysql_query = "SELECT ";
                $mysql_query .= "soli.numero_solicitud, soli.fecha_solicitud,esta.nombre_estado_solicitud, ";
                $mysql_query .= "soli.foto_solicitud, usu.nombre_usuario, usu.apellido_usuario, ";
                $mysql_query .= "enti.nombre_entidad_transito, veh.placa_vehiculo, soli.fecha_formulario ";
                $mysql_query .= "FROM solicitud soli ";
                $mysql_query .= "INNER JOIN usuario usu ON usu.id_usuario = soli.id_usuario ";
                $mysql_query .= "LEFT JOIN entidad_transito enti ON enti.id_entidad_transito = soli.id_entidad_transito ";
                $mysql_query .= "LEFT JOIN tipo_solicitud tipo ON tipo.id_tipo_solicitud = soli.id_tipo_solicitud ";
                $mysql_query .= "LEFT JOIN estado_solicitud esta ON esta.id_estado_solicitud = soli.id_estado_solicitud ";
                $mysql_query .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = soli.id_vehiculo ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "soli.id_solicitud = ? ";
                $mysql_query .= "ORDER BY soli.id_solicitud DESC LIMIT 0,1 ; ";

                //echo $mysql_query;

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_elemento);

                if ($mysql_stmt->execute()) {
                    $json_status = "ok";
                    $mysql_result = $mysql_stmt->get_result();
                    $mysql_rowcount = mysqli_num_rows($mysql_result);

                    if ($mysql_rowcount > 0) {
                        $json_status = "bien";
                        $json_message = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                    } else {
                        $json_status = "error";
                        $json_message = "Sin resultados";
                    }
                } else {
                    $json_status = "error";
                    $json_message = "Error al consultar 1 " . htmlspecialchars($mysql_stmt->error);
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