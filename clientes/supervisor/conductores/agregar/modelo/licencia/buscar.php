<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_licencia_conductor']) &&
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

                $id_licencia_conductor = htmlspecialchars($_POST['id_licencia_conductor']);

                $mysql_query = "SELECT ";
                $mysql_query .= "licc.numero_licencia_conduccion, licc.fecha_expedicion_licencia_conduccion, licc.fecha_vencimiento_licencia_conduccion, estl.nombre_estado_licencia, ";
                $mysql_query .= "licc.restricciones_del_conductor, licc.foto_delantera_licencia_conduccion, licc.foto_trasera_licencia_conduccion,  ";
                $mysql_query .= "cat1.nombre_categoria_licencia_conduccion AS categoria_1 ,  cat1.descripcion_categoria_licencia_conduccion AS descripcion_categoria_1,";
                $mysql_query .= "cat2.nombre_categoria_licencia_conduccion AS categoria_2 , cat2.descripcion_categoria_licencia_conduccion AS descripcion_categoria_2, ";
                $mysql_query .= "cat3.nombre_categoria_licencia_conduccion AS categoria_3 , cat3.descripcion_categoria_licencia_conduccion AS descripcion_categoria_3, ";
                $mysql_query .= "cat4.nombre_categoria_licencia_conduccion AS categoria_4 , cat4.descripcion_categoria_licencia_conduccion AS descripcion_categoria_4 ";
                $mysql_query .= "FROM licencia_conduccion licc ";
                $mysql_query .= "INNER JOIN categoria_licencia_conduccion cat1 ON cat1.id_categoria_licencia_conduccion = licc.id_categoria_1 ";
                $mysql_query .= "INNER JOIN categoria_licencia_conduccion cat2 ON cat2.id_categoria_licencia_conduccion = licc.id_categoria_2 ";
                $mysql_query .= "INNER JOIN categoria_licencia_conduccion cat3 ON cat3.id_categoria_licencia_conduccion = licc.id_categoria_3 ";
                $mysql_query .= "INNER JOIN categoria_licencia_conduccion cat4 ON cat4.id_categoria_licencia_conduccion = licc.id_categoria_4 ";
                $mysql_query .= "INNER JOIN estado_licencia estl ON estl.id_estado_licencia = licc.id_estado_licencia ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "licc.id_licencia_conduccion  = ? ";
                $mysql_query .= "ORDER BY licc.id_licencia_conduccion DESC LIMIT 0,1 ; ";

// var_dump($mysql_query);

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_licencia_conductor);

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