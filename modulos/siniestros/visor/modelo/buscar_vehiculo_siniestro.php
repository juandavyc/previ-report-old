<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

if (isset($_POST["placa"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();

    if (isset($headers['csrf-token']) && hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $mysql_query = "SELECT ";
            $mysql_query .= "con.id_conductor,con.numero_documento, empc.id_empresa_conductor,emp.id_empresa ";
            $mysql_query .= "FROM ";
            $mysql_query .= "vehiculo_conductor vehc  ";
            $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = vehc.id_vehiculo  ";
            $mysql_query .= "INNER JOIN conductor con ON con.id_conductor = vehc.id_conductor ";
            $mysql_query .= "LEFT JOIN empresa_conductor empc ON empc.id_conductor = con.id_conductor AND empc.id_empresa = (SELECT id_empresa
            FROM empresa_conductor
            WHERE id_conductor = con.id_conductor
            ORDER BY id_empresa_conductor DESC LIMIT 0,1
            ) ";
            $mysql_query .= "LEFT JOIN empresa emp ON emp.id_empresa = empc.id_empresa ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "veh.id_vehiculo = ? ORDER BY vehc.id_vehiculo DESC LIMIT 0,1; ";

            $form_placa = htmlspecialchars($_POST["placa"]);

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('s', $form_placa);

            if ($mysql_stmt->execute()) {
                $json_status = "bien";
                $mysql_result = $mysql_stmt->get_result();

                $mysql_rowcount = mysqli_num_rows($mysql_result);

                if ($mysql_rowcount > 0) {
                    $json_status = "bien";
                    $json_message = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                } else {
                    $json_status = "error";
                    $json_message = "Sin conductor asignado, no se puede continuar.";
                }

                $mysql_stmt->close();

            } else {
                $json_status = "error";
                $json_table_title = "Error en la consulta # 1" . htmlspecialchars($mysql_stmt->error);
            }

            $database->close();

        } else {
            $json_status = "base_de_datos";
            $json_message = "Imposible conectar a la base de datos";
        }

    } else {
        $json_status = "csrf";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }

    $datos = array(
        'status' => $json_status,
        'message' => $json_message,

    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'options' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'options' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}