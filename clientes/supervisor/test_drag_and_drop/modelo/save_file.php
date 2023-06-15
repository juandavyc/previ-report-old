<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

$headers = apache_request_headers();

$name = $_FILES['file']['name'];
$src = "uploads/" . $name;

move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/' . $name);
$json_array = array(
    'status' => "bien",
    'message' => "Archivo subido",
    'src' => $src,
    'name' => $name,
    'size' => '1234444',
);

echo json_encode($json_array, JSON_FORCE_OBJECT);

/*

if (0 < $_FILES['file']['error']) {

} else {
if (
isset($_FILES['file'])
) {

include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';

// Guardar el archivo en la ruta especificada
//    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/' . $_FILES['file']['name']);

$json_status = "error";
$json_message = "Sin inciar";

$json_host = getposturl($headers['Origin']);

if ($json_host['status'] == "ok") {

if (isset($headers['csrf-token']) && hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])) {

$filename = ($_FILES['file']['name']);
$url = ('../uploads/' . $_FILES['file']['name']);
$id_usuario = ($_SESSION['session_user'][1]);

$database = new dbconnection();
$database->connect();

if (strcmp($database->status(), "bien") == 0) {

$mysql_query = "CALL proc_save_url_file(?,?,?,@return_p);";
$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
$mysql_stmt->bind_param('sss', $filename,$url,$id_usuario);

if ($mysql_stmt->execute()) {

$mysql_stmt->close();

$mysql_query = "SELECT @return_p As json_proc;";
$mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);

if ($mysql_stmt->execute()) {

$mysql_result = $mysql_stmt->get_result();
$mysql_row_result = $mysql_result->fetch_assoc();
$mysql_array_decode = json_decode($mysql_row_result['json_proc']);

if (strcasecmp($mysql_array_decode[0], "bien") == 0) {

$json_status = $mysql_array_decode[0];
$json_message = htmlspecialchars($mysql_array_decode[1]);

//Guardar el archivo en la ruta especificada
move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/' . $_FILES['file']['name']);
} else {
$json_status = $mysql_array_decode[0];
$json_message = htmlspecialchars($mysql_array_decode[1]);
}
} else {
$json_status = "error";
$json_message = "Error al consultar:1 " . htmlspecialchars($mysql_stmt->error);
}
} else {
$json_status = "error";
$json_message = "Error al consultar:2" . htmlspecialchars($mysql_stmt->error);
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
} else {
echo "mal";
$json_array = array(
'status' => 'error',
'message' => 'Formulario incompleto',
);

echo json_encode($json_array, JSON_FORCE_OBJECT);
exit;
}
}

 */