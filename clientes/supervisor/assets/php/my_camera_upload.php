<?php session_start();
header('Content-Type: application/json');
include $_SERVER["DOCUMENT_ROOT"] . "/clientes/supervisor/assets/php/hoja_private_config.php";

if (isset($_POST["camera_image_base64"]) &&
    isset($_POST['camera_image_folder']) &&
    isset($_POST['camera_image_id']) &&
    isset($_POST['camera_image_rotate']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 4) {
    /*include DOCUMENT_ROOT . '/assets/php/prev_database.php';
    include DOCUMENT_ROOT . '/assets/php/prev_resources.php';*/

    $json_status = "error";
    $json_message = "inicio";
    $json_image_src = "";

    //Base64
    $php_imagen = $_POST['camera_image_base64'];
    $php_carpeta = htmlspecialchars($_POST['camera_image_folder']);
    $php_id_elemento = htmlspecialchars($_POST['camera_image_id']);
    $php_id_usuario = $_SESSION['session_user'][1];
    $php_rotate = htmlspecialchars($_POST['camera_image_rotate']);

    //Elimina data:image/png;base64
    $php_imagen = str_replace('data:image/png;base64,', '', $php_imagen);
    //Remplaza los espacios por un +
    $php_imagen = str_replace(' ', '+', $php_imagen);
    //Decodifica el base64
    $php_nombre = $php_id_elemento . "_" . $php_id_usuario . "_" . time();

    $source = imagecreatefromstring(base64_decode($php_imagen));
    $rotate = imagerotate($source, $php_rotate, 0);
    $php_success = imagepng($rotate, DOCUMENT_ROOT . '/images/' . $php_carpeta . '/' . $php_nombre . '.png');

    if ($php_success) {

        $json_status = "bien";
        $json_message = 'Imagen guardada <br> <b>' . $php_nombre . '.png</b>';
        $json_image_src = '/images/' . $php_carpeta . '/' . $php_nombre . '.png';

        imagedestroy($source);
    }
    // La imagen NO subio al seridor
    else {
        $json_status = "error";
        $json_message = "No se pudo guardar la imagen";
    }

    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
        'src' => $json_image_src,
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
    $datos = array(
        'status' => "Error",
        'results' => "Formulario incompleto",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
}