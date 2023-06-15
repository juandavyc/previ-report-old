<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_poliza']) &&
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

            $id_poliza = encrypt($_POST['id_poliza'], 2);

            $mysql_query = "SELECT ";
            $mysql_query .= "poli.numero_poliza, poli.fecha_expedicion_poliza, poli.fecha_vencimiento_polzia, ";
            $mysql_query .= "poli.foto_poliza, usu.nombre_usuario, usu.apellido_usuario, ";
            $mysql_query .= "ase.nombre_aseguradora_poliza, veh.placa_vehiculo, poli.fecha_formulario ";
            $mysql_query .= "FROM poliza poli ";
            $mysql_query .= "INNER JOIN usuario usu ON usu.id_usuario = poli.id_usuario ";
            $mysql_query .= "INNER JOIN aseguradora_poliza ase ON ase.id_aseguradora_poliza = poli.id_aseguradora_poliza ";
            $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = poli.id_vehiculo ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "poli.id_poliza = ? ";
            $mysql_query .= "ORDER BY poli.id_poliza DESC LIMIT 0,1 ; ";

            // echo $mysql_query;

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('i', $id_poliza);

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
