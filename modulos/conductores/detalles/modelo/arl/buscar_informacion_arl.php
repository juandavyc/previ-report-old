<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_arl_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";


    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $id_arl = encrypt($_POST['id_arl_conductor'], 2);

            $mysql_query = "SELECT ";
            $mysql_query .= "arll.nombre_arl, con.nombre_conductor, arlc.fecha_afiliacion_arl, ";
            $mysql_query .= "earl.nombre_estado_arl, arlc.foto_arl_conductor ";
            $mysql_query .= "FROM arl_conductor arlc ";
            $mysql_query .= "INNER JOIN arl arll ON arll.id_arl= arlc.id_arl ";
            $mysql_query .= "INNER JOIN conductor con ON con.id_conductor = arlc.id_conductor ";
            $mysql_query .= "INNER JOIN estado_arl  earl ON earl.id_estado_arl = arlc.id_estado_arl ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "arlc.id_arl_conductor  = ? ";
            $mysql_query .= "ORDER BY arlc.id_arl_conductor DESC LIMIT 0,1 ; ";



            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('i', $id_arl);

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
