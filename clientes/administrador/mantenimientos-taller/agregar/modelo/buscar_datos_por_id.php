<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST['id_mantenimiento']) &&
    isset($_POST['id_accordion']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
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

                $id_accordion = htmlspecialchars($_POST['id_accordion']);

                // $id_mantenimiento = htmlspecialchars(strtoupper(encrypt($_POST["id_mantenimiento"],2)));
                $id_mantenimiento = encrypt($_POST["id_mantenimiento"], 2);
                // consulta para retornar datos basicos de conductor

                if (strcmp($id_accordion, "1") == 0) {

                    $mysql_query = "SELECT ";
                    $mysql_query .= "veh.placa_vehiculo, man.id_mantenimiento, tman.id_tipo_mantenimiento, man.fecha_mantenimiento, man.direccion_mantenimiento, man.precio_mano_obra_mantenimiento, ";
                    $mysql_query .= "man.precio_repuestos_mantenimiento_total, man.precio_repuestos_mantenimiento_total, man.cantidad_repuestos_mantenimiento_total ";
                    $mysql_query .= "FROM mantenimiento man ";
                    $mysql_query .= "INNER JOIN tipo_mantenimiento tman ON tman.id_tipo_mantenimiento = man.id_tipo_mantenimiento ";
                    $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = man.id_vehiculo ";
                    $mysql_query .= "WHERE man.id_mantenimiento LIKE ? ; ";

                    // var_dump($mysql_query);

                } else if (strcmp($id_accordion, "2") == 0) {

                    $mysql_query = "SELECT ";
                    $mysql_query .= "man.repuesto_a_utilizar, man.fecha_inicio_mantenimiento, TIME_FORMAT(man.hora_inicio_mantenimiento, '%H:%i') As time_hora_siniestro,";
                    $mysql_query .= "man.descripcion_trabajo_a_realizar, man.descripcion_procedimiento_realizado, man.fecha_fin_mantenimiento, TIME_FORMAT(man.hora_fin_mantenimiento, '%H:%i') As time_hora_fin_siniestro, ";
                    $mysql_query .= "man.firma_mecanico ";
                    $mysql_query .= "FROM mantenimiento man ";
                    $mysql_query .= "WHERE man.id_mantenimiento LIKE ? ;";
                    // var_dump($mysql_query);

                } else if (strcmp($id_accordion, "3") == 0) {

                    $mysql_query = "SELECT ";
                    $mysql_query .= "fotm.id_foto_mantenimiento As id, fotm.descripcion_foto_mantenimiento AS descripcion, cfot.nombre_categoria_foto_mantenimiento As categoria, ";
                    $mysql_query .= "usu.nombre_usuario As usuario, fotm.fecha_formulario As fecha_guardado , fotm.id_foto_mantenimiento As opciones ";
                    $mysql_query .= "FROM foto_mantenimiento fotm ";
                    $mysql_query .= "INNER JOIN categoria_foto_mantenimiento cfot ON cfot.id_categoria_foto_mantenimiento = fotm.id_categoria_foto_mantenimiento ";
                    $mysql_query .= "INNER JOIN usuario usu ON usu.id_usuario = fotm.id_usuario ";
                    $mysql_query .= "WHERE fotm.id_mantenimiento LIKE ? ";
                    $mysql_query .= "ORDER BY fotm.id_foto_mantenimiento DESC ; ";

                    // var_dump($mysql_query);
                } else if (strcmp($id_accordion, "4") == 0) {

                    $mysql_query = "SELECT ";
                    $mysql_query .= "rep.id_repuesto_mantenimiento As id, rep.nombre_repuesto AS nombre, rep.cantidad_repuesto As cantidad, rep.valor_repuesto As valor, ";
                    $mysql_query .= "rep.id_repuesto_mantenimiento As opciones  ";
                    $mysql_query .= "FROM repuesto_mantenimiento rep ";
                    $mysql_query .= "WHERE rep.id_mantenimiento LIKE ? ";
                    $mysql_query .= "ORDER BY rep.id_repuesto_mantenimiento DESC ; ";
                    // var_dump($mysql_query);

                } else {

                }

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_mantenimiento);

                if ($mysql_stmt->execute()) {

                    $mysql_result = $mysql_stmt->get_result();
                    $mysql_rowcount = mysqli_num_rows($mysql_result);
                    // Con resultados
                    if ($mysql_rowcount > 0) {
                        $json_status = "bien";
                        $json_message = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                    }
                    // Sin resultados
                    else {
                        $json_status = "error";
                        $json_message = "Sin resultados";
                    }
                } else {
                    $json_status = "mal";
                    $json_message = "Error en la consulta " . htmlspecialchars($mysql_stmt->error);
                }

                $database->close();
            } else {
                $json_status = "error";
                $json_message = "Imposible conectar a la base de datos";
            }
        } else {
            $json_status = "error";
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
        'results' => "La sesión fue cerrada, inicie sesión nuevamente.",
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