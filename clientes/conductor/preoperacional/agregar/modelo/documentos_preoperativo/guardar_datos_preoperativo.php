<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/clientes/conductor/assets/clases/preoperacional/mecanico/update.php';

// var_dump($_POST);

// foreach ($_POST as $key => $value) {
//     echo 'isset($_POST['.`"`.$key.`"`.']) && <br>'; 
// }


$headers = apache_request_headers();

if (
    isset($_POST["form_1_vigencia_tarjeta_propiedad"]) &&
    isset($_POST["form_1_entidad_tarjeta_propiedad"]) &&
    isset($_POST["form_1_fecha_vencimiento_tarjeta_propiedad"]) &&
    isset($_POST["form_1_vigencia_rtm"]) &&
    isset($_POST["form_1_entidad_rtm"]) &&
    isset($_POST["form_1_fecha_vencimiento_rtm"]) &&
    isset($_POST["form_1_vigencia_certificado_gases"]) &&
    isset($_POST["form_1_entidad_gases"]) &&
    isset($_POST["form_1_fecha_vencimiento_gases"]) &&
    isset($_POST["form_1_vigencia_fuec"]) &&
    isset($_POST["form_1_entidad_fuec"]) &&
    isset($_POST["form_1_fecha_vencimiento_fuec"]) &&
    isset($_POST["form_1_vigencia_licencia_conduccion"]) &&
    isset($_POST["form_1_entidad_licencia_conduccion"]) &&
    isset($_POST["form_1_fecha_vencimiento_licencia_conductor"]) &&
    isset($_POST["form_1_vigencia_poliza"]) &&
    isset($_POST["form_1_entidad_poliza"]) &&
    isset($_POST["form_1_fecha_vencimiento_poliza"]) &&
    isset($_POST["form_1_vigencia_soat"]) &&    
    isset($_POST["form_1_entidad_poliza_soat"]) &&
    isset($_POST["form_1_fecha_vencimiento_poliza_soat"]) &&
    isset($_POST["form_1_foto_tacometro_kilometraje"]) &&
    isset($_POST["form_1_foto_tacometro_combustible"]) &&
    isset($_POST["id_preoperativo"]) && 
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 24 
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

// var_dump($_POST["id_preoperativo"]);
                
                $preoperacional = new UpdatePreoperacional($database->myconn);
                $arrayResponse = $preoperacional->setInformacionPreoperacional(
                    array(
                        'ID' => encrypt($_POST['id_preoperativo'],2),
                        'VIGENCIA_TARJETA' => htmlspecialchars($_POST['form_1_vigencia_tarjeta_propiedad']),
                        'ENTIDAD_TARJETA' => htmlspecialchars($_POST['form_1_entidad_tarjeta_propiedad']),
                        'FECHA_TARJETA' => getspecialdate($_POST['form_1_fecha_vencimiento_tarjeta_propiedad']),
                        'VIGENCIA_RTM' => htmlspecialchars($_POST['form_1_vigencia_rtm']),
                        'ENTIDAD_RTM' => htmlspecialchars($_POST['form_1_entidad_rtm']),
                        'FECHA_RTM' => getspecialdate($_POST['form_1_fecha_vencimiento_rtm']),
                        'VIGENCIA_GASES' => htmlspecialchars($_POST['form_1_vigencia_certificado_gases']),
                        'ENTIDAD_GASES' => htmlspecialchars($_POST['form_1_entidad_gases']),
                        'FECHA_GASES' => getspecialdate($_POST['form_1_fecha_vencimiento_gases']),
                        'VIGENCIA_FUEC' => htmlspecialchars($_POST['form_1_vigencia_fuec']),
                        'ENTIDAD_FUEC' => htmlspecialchars($_POST['form_1_entidad_fuec']),
                        'FECHA_FUEC' => getspecialdate($_POST['form_1_fecha_vencimiento_fuec']),
                        'VIGENCIA_LICENCIA' => htmlspecialchars($_POST['form_1_vigencia_licencia_conduccion']),
                        'ENTIDAD_LICENCIA' => htmlspecialchars($_POST['form_1_entidad_licencia_conduccion']),
                        'FECHA_LICENCIA' => getspecialdate($_POST['form_1_fecha_vencimiento_licencia_conductor']),
                        'VIGENCIA_POLIZA' => htmlspecialchars($_POST['form_1_vigencia_poliza']),
                        'ENTIDAD_POLIZA' => htmlspecialchars($_POST['form_1_entidad_poliza']),
                        'FECHA_POLIZA' => getspecialdate($_POST['form_1_fecha_vencimiento_poliza']),
                        'VIGENCIA_SOAT' => htmlspecialchars($_POST['form_1_vigencia_soat']),
                        'ENTIDAD_SOAT' => htmlspecialchars($_POST['form_1_entidad_poliza_soat']),
                        'FECHA_SOAT' => getspecialdate($_POST['form_1_fecha_vencimiento_poliza_soat']),
                        'FOTO_KILOMETRAJE' => htmlspecialchars($_POST['form_1_foto_tacometro_kilometraje']),
                        'FOTO_COMBUSTIBLE' => htmlspecialchars($_POST['form_1_foto_tacometro_combustible']),
                        'ID_USUARIO' => $_SESSION['session_user'][1],
                    )
                );
                if ($arrayResponse['status'] == 'bien') {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
                } else {
                    $json_status = $arrayResponse['status'];
                    $json_message = $arrayResponse['message'];
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