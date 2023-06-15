<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();
// var_dump($_POST);
if (
    isset($_POST['form_0_filtro']) &&
    isset($_POST['form_0_contenido']) &&
    isset($_POST['form_0_resultados']) &&
    isset($_POST['form_0_page']) &&
    isset($_POST['form_0_order']) &&
    isset($_POST['form_0_by']) &&
    isset($_SESSION["session_user"]) &&
    count($_POST) == 6 &&
    count($_SESSION['session_user']) == 5
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

                $php_array_filtro = array(
                    '0' => "con.id_conductor", // TODO
                    '1' => "con.id_conductor",
                    '2' => "con.nombre_conductor",
                    '3' => "con.numero_documento",
                );

                $php_array_order = array(
                    'nro' => "con.id_conductor",
                    'Nombres' => "con.nombre_conductor",
                    'Apellidos' => "con.apellido_conductor",
                    'Nro Celular' => "con.celular_conductor",
                    'Documento' => "con.numero_documento",
                    'Empresa' => "emp.nombre_empresa",
                    'opciones' => "con.id_conductor",
                );

                $php_array_by = array(
                    'asc' => "ASC",
                    'desc' => "DESC",
                );

                $form_filtro = getsafearray($php_array_filtro, htmlspecialchars($_POST["form_0_filtro"]), 1);
                $form_contenido = htmlspecialchars($_POST["form_0_contenido"]);
                /*page - order - by - rows */
                $form_page = htmlspecialchars($_POST['form_0_page']);
                $form_order = getsafearray($php_array_order, htmlspecialchars($_POST["form_0_order"]), 1);
                $form_by = getsafearray($php_array_by, htmlspecialchars($_POST["form_0_by"]), 1);
                $form_rows = ($_POST['form_0_resultados']);

                $mysql_query_count = "SELECT COUNT(con.id_conductor) As total_rows_count ";

                $mysql_query_colums = "SELECT ";
                $mysql_query_colums .= "con.id_conductor,con.numero_documento, ";
                $mysql_query_colums .= "con.nombre_conductor, con.apellido_conductor, con.celular_conductor, emp.nombre_empresa ";
                $mysql_query = "FROM ";
                $mysql_query .= "conductor con ";
                $mysql_query .="LEFT JOIN empresa_conductor empc ON empc.id_conductor = con.id_conductor ";
                $mysql_query .="AND empc.id_empresa =
                (SELECT id_empresa
                FROM empresa_conductor
                WHERE id_conductor = con.id_conductor
                ORDER BY id_empresa_conductor DESC LIMIT 0,1
                ) ";
                $mysql_query .="LEFT JOIN empresa emp ON emp.id_empresa = empc.id_empresa ";
                $mysql_query .= "WHERE ";
                $mysql_query .= $php_array_filtro[$form_filtro] . " LIKE ?  ";
                $mysql_query .= "GROUP BY " . $php_array_order[$form_order] . " " . $php_array_by[$form_by] . " ";

var_dump($mysql_query);

                $mysql_query_count .= $mysql_query;

                $mysql_query_colums .= $mysql_query;

                if ($form_filtro == 0) {
                    $form_contenido = "%%";
                } else {
                    $form_contenido = $form_contenido . "%";
                }
                if ($form_rows == 0) {
                    $form_rows = 1000;
                }
                $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query_count);
                $mysql_stmt->bind_param(
                    's',
                    $form_contenido
                );
                if ($mysql_stmt->execute()) {

                    $json_status = "bien";
                    $mysql_result = $mysql_stmt->get_result();
                    $mysql_row = $mysql_result->fetch_assoc();
                    $mysql_resultados = $mysql_row['total_rows_count'];

                    if ($mysql_resultados > 0) {

                        $mysql_stmt->close();

                        $php_total_filas = $form_rows;

                        $php_total_pages = ceil($mysql_resultados / $php_total_filas);
                        $php_page = getSafeNumber($form_page, $php_total_pages);

                        $php_desde = (($php_page - 1) * $php_total_filas);

                        $php_desde_ini = 1;
                        $php_contador = (($form_by == 'asc') ? $php_contador = ($mysql_resultados - $php_desde) : ($php_contador = ($php_desde + 1)));

                        $php_limite = $php_desde . "," . $php_total_filas;
                        $mysql_query_colums .= " LIMIT " . $php_limite . ";";


                        $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query_colums);

                        $mysql_stmt->bind_param(
                            's',
                            $form_contenido
                        );

                        if ($mysql_stmt->execute()) {

                            $result = $mysql_stmt->get_result();

                            $json_title = array(
                                "total" => intval($mysql_resultados),
                                "page" => intval($php_page),
                                "total_pages" => intval($php_total_pages),
                            );
                            $json_head = array(
                                "fields" => array_keys($php_array_order),
                                "order" => $form_order,
                                "by" => $form_by,
                            );

                            while ($fila = $result->fetch_assoc()) {
                                $json_message[$php_desde_ini] = array(
                                    "nro" => htmlspecialchars($php_contador),
                                    "Nombres" => htmlspecialchars($fila['nombre_conductor']),
                                    "Apellidos" => htmlspecialchars($fila['apellido_conductor']),
                                    "Nro Celular" => htmlspecialchars($fila['celular_conductor']),
                                    "Documento" => htmlspecialchars($fila['numero_documento']),
                                    "Empresa" => htmlspecialchars($fila['nombre_empresa']),
                                    "opciones" => encrypt($fila['id_conductor'],1),
                                );

                                // var_dump(encrypt($fila['id_conductor'],1));

                                $php_desde_ini++;
                                $res = (($form_by == 'asc') ? $php_contador-- : $php_contador++);
                            }

                            $json_pagination = array("pages" => intval($php_page), "total_pages" => intval($php_total_pages));
                        } else {
                            $json_status = "error";
                            $json_message = "Error en la consulta # 2:<br> " . htmlspecialchars($mysql_stmt->error);
                        }

                    } else {
                        $json_status = "sin_resultados";
                        $json_message = "Sin resultados para la busqueda";
                    }
                } else {
                    $json_status = "error";
                    $json_message = "Error en la consulta # 1:<br> " . htmlspecialchars($mysql_stmt->error);
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