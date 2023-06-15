<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/siniestro/read.php';

// var_dump($_POST);

$headers = apache_request_headers();

if (
    isset($_POST['form_0_filtro']) &&
    isset($_POST['form_0_contenido']) &&
    isset($_POST['form_0_tipo_siniestro']) &&
    // isset($_POST['form_0_empresa']) &&
    isset($_POST['form_0_cedula']) &&
    isset($_POST['form_0_resultados']) &&
    isset($_POST['form_0_page']) &&
    isset($_POST['form_0_order']) &&
    isset($_POST['form_0_by']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 8 
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_title = array();
    $json_head = array();
    $json_message = array(); // body
    $json_pagination = array();

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {
        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {
            $database = new dbconnection();
            $database->connect();
            if (strcmp($database->status(), "bien") == 0) {

                $siniestro = new ReadSiniestro($database->myconn);

                $php_array_filtro = array(
                    '0' => "sini.id_siniestro",
                    '1' => "sini.id_siniestro",
                );
                $php_array_order = array(
                    'nro' => "sini.id_siniestro",
                    'placa' => "veh.placa_vehiculo",
                    'fecha' => "sini.fecha_siniestro",
                    'hora' => "sini.hora_siniestro",
                    'tipo' => "tsini.nombre_tipo_siniestro",
                    'empresa' => "empr.nombre_empresa",
                    'conductor' => "con.nombre_conductor",
                    'opciones' => "sini.id_siniestro",
                );
                $php_array_by = array(
                    'asc' => "ASC",
                    'desc' => "DESC",
                );

                $form_filtro = getsafearray($php_array_filtro, htmlspecialchars($_POST["form_0_filtro"]), 1);
                $form_contenido = htmlspecialchars($_POST["form_0_contenido"]);
                $form_empresa = $_SESSION['session_user'][2];
                $form_conductor = htmlspecialchars($_POST["form_0_cedula"]);
                $form_tipo_siniestro = htmlspecialchars($_POST["form_0_tipo_siniestro"]);

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
                if ($form_empresa == 0) {
                    $form_empresa = "%%";
                }
                if ($form_tipo_siniestro == 0) {
                    $form_tipo_siniestro = "%%";
                }
                if ($form_conductor == 0) {
                    $form_conductor = "%%";
                }
                if ($form_rows == 0) {
                    $form_rows = 1000;
                }

                $arrayResponse = $siniestro->getSiniestroBuscador(
                    array(
                        'ORDER' => $php_array_order[$form_order],
                        'BY' => $php_array_by[$form_by],
                        'PAGE' => $from_page,
                        'ROWS' => $form_rows,
                        'COLUMN' => $php_array_filtro[$form_filtro],
                        'CONTENT' => $form_contenido,
                        'TIPO_SINIESTRO' => $form_tipo_siniestro,
                        'CONDUCTOR' => $form_conductor,
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

                    $json_message = $arrayResponse['siniestro'];
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
    } else {
        $json_status = "csrf";
        $json_message = htmlspecialchars($json_host['message']);
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