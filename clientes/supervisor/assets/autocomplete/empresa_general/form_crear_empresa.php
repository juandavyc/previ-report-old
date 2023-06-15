<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

if (
    isset($_POST["nit_empresa"]) &&
    isset($_POST["nombre_empresa"]) &&
    isset($_POST["direccion_empresa"]) &&
    isset($_POST["telefono_empresa"]) &&
    isset($_POST["correo_empresa"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";
    $json_id = 0;
    $json_name = 'SIN_NOMBRE';

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            $nit_empresa = htmlspecialchars($_POST['nit_empresa']);
            $nombre_empresa = htmlspecialchars($_POST['nombre_empresa']);
            $direccion_empresa = htmlspecialchars($_POST['direccion_empresa']);
            $telefono_empresa = htmlspecialchars($_POST['telefono_empresa']);
            $correo_empresa = htmlspecialchars($_POST['correo_empresa']);
            $id_usuario = $_SESSION['session_user'][1];

            if (strcmp($database->status(), "bien") == 0) {

                $mysql_query = "CALL proc_crear_empresa ";
                $mysql_query .= "(?,?,?,?,?,?,@respuesta);";

                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                $mysql_stmt->bind_param(
                    'sssssi',
                    $nit_empresa,
                    $nombre_empresa,
                    $direccion_empresa,
                    $telefono_empresa,
                    $correo_empresa,
                    $id_usuario,
                );

                if ($mysql_stmt->execute()) {
                    $mysql_stmt->close();
                    $json_status = "ok";

                    $mysql_query = "SELECT @respuesta As json_proc;";
                    $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

                    if ($mysql_stmt->execute()) {

                        $mysql_result = $mysql_stmt->get_result();
                        $row = $mysql_result->fetch_assoc();
                        $array_decode = json_decode($row['json_proc']);
                        $json_status = $array_decode[0];
                        $json_message = $array_decode[1];
                        $json_id = $array_decode[2];
                        $json_name = $array_decode[3];

                        $mysql_stmt->close();
                    } else {
                        $json_status = "error";
                        $json_message = "Error al consultar 2 " . htmlspecialchars($mysql_stmt->error);
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
        'id' => $json_id,
        'name' => $json_name,
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

/*
if (
isset($_POST["form_5_nombre_preventiva"]) &&
isset($_POST["form_5_numero_preventiva"]) &&
isset($_POST["form_5_fecha_expedicion_preventiva"]) &&
isset($_POST["form_5_fecha_vencimiento_preventiva"]) &&
isset($_POST["form_5_foto_revision_preventiva"]) &&
isset($_POST["form_5_id_vehiculo"]) &&
isset($_SESSION["session_user"]) &&
count($_SESSION["session_user"]) == 5 &&
count($_POST) == 6
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

$form_id_preventiva = htmlspecialchars($_POST['form_5_nombre_preventiva']);
$form_numero_preventiva = htmlspecialchars($_POST['form_5_numero_preventiva']);
$form_fecha_expedicion_preventiva = getspecialdate($_POST['form_5_fecha_expedicion_preventiva']);
$form_fecha_vencimiento_preventiva = getspecialdate($_POST['form_5_fecha_vencimiento_preventiva']);
$form_foto_revision_preventiva = htmlspecialchars($_POST['form_5_foto_revision_preventiva']);
$form_id_vehiculo = htmlspecialchars($_POST['form_5_id_vehiculo']);
$form_id_usuario = $_SESSION['session_user'][1];

if (strcmp($database->status(), "bien") == 0) {

$mysql_query = "CALL proc_vehiculo_revision_preventiva ";
$mysql_query .= "(?,?,?,?,?,?,?,@respuesta);";

$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
$mysql_stmt->bind_param(
'issssii',
$form_id_preventiva,
$form_numero_preventiva,
$form_fecha_expedicion_preventiva,
$form_fecha_vencimiento_preventiva,
$form_foto_revision_preventiva,
$form_id_vehiculo,
$form_id_usuario,
);

if ($mysql_stmt->execute()) {
$mysql_stmt->close();
$json_status = "ok";

$mysql_query = "SELECT @respuesta As json_proc;";
$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

if ($mysql_stmt->execute()) {
$mysql_result = $mysql_stmt->get_result();
$row = $mysql_result->fetch_assoc();
$array_decode = json_decode($row['json_proc']);
$json_status = $array_decode[0];
$json_message = $array_decode[1];
$mysql_stmt->close();
} else {
$json_status = "error";
$json_message = "Error al consultar 2 " . htmlspecialchars($mysql_stmt->error);
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
}*/