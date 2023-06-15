<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_vehiculo_conductor']) &&
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

                $_id_vehiculo_conductor = htmlspecialchars($_POST['id_vehiculo_conductor']);

                $mysql_query = "SELECT ";
                $mysql_query .= "veh.placa_vehiculo, tveh.nombre_tipo_vehiculo, veh.modelo_vehiculo, ";
                $mysql_query .= "ser.nombre_servicio, mar.nombre_marca, lin.nombre_linea, ";
                $mysql_query .= "col.nombre_color, veh.kilometraje_vehiculo, comb.nombre_combustible, ";
                $mysql_query .= "con.nombre_conductor, veh.foto_delantera, veh.foto_trasera, veh.foto_costado_izquierdo, veh.foto_costado_derecho ";
                $mysql_query .= "FROM vehiculo_conductor vehc ";
                $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = vehc.id_vehiculo ";
                $mysql_query .= "INNER JOIN tipo_vehiculo tveh ON tveh.id_tipo_vehiculo = veh.id_tipo_vehiculo ";
                $mysql_query .= "INNER JOIN servicio ser ON ser.id_servicio = veh.id_servicio ";
                $mysql_query .= "INNER JOIN linea lin ON lin.id_linea = veh.id_linea ";
                $mysql_query .= "INNER JOIN marca mar ON mar.id_marca = lin.id_marca ";
                $mysql_query .= "INNER JOIN color col ON col.id_color = veh.id_color ";
                $mysql_query .= "INNER JOIN combustible comb ON comb.id_combustible = veh.id_combustible ";
                $mysql_query .= "INNER JOIN conductor con ON vehc.id_conductor = con.id_conductor ";
                $mysql_query .= "WHERE ";
                $mysql_query .= "vehc.id_vehiculo_conductor  = ? ";
                $mysql_query .= "ORDER BY vehc.id_vehiculo_conductor DESC LIMIT 0,1 ; ";



                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $_id_vehiculo_conductor);

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