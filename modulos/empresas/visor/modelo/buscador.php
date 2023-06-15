<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';

require DOCUMENT_ROOT . '/modulos/assets/clases/empresa/read.php';

$headers = apache_request_headers();
//var_dump($_POST);

if (
    isset($_POST['form_0_filtro']) &&
    isset($_POST['form_0_contenido']) &&
    isset($_POST['form_0_resultados']) &&
    isset($_POST['form_0_estado']) &&
    isset($_POST['form_0_page']) &&
    isset($_POST['form_0_order']) &&
    isset($_POST['form_0_by']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION['session_user']) == 5 &&
    count($_POST) == 7
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

            $empresa = new ReadEmpresa($database->myconn);

            $php_array_filtro = array(
                '0' => "empr.id_empresa",
                '1' => "empr.id_empresa",
                '2' => "empr.nit",
                '3' => "empr.nombre_empresa",
                '4' => "empr.direccion",
                '5' => "empr.correo",
                '6' => "empr.telefono",
            );

            $php_array_order = array(
                'nro' => "empr.id_empresa",
                'nit' => "empr.nit",
                'nombre' => "empr.nombre_empresa",
                'ciudad' => "ciud.nombre_ciudad",
                'estado' => "empr.id_estado",
                'opciones' => "empr.id_empresa",
            );

            $php_array_by = array(
                'asc' => "ASC",
                'desc' => "DESC",
            );

            $form_filtro = getsafearray($php_array_filtro, htmlspecialchars($_POST["form_0_filtro"]), 1);
            $form_contenido = htmlspecialchars($_POST["form_0_contenido"]);
            /*page - order - by - rows */
            $form_estado = htmlspecialchars(($_POST['form_0_estado'] == '0' ? '%%' : $_POST['form_0_estado']));
            $form_page = htmlspecialchars($_POST['form_0_page']);


            $form_order = getsafearray($php_array_order, htmlspecialchars($_POST["form_0_order"]), 1);
            $form_by = getsafearray($php_array_by, htmlspecialchars($_POST["form_0_by"]), 1);
            $form_rows = ($_POST['form_0_resultados']);

            if ($form_filtro == 0) {
                $form_contenido = "%%";
            } else {
                $form_contenido = $form_contenido . "%";
            }
            if ($form_rows == 0) {
                $form_rows = 1000;
            }
            $arrayResponse = $empresa->getEmpresaBuscador(
                array(
                    'ORDER' => $php_array_order[$form_order],
                    'BY' => $php_array_by[$form_by],
                    'PAGE' => $form_page,
                    'ROWS' => $form_rows,
                    'COLUMN' => $php_array_filtro[$form_filtro],
                    'CONTENT' => $form_contenido,
                    'ESTADO' => $form_estado
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

                $json_message = $arrayResponse['empresa'];
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
