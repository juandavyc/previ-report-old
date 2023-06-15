<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST['id_preoperativo']) &&
    isset($_POST['id_accordion']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/clientes/conductor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/conductor/assets/php/hdv_resources.php';

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
                // $id_preoperativo = $_POST["id_preoperativo"];
                $id_preoperativo = encrypt($_POST["id_preoperativo"], 2);
                // consulta para retornar datos basicos de conductor

                if (strcmp($id_accordion, "1") == 0) {

                    $mysql_query = "SELECT ";
                    $mysql_query .= "veh.placa_vehiculo,pre.id_preoperacional, pre.tarjeta_propiedad_vigencia, pre.tarjeta_propiedad_fecha, pre.tarjeta_propiedad_entidad, ";
                    $mysql_query .= "pre.revision_rtm_vigencia, pre.revision_rtm_fecha, pre.revision_rtm_entidad, ";
                    $mysql_query .= "pre.certificado_gases_vigencia, pre.certificado_gases_fecha, pre.certificado_gases_entidad, ";
                    $mysql_query .= "pre.planilla_fuec_vigencia, pre.planilla_fuec_fecha, pre.planilla_fuec_entidad, ";
                    $mysql_query .= "pre.licencia_conduccion_vigencia, pre.licencia_conduccion_fecha, pre.licencia_conduccion_entidad, ";
                    $mysql_query .= "pre.poliza_vigencia, pre.poliza_fecha, pre.poliza_entidad, ";
                    $mysql_query .= "pre.poliza_soat_vigencia, pre.poliza_soat_fecha, pre.poliza_soat_entidad, ";
                    $mysql_query .= "pre.foto_tacometro_kilometraje, pre.foto_tacometro_combustible ";
                    $mysql_query .= "FROM preoperacional pre ";
                    $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = pre.id_vehiculo ";
                    $mysql_query .= "WHERE pre.id_preoperacional LIKE ? ; ";

                    // var_dump($mysql_query);

                } 
                

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param('i', $id_preoperativo);

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