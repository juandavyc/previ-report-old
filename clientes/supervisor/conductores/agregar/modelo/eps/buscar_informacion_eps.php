<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_eps_conductor']) &&
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

                $id_eps = encrypt($_POST['id_eps_conductor'], 2);

                $mysql_query = "SELECT ";
                $mysql_query .= "epss.nombre_eps, con.nombre_conductor, epsc.fecha_afiliacion_eps, ";
                $mysql_query .= "eeps.nombre_estado_eps, epsc.foto_eps_conductor ";
                $mysql_query .= "FROM eps_conductor epsc ";
                $mysql_query .= "INNER JOIN eps epss ON epss.id_eps = epsc.id_eps ";
                $mysql_query .= "INNER JOIN conductor con ON con.id_conductor = epsc.id_conductor ";
                $mysql_query .= "INNER JOIN estado_eps eeps ON eeps.id_estado_eps = epsc.id_estado_eps ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "epsc.id_eps_conductor = ? ";
                $mysql_query .= "ORDER BY epsc.id_eps_conductor DESC LIMIT 0,1 ; ";



                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_eps);

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