<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
// var_dump($_POST);

$headers = apache_request_headers();
if (
    isset($_POST['id_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";
    $json_id = array();
    $json_vehiculo_conductor = array();


    $php_desde_ini = 0;



    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $id_conductor = htmlspecialchars(encrypt($_POST['id_conductor'], 2));

            // var_dump($id_conductor);

            $mysql_query = "SELECT ";
            $mysql_query .= "veh.id_vehiculo ";
            $mysql_query .= "FROM vehiculo_conductor vehc ";
            $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = vehc.id_vehiculo ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "vehc.id_conductor = ? ";
            $mysql_query .= "ORDER BY vehc.id_vehiculo_conductor DESC LIMIT 0,1; ";

            // var_dump($mysql_query);

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('s', $id_conductor);

            if ($mysql_stmt->execute()) {
                $json_status = "ok";
                $mysql_result = $mysql_stmt->get_result();

                $mysql_rowcount = mysqli_num_rows($mysql_result);

                if ($mysql_rowcount > 0) {
                    $json_status = "bien";
                    $php_desde_ini = 0;

                    if ($mysql_stmt->execute()) {

                        $result = $mysql_stmt->get_result();

                        while ($fila = $result->fetch_assoc()) {
                            $json_id[$php_desde_ini] = array(
                                "id_vehiculo" => encrypt($fila['id_vehiculo'], 1),
                            );
                            $php_desde_ini++;
                        }
                    } else {
                        $json_status = "error";
                        $json_message = "Error en la consulta # 2:<br> " . htmlspecialchars($mysql_stmt->error);
                    }
                } else {
                    $json_status = "sin_resultados";
                    $json_message = "Sin resultados";
                    // id 1
                    $json_id = array(
                        "id_vehiculo" => 'YlV2YUUvNGNUU09menptcldMOFV6dz09',
                    );
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
        'id' => $json_id,
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
