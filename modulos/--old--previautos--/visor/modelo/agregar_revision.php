<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/previautos/clases/revision_create.php';

$headers = apache_request_headers();

if (
    isset($_POST['form_3_tipo']) &&
    isset($_POST['form_3_numero']) &&
    isset($_POST['form_3_fecha_expedicion']) &&
    isset($_POST['form_3_fecha_vencimiento']) &&
    isset($_POST['form_3_id_vehiculo']) &&
    isset($_FILES['form_3_archivo']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 5 &&
    count($_FILES) == 1
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

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


                // crea la carpeta
                $folder_day = date('d-m-Y');
                $my_folder =  $_SERVER["DOCUMENT_ROOT"] . '/archivos/previautos/servicios/' . $folder_day;
                if (!file_exists($my_folder)) {
                    mkdir($my_folder, 0777, true);

                    $content = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <title>Error - PreviReport</title> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <meta http-equiv="refresh" content="1;url=https://previreport.com" /> </head> <body></body> </html>';
                    file_put_contents($my_folder . '/index.php', $content);
                }

                // sube el archivo

                $name = htmlspecialchars(time() . '_' . clean_file_name($_FILES['form_3_archivo']['name']));
                $size = $_FILES['form_3_archivo']['size'];
                $src = '/archivos/previautos/servicios/' . $folder_day . '/' . $name;

                $is_moved = move_uploaded_file(
                    $_FILES['form_3_archivo']['tmp_name'],
                    $_SERVER["DOCUMENT_ROOT"] . '/archivos/previautos/servicios/' . $folder_day . '/' . $name
                );

                if ($is_moved) {

                    $revision = new CreateRevision($database->myconn);
                    $arrayResponse = $revision->setDatos(
                        htmlspecialchars($_POST['form_3_tipo']),
                        htmlspecialchars($_POST['form_3_numero']),
                        getspecialdate($_POST['form_3_fecha_expedicion']),
                        getspecialdate($_POST['form_3_fecha_vencimiento']),
                        $src,
                        encrypt($_POST['form_3_id_vehiculo'], 2),
                        $_SESSION['session_user'][1]
                    );


                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                } else {
                    $json_status = "mo_moved";
                    $json_message = "ms_moved";
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