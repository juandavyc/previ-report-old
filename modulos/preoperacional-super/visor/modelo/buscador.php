<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/modulos/assets/clases/preoperacional/supervisor/read.php';

// var_dump($_POST);

$headers = apache_request_headers();

if (
    isset($_POST['form_0_filtro']) &&
    isset($_POST['form_0_contenido']) &&
    isset($_POST['form_0_empresa']) &&
    isset($_POST['form_0_resultado']) && # APTO-NOAPTO

    isset($_POST['fecha_inicial']) &&
    isset($_POST['fecha_final']) &&
    isset($_POST['filtrar_fecha']) &&

    isset($_POST['form_0_resultados']) &&
    isset($_POST['form_0_page']) &&
    isset($_POST['form_0_order']) &&
    isset($_POST['form_0_by']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 11
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

            $mantenimiento = new ReadPreoperacionalSuper($database->myconn);

            $php_array_filtro = array(
                "preo.id_preoperacional",
                "preo.id_preoperacional",
                // empresa
                "empr.id_empresa",
                "empr.nit",
                // vehiculo 
                "vehi.id_vehiculo",
                "vehi.placa_vehiculo",
                "vehi.numero_licencia_vehiculo",
                "vehi.modelo_vehiculo",
                "vehi.vin_vehiculo",
                "vehi.numero_motor_vehiculo",
                // realiza
                "cond.id_usuario",
                "cond.cedula_usuario",
                "cond.nombre_usuario",
                "cond.apellido_usuario",
                "cond.correo_usuario"
            );
            $php_array_order = array(
                'nro' => "preo.id_preoperacional",
                'placa' => "vehi.placa_vehiculo",
                'empresa' => "empr.nombre_empresa",
                'resultado' => "esta.nombre_estado_preoperacional",
                'realiza' => "cond.id_usuario",
                'agregado' => "preo.fecha_formulario",        
                'opciones' => "preo.id_preoperacional",
            );
            $php_array_by = array(
                'asc' => "ASC",
                'desc' => "DESC",
            );

            $form_filtro = getsafearray($php_array_filtro, htmlspecialchars($_POST["form_0_filtro"]), 1);

            //var_dump($php_array_filtro[$form_filtro]);
            $form_contenido = htmlspecialchars($_POST["form_0_contenido"]);
            $form_empresa = htmlspecialchars($_POST["form_0_empresa"]);
            $form_resultado = htmlspecialchars($_POST["form_0_resultado"]);

            $form_filtrar_fecha = ($_POST["filtrar_fecha"]);
            $form_fecha_inicial = ($form_filtrar_fecha == 1) ? getspecialdate($_POST['fecha_inicial']) : '2000-01-01';
            $form_fecha_final = ($form_filtrar_fecha == 1) ? getspecialdate($_POST['fecha_final']) : '2030-01-01';

            /*page - order - by - rows */
            $form_page = htmlspecialchars($_POST['form_0_page']);
            $form_order = getsafearray($php_array_order, htmlspecialchars($_POST["form_0_order"]), 1);
            $form_by = getsafearray($php_array_by, htmlspecialchars($_POST["form_0_by"]), 1);
            $form_rows = ($_POST['form_0_resultados']);

            if ($form_filtro == 0) {
                $form_contenido = "%%";
            } else {
                $form_contenido = $form_contenido . "%";
            }
            if ($form_empresa == 0) {
                $form_empresa = "%%";
            }
            if ($form_resultado == 0) {
                $form_resultado = "%%";
            }
            if ($form_rows == 0) {
                $form_rows = 1000;
            }

            $arrayResponse = $mantenimiento->getPreoperacionalBuscador(
                array(
                    'ORDER' => $php_array_order[$form_order],
                    'BY' => $php_array_by[$form_by],
                    'PAGE' => $form_page,
                    'ROWS' => $form_rows,
                    'COLUMN' => $php_array_filtro[$form_filtro],
                    'CONTENT' => $form_contenido,
                    'EMPRESA' => $form_empresa,
                    'RESULTADO' => $form_resultado, 
                    'F_INICIAL' => $form_fecha_inicial,
                    'F_FINAL' => $form_fecha_final
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

                $json_message = $arrayResponse['preoperacional'];
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