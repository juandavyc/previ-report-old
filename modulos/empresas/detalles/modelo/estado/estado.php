<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
// require DOCUMENT_ROOT . '/modulos/assets/clases/usuario/update.php';

if (
    isset($_POST["form_2_estado"]) &&
    isset($_POST["form_2_id_empresa"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
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

            $form_2_estado = htmlspecialchars($_POST['form_2_estado']);
            $form_2_id_empresa = encrypt($_POST['form_2_id_empresa'], 2);


            $mysql_query = "UPDATE empresa ";
            $mysql_query .= "SET id_estado = ? ";
            $mysql_query .= "WHERE id_empresa = ? ; ";

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('ii', $form_2_estado, $form_2_id_empresa);

            if ($mysql_stmt->execute()) {
                $json_status = "bien";
                $json_message = "Estado de empresa actualizado";
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
