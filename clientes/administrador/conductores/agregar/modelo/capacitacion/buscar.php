<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_capacitacion_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_resources.php';

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

                $id_capacitacion_conductor = htmlspecialchars($_POST['id_capacitacion_conductor']);

                $mysql_query = "SELECT ";
                $mysql_query .= "cap.nombre_capacitacion, tcap.nombre_tipo_capacitacion, ecap.nombre_entidad_capacitacion, cap.duracion_capacitacion, ";
                $mysql_query .= "cap.fecha_realizacion_capacitacion, cap.refuerzo_si_no, cap.fecha_refuerzo_capacitacion, con.nombre_conductor, cap.foto_capacitacion ";
                $mysql_query .= "FROM capacitacion cap ";
                $mysql_query .= "INNER JOIN entidad_capacitacion ecap ON ecap.id_entidad_capacitacion = cap.id_entidad_capacitacion ";
                $mysql_query .= "INNER JOIN conductor con ON con.id_conductor = cap.id_conductor ";
                $mysql_query .= "INNER JOIN tipo_capacitacion tcap ON tcap.id_tipo_capacitacion = tcap.id_tipo_capacitacion ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "cap.id_capacitacion  = ? ";
                $mysql_query .= "ORDER BY cap.id_capacitacion DESC LIMIT 0,1 ; ";



                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_capacitacion_conductor);

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