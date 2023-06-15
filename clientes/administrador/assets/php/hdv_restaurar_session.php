<?php session_start();
header('Content-Type: application/json');
include $_SERVER["DOCUMENT_ROOT"] . "/clientes/administrador/assets/php/hoja_private_config.php";

$headers = apache_request_headers();

if (
    isset($_POST['usuario']) &&
    isset($_POST['contrasenia']) &&
    isset($_POST['empresa']) &&
    isset($_POST['ip'])
) {

    include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "Sin inciar";
    $json_token = "no_autorizado";

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        $form_usuario = htmlspecialchars($_POST['usuario']);
        $form_contrasenia = htmlspecialchars($_POST['contrasenia']);
        $form_empresa = htmlspecialchars($_POST['empresa']);
        $form_ip = htmlspecialchars($_POST['ip']);
        // 0 TRAER DATOS USUARIO.
        $form_recepcion = "0";

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $mysql_query = "CALL proc_iniciar_sesion(?,?,?,?,@return_p);";
            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('sssi', $form_usuario, $form_contrasenia, $form_ip,$form_empresa);

            if ($mysql_stmt->execute()) {

                $mysql_stmt->close();

                $mysql_query = "SELECT @return_p As Estado;";
                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

                if ($mysql_stmt->execute()) {

                    $mysql_result = $mysql_stmt->get_result();
                    $mysql_row_result = $mysql_result->fetch_assoc();
                    $mysql_array_decode = json_decode($mysql_row_result['Estado']);

                    if (strcasecmp($mysql_array_decode[0], "bien") == 0) {
                        $json_status = $mysql_array_decode[0];

                        $json_message = ROOT . "/clientes/administrador/";

                        $_SESSION['session_user'] = $mysql_array_decode;
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        $json_token = $_SESSION['csrf_token'];

                    } else {
                        $json_status = $mysql_array_decode[0];
                        $json_message = htmlspecialchars($mysql_array_decode[1]);
                    }
                } else {
                    $json_status = "error";
                    $json_message = "Error al consultar: " . htmlspecialchars($mysql_stmt->error);
                }
            } else {
                $json_status = "error";
                $json_message = "Error al consultar: " . htmlspecialchars($mysql_stmt->error);
            }

            $database->close();
        } else {
            $json_status = "error";
            $json_message = "Imposible conectar a la base de datos";
        }

    } else {
        $json_status = "error";
        $json_message = htmlspecialchars($json_host['message']);
    }

    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
        'token' => $json_token,
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
} else {

    $json_array = array(
        'status' => 'error',
        'message' => 'Formulario incompleto',
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}