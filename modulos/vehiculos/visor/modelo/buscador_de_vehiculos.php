<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/vehiculo/read.php';
$headers = apache_request_headers();
if (
    isset($_POST['form_0_filtro']) &&
    isset($_POST['form_0_contenido']) &&
    isset($_POST['form_0_tipo']) &&
    isset($_POST['form_0_servicio']) &&
    isset($_POST['form_0_resultados']) &&
    isset($_POST['form_0_empresa']) &&
    isset($_POST['form_0_page']) &&
    isset($_POST['form_0_order']) &&
    isset($_POST['form_0_by']) &&
    isset($_SESSION["session_user"]) &&
    count($_POST) == 9 &&
    count($_SESSION['session_user']) == 5
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_title = array();
    $json_head = array();
    $json_message = array(); // body
    $json_pagination = array();

    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {
        $database = new dbconnection();
        $database->connect();
        if (strcmp($database->status(), "bien") == 0) {

            $vehiculo = new ReadVehiculo($database->myconn);

            $php_array_filtro = array(
                '0' => "veh.id_vehiculo", // TODO
                '1' => "veh.id_vehiculo",
                '2' => "veh.placa_vehiculo",
                '3' => "veh.numero_licencia_vehiculo",
                '4' => "veh.modelo_vehiculo",
                '5' => "veh.vin_vehiculo",
                '6' => "veh.numero_motor_vehiculo"
            );

            $php_array_order = array(
                'nro' => "veh.id_vehiculo",
                'placa' => "veh.placa_vehiculo",
                'tipo' => "tveh.nombre_tipo_vehiculo",
                'servicio' => "ser.nombre_servicio",
                'clase' => "cla.nombre_clase",
                'empresa' => "empr.nombre_empresa",
                'creado' => "veh.fecha_formulario",
                'opciones' => "veh.id_vehiculo"
            );

            $php_array_by = array(
                'asc' => "ASC",
                'desc' => "DESC",
            );

            $form_filtro = getsafearray($php_array_filtro, htmlspecialchars($_POST["form_0_filtro"]), 1);
            $form_contenido = htmlspecialchars($_POST["form_0_contenido"]);
            $form_tipo_vehiculo = htmlspecialchars($_POST["form_0_tipo"]);
            $form_servicio = htmlspecialchars($_POST["form_0_servicio"]);
            $form_empresa = htmlspecialchars($_POST["form_0_empresa"]);

            /*page - order - by - rows */
            $from_page = htmlspecialchars($_POST['form_0_page']);
            $form_order = getsafearray($php_array_order, htmlspecialchars($_POST["form_0_order"]), 1);
            $form_by = getsafearray($php_array_by, htmlspecialchars($_POST["form_0_by"]), 1);
            $form_rows = ($_POST['form_0_resultados']);

            if ($form_filtro == 0) {
                $form_contenido = "%%";
            } else {
                $form_contenido = $form_contenido . "%";
            }
            if ($form_tipo_vehiculo == 0) {
                $form_tipo_vehiculo = "%%";
            }
            if ($form_servicio == 0) {
                $form_servicio = "%%";
            }
            if ($form_empresa == 0) {
                $form_empresa = "%%";
            }
            if ($form_rows == 0) {
                $form_rows = 1000;
            }
            $arrayResponse = $vehiculo->getVehiculoBuscador(
                array(
                    'ORDER' => $php_array_order[$form_order],
                    'BY' => $php_array_by[$form_by],
                    'PAGE' => $from_page,
                    'ROWS' => $form_rows,
                    'COLUMN' => $php_array_filtro[$form_filtro],
                    'CONTENT' => $form_contenido,
                    'TIPO' => $form_tipo_vehiculo,
                    'SERVICIO' => $form_servicio,
                    'EMPRESA' => $form_empresa,
                )
            );

            if ($arrayResponse['status'] == 'bien') {
                $json_status = "bien";

                $json_title = array(
                    "total" => intval($arrayResponse['elements']['SQL_ROWS']),
                    "page" => intval($arrayResponse['elements']['SQL_PAGE']),
                    "total_pages" => intval($arrayResponse['elements']['SQL_TOTAL_PAGES']),
                );
                $json_head = array(
                    "fields" => array_keys($php_array_order),
                    "order" => $form_order,
                    "by" => $form_by,
                );

                $json_message = $arrayResponse['vehiculo'];
                // var_dump($arrayResponse['siniestro']);
                $json_pagination = array(
                    "pages" => intval($arrayResponse['elements']['SQL_PAGE']),
                    "total_pages" => intval($arrayResponse['elements']['SQL_TOTAL_PAGES']),
                );
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


    $json_response = array(
        'status' => $json_status,
        'title' => $json_title,
        'head' => $json_head,
        'body' => $json_message,
        'pages' => $json_pagination,
    );
    echo json_encode($json_response);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $json_response = array(
        'status' => "session",
        'body' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($json_response, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_response = array(
        'status' => "Error",
        'body' => "Formulario incompleto",
    );
    echo json_encode($json_response, JSON_FORCE_OBJECT);
    exit;
}