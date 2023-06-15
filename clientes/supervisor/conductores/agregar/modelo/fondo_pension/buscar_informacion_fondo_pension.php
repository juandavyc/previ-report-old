<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_fondo_pension_conductor']) &&
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

                $id_fondo_pension = htmlspecialchars($_POST['id_fondo_pension_conductor']);

                $mysql_query = "SELECT ";
                $mysql_query .= "fdp.nombre_fondo_pension, con.nombre_conductor, fdpc.fecha_afiliacion_fondo_pension, ";
                $mysql_query .= "efdp.nombre_estado_fondo_pension,fdpc.foto_fondo_pension_conductor ";
                $mysql_query .= "FROM fondo_pension_conductor fdpc ";
                $mysql_query .= "INNER JOIN fondo_pension fdp ON fdp.id_fondo_pension = fdpc.id_fondo_pension ";
                $mysql_query .= "INNER JOIN estado_fondo_pension efdp ON efdp.id_estado_fondo_pension = fdpc.id_estado_fondo_pension ";
                $mysql_query .= "INNER JOIN conductor con ON con.id_conductor = fdpc.id_conductor ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "fdpc.id_fondo_pension_conductor  = ? ";
                $mysql_query .= "ORDER BY fdpc.id_fondo_pension_conductor DESC LIMIT 0,1 ; ";



                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_fondo_pension);

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