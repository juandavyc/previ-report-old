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
    $json_vehiculo_conductor = array();

    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $id_conductor = htmlspecialchars(encrypt($_POST['id_conductor'], 2));

            $mysql_query = "SELECT ";
            $mysql_query .= "con.nombre_conductor, con.telefono_conductor, con.celular_conductor, con.numero_documento, con.correo_conductor, tsan.nombre_tipo_sangre, ";
            $mysql_query .= "con_emg.nombre_contacto_de_emergencia_conductor, con_emg.telefono_contacto_de_emergencia_conductor, con_emg.parentesco_contacto_de_emergencia_conductor, ";
            $mysql_query .= "tid.nombre_tipo_identificacion, veh.placa_vehiculo, veh.id_vehiculo, con.foto_conductor ";
            $mysql_query .= "FROM conductor con ";
            $mysql_query .= "INNER JOIN tipo_identificacion tid ON tid.id_tipo_identificacion = con.id_tipo_identificacion ";
            $mysql_query .= "INNER JOIN tipo_sangre tsan ON tsan.id_tipo_sangre = con.id_tipo_sangre ";
            $mysql_query .= "LEFT JOIN contacto_de_emergencia_conductor con_emg ON con_emg.id_conductor = con.id_conductor  ";
            $mysql_query .= "LEFT JOIN vehiculo_conductor vcon ON vcon.id_conductor = con.id_conductor ";
            $mysql_query .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = vcon.id_vehiculo ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "con.id_conductor = ? ";
            $mysql_query .= "ORDER BY con.id_conductor DESC LIMIT 0,1 ; ";

            // var_dump($mysql_query);

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('s', $id_conductor);

            if ($mysql_stmt->execute()) {
                $json_status = "ok";
                $mysql_result = $mysql_stmt->get_result();
                $mysql_rowcount = mysqli_num_rows($mysql_result);

                if ($mysql_rowcount > 0) {
                    $json_status = "bien";
                    $json_message = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                } else {
                    $json_status = "error";
                    $json_message = "Sin resultados de datos de conductor";
                }
            } else {
                $json_status = "error";
                $json_message = "Error al consultar 1 " . htmlspecialchars($mysql_stmt->error);
            }

            $mysql_query_2 = "SELECT ";
            $mysql_query_2 .= "veh.placa_vehiculo, veh.id_vehiculo ";
            $mysql_query_2 .= "FROM conductor con ";
            $mysql_query_2 .= "LEFT JOIN vehiculo_conductor vcon ON vcon.id_conductor = con.id_conductor ";
            $mysql_query_2 .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = vcon.id_vehiculo ";
            $mysql_query_2 .= "WHERE ";
            $mysql_query_2 .= "con.id_conductor = ? ";
            $mysql_query_2 .= "ORDER BY con.id_conductor DESC ; ";

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query_2);
            $mysql_stmt->bind_param('s', $id_conductor);

            if ($mysql_stmt->execute()) {
                $json_status = "ok";
                $mysql_result = $mysql_stmt->get_result();

                $mysql_rowcount = mysqli_num_rows($mysql_result);

                if ($mysql_rowcount > 0) {
                    $json_status = "bien";
                    $php_desde_ini = 1;
                    $php_contador = 1;
                    // $json_vehiculo_conductor = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                    if ($mysql_stmt->execute()) {

                        $result = $mysql_stmt->get_result();

                        while ($fila = $result->fetch_assoc()) {
                            $json_vehiculo_conductor[$php_desde_ini] = array(
                                "nro" => htmlspecialchars($php_contador),
                                "placa" => htmlspecialchars($fila['placa_vehiculo']),
                                "opciones" => encrypt($fila['id_vehiculo'], 1),
                            );
                            $php_desde_ini++;
                        }
                    } else {
                        $json_status = "error";
                        $json_message = "Error en la consulta # 2:<br> " . htmlspecialchars($mysql_stmt->error);
                    }
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
        'data' => $json_vehiculo_conductor,
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
