<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

// var_dump($_POST);

$headers = apache_request_headers();
if (
    isset($_POST['form_11_dias_incapacidad_conductor']) &&
    isset($_POST['form_11_eps_incapacidad']) &&
    isset($_POST['form_11_arl_incapacidad']) &&
    isset($_POST['form_11_concepto_incapacidad']) &&
    isset($_POST['form_11_foto_incapacidad']) &&
    isset($_POST['form_11_fecha_inicio_incapacidad_conductor']) &&
    isset($_POST['form_11_fecha_fin_incapacidad_conductor']) &&
    isset($_POST['id_conductor']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 8
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
            
            $form_11_dias_incapacidad_conductor = htmlspecialchars(strtoupper($_POST["form_11_dias_incapacidad_conductor"]));
            $form_11_eps_incapacidad = htmlspecialchars(strtoupper($_POST["form_11_eps_incapacidad"]));
            $form_11_arl_incapacidad = htmlspecialchars(strtoupper($_POST["form_11_arl_incapacidad"]));
            $form_11_concepto_incapacidad = htmlspecialchars(strtoupper($_POST["form_11_concepto_incapacidad"]));
            $form_11_foto_incapacidad = htmlspecialchars(($_POST["form_11_foto_incapacidad"]));
            $form_11_fecha_inicio = getspecialdate(strtoupper($_POST["form_11_fecha_inicio_incapacidad_conductor"]));
            $form_11_fecha_fin = getspecialdate(strtoupper($_POST["form_11_fecha_fin_incapacidad_conductor"]));
            $id_conductor = htmlspecialchars(strtoupper(encrypt($_POST["id_conductor"], 2)));
            $form_id_usuario = $_SESSION['session_user'][1];
            $mysql_query = "call proc_conductor_incapacidad (?,?,?,?,?,?,?,?,?,@respuesta); ";

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param(
                'ssiiissii',
                $form_11_fecha_inicio,
                $form_11_fecha_fin,
                $form_11_dias_incapacidad_conductor,
                $form_11_eps_incapacidad,
                $form_11_arl_incapacidad,
                $form_11_concepto_incapacidad,
                $form_11_foto_incapacidad,
                $id_conductor,
                $form_id_usuario
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
                    $json_message =  $array_decode[1];

                    $mysql_stmt->close();
                }
                // la consulta no se ejecuto
                else {
                    $json_status = "error";
                    $json_message =  "Error al consultar 2 " . htmlspecialchars($mysql_stmt->error);
                }
            }
            // la consulta no se ejecuto procedimiento
            else {
                $json_status = "error";
                $json_message =  "Error al consultar 1 " . htmlspecialchars($mysql_stmt->error);
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

    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
// fin datos POST
// inicio session finalizada
else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'results' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
}
// fin session finalizada
// los datos POST no corresponde


else {
    $json_array = array(
        'status' => "Error",
        'message' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
