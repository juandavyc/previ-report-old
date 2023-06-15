<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/vehiculo/update.php';
// var_dump(DOCUMENT_ROOT . '/modulos/assets/clases/vehiculo/update.php');
$headers = apache_request_headers();
if (
    isset($_POST["form_1_licencia_transito"]) &&
    isset($_POST["form_1_estado_del_vehiculo"]) &&
    isset($_POST["form_1_servicio_vehiculo"]) &&
    isset($_POST["form_1_clase_vehiculo"]) &&
    isset($_POST["form_1_empresa"]) &&
    isset($_POST["form_1_marca_vehiculo"]) &&
    isset($_POST["form_1_linea_vehiculo"]) &&
    isset($_POST["form_1_modelo_vehiculo"]) &&
    isset($_POST["form_1_color_vehiculo"]) &&
    isset($_POST["form_1_serie_vehiculo"]) &&
    isset($_POST["form_1_motor_vehiculo"]) &&
    isset($_POST["form_1_vin_vehiculo"]) &&
    isset($_POST["form_1_carroceria_vehiculo"]) &&
    isset($_POST["form_1_combustible_vehiculo"]) &&
    isset($_POST["form_1_cilindraje_vehiculo"]) &&
    isset($_POST["form_1_fecha_matricula"]) &&
    isset($_POST["form_1_autoridad_de_transito"]) &&
    isset($_POST["form_1_gravamenes_a_la_propiedad"]) &&
    isset($_POST["form_1_clasico_o_antiguo"]) &&
    isset($_POST["form_1_repotenciado"]) &&
    isset($_POST["form_1_vehiculo_ensenianza"]) &&
    isset($_POST["form_1_regrabacion_motor"]) &&
    isset($_POST["form_1_numero_regrabacion_motor"]) &&
    isset($_POST["form_1_regrabacion_chasis"]) &&
    isset($_POST["form_1_numero_regrabacion_chasis"]) &&
    isset($_POST["form_1_regrabacion_serie"]) &&
    isset($_POST["form_1_numero_regrabacion_serie"]) &&
    isset($_POST["form_1_regrabacion_vin"]) &&
    isset($_POST["form_1_numero_regrabacion_vin"]) &&
    isset($_POST["form_1_id_vehiculo"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 30
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

            $vehiculo = new UpdateVehiculo($database->myconn);

            $form_1_licencia_vehiculo = htmlspecialchars($_POST['form_1_licencia_transito']);
            $form_1_estado_vehiculo = htmlspecialchars($_POST['form_1_estado_del_vehiculo']);
            $form_1_servicio_vehiculo = htmlspecialchars($_POST['form_1_servicio_vehiculo']);
            $form_1_clase_vehiculo = htmlspecialchars($_POST['form_1_clase_vehiculo']);
            $form_1_empresa = htmlspecialchars($_POST['form_1_empresa']);
            $form_1_marca_vehiculo = htmlspecialchars($_POST['form_1_marca_vehiculo']);
            $form_1_linea_vehiculo = htmlspecialchars($_POST['form_1_linea_vehiculo']);
            $form_1_modelo_vehiculo = htmlspecialchars($_POST['form_1_modelo_vehiculo']);
            $form_1_color_vehiculo = htmlspecialchars($_POST['form_1_color_vehiculo']);
            $form_1_serie_vehiculo = htmlspecialchars($_POST['form_1_serie_vehiculo']);
            $form_1_motor_vehiculo = htmlspecialchars($_POST['form_1_motor_vehiculo']);
            $form_1_vin_vehiculo = htmlspecialchars($_POST['form_1_vin_vehiculo']);
            $form_1_carroceria_vehiculo = htmlspecialchars($_POST['form_1_carroceria_vehiculo']);
            $form_1_cilindraje_vehiculo = htmlspecialchars($_POST['form_1_cilindraje_vehiculo']);
            $form_1_combustible_vehiculo = htmlspecialchars($_POST['form_1_combustible_vehiculo']);
            $form_1_fecha_matricula_vehiculo = getspecialdate($_POST['form_1_fecha_matricula']);
            $form_1_autoridad_de_transito_vehiculo = htmlspecialchars($_POST['form_1_autoridad_de_transito']);
            $form_1_gravamenes_a_la_propiedad = htmlspecialchars($_POST['form_1_gravamenes_a_la_propiedad']);
            $form_1_clasico_o_antiguo = htmlspecialchars($_POST['form_1_clasico_o_antiguo']);
            $form_1_repotenciado_vehiculo = htmlspecialchars($_POST['form_1_repotenciado']);

            $form_1_vehiculo_ensenianza = htmlspecialchars($_POST['form_1_vehiculo_ensenianza']);
            $form_1_regrabacion_motor_vehiculo = htmlspecialchars($_POST['form_1_regrabacion_motor']);
            $form_1_numero_regrabacion_motor_vehiculo = htmlspecialchars($_POST['form_1_numero_regrabacion_motor']);
            $form_1_regrabacion_chasis_vehiculo = htmlspecialchars($_POST['form_1_regrabacion_chasis']);
            $form_1_numero_regrabacion_chasis_vehiculo = htmlspecialchars($_POST['form_1_numero_regrabacion_chasis']);

            $form_1_regrabacion_serie_vehiculo = htmlspecialchars($_POST['form_1_regrabacion_serie']);
            $form_1_numero_regrabacion_serie_vehiculo = htmlspecialchars($_POST['form_1_numero_regrabacion_serie']);
            $form_1_regrabacion_vin_vehiculo = htmlspecialchars($_POST['form_1_regrabacion_vin']);
            $form_1_numero_regrabacion_vin_vehiculo = htmlspecialchars($_POST['form_1_numero_regrabacion_vin']);
            $form_1_id_vehiculo_datos = htmlspecialchars(encrypt($_POST['form_1_id_vehiculo'], 2));

            $arrayResponse = $vehiculo->setInformacionBasica(
                $form_1_licencia_vehiculo,
                $form_1_estado_vehiculo,
                $form_1_servicio_vehiculo,
                $form_1_clase_vehiculo,
                $form_1_empresa,
                $form_1_marca_vehiculo,
                $form_1_linea_vehiculo,
                $form_1_modelo_vehiculo,
                $form_1_color_vehiculo,
                $form_1_serie_vehiculo,
                $form_1_motor_vehiculo,
                $form_1_vin_vehiculo,
                $form_1_carroceria_vehiculo,
                $form_1_cilindraje_vehiculo,
                $form_1_combustible_vehiculo,
                $form_1_fecha_matricula_vehiculo,
                $form_1_autoridad_de_transito_vehiculo,
                $form_1_gravamenes_a_la_propiedad,
                $form_1_clasico_o_antiguo,
                $form_1_repotenciado_vehiculo,
                $form_1_vehiculo_ensenianza,
                $form_1_regrabacion_motor_vehiculo,
                $form_1_numero_regrabacion_motor_vehiculo,
                $form_1_regrabacion_chasis_vehiculo,
                $form_1_numero_regrabacion_chasis_vehiculo,
                $form_1_regrabacion_serie_vehiculo,
                $form_1_numero_regrabacion_serie_vehiculo,
                $form_1_regrabacion_vin_vehiculo,
                $form_1_numero_regrabacion_vin_vehiculo,
                $form_1_id_vehiculo_datos,
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
