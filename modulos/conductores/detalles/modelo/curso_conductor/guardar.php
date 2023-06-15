<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

// // 
// var_dump($_POST);

$headers = apache_request_headers();
if (
    isset($_POST['form_9_entidad_curso']) &&
    isset($_POST['form_9_nombre_curso']) &&
    isset($_POST['form_9_fecha_realizacion_curso_conductor']) &&
    isset($_POST['form_9_fecha_expiracion_curso_conductor']) &&
    isset($_POST['form_9_observacion_curso_conductor']) &&
    isset($_POST['form_9_logro_curso']) &&
    isset($_POST['form_9_foto_curso']) &&
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


            $form_9_entidad_curso = htmlspecialchars(strtoupper($_POST["form_9_entidad_curso"]));
            $form_9_nombre_curso = htmlspecialchars(strtoupper($_POST["form_9_nombre_curso"]));
            $form_9_logro_curso = htmlspecialchars(strtoupper($_POST["form_9_logro_curso"]));
            $form_9_fecha_realizacion = getspecialdate(strtoupper($_POST["form_9_fecha_realizacion_curso_conductor"]));
            $form_9_fecha_expiracion = getspecialdate(strtoupper($_POST["form_9_fecha_expiracion_curso_conductor"]));
            $form_9_observacion = htmlspecialchars(strtoupper($_POST["form_9_observacion_curso_conductor"]));
            $form_9_foto = htmlspecialchars(($_POST["form_9_foto_curso"]));
            $form_9_id_conductor = htmlspecialchars(strtoupper(encrypt($_POST["id_conductor"], 2)));
            $form_id_usuario = $_SESSION['session_user'][1];
            $mysql_query = "call proc_conductor_curso (?,?,?,?,?,?,?,?,?,@respuesta); ";

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param(
                'sisssssii',
                $form_9_logro_curso,
                $form_9_entidad_curso,
                $form_9_nombre_curso,
                $form_9_fecha_realizacion,
                $form_9_fecha_expiracion,
                $form_9_observacion,
                $form_9_foto,
                $form_9_id_conductor,
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
