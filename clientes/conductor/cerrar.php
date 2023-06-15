<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
if (isset($_SESSION["session_user"])) {
    session_unset();
    session_destroy();
    echo "<script> window.location = '" . ROOT . "/';</script>";
} else {
    echo "<script> window.location = '" . ROOT . "/';</script>";
}

/*
header('Content-Type: application/json');
include "assets/php/hoja_private_config.php";

$headers = apache_request_headers();

if (isset($_SESSION["session_user"]) &&
isset($_POST['data']) &&
count($_SESSION["session_user"]) == 5 &&
count($_POST) == 1
) {

include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';

$json_status = "error";
$json_message = "Sin iniciar";
$json_log = "";
$json_host = getposturl($headers['Origin']);

if ($json_host['status'] == "ok") {

if (isset($headers['csrf-token']) && hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])) {

$database = new dbconnection();
$database->connect();

if (strcmp($database->status(), "bien") == 0) {

$session_user_name = ($_SESSION["session_user"][3]);

$json_log = array(
'source' => 'cierre sesion',
'data' => $session_user_name,
);
// tipo de log cierre de session
$id_tipo_log = 3;
$json_logs = json_encode($json_log);

$mysql_query = "CALL proc_save_log(?,?); ";
$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
$mysql_stmt->bind_param('is', $id_tipo_log, $json_logs);

if ($mysql_stmt->execute()) {

$json_status = "bien";

$mysql_stmt->close();
$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

// destruye la session
session_unset();
session_destroy();

} else {
$json_status = "error";
$json_message = "Error al consultar: " . htmlspecialchars($mysql_stmt->error);
}

$database->close();

} else {
$json_status = "bien";
$json_message = "Imposible conectar a la base de datos";

session_unset();
session_destroy();
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

} else {

$json_array = array(
'status' => 'error',
'message' => 'Formulario incompleto',
);

echo json_encode($json_array, JSON_FORCE_OBJECT);
exit;
}*/