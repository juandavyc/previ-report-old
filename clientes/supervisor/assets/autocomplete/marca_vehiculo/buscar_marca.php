<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

if (isset($_POST["palabra"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 1
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_options = array();

    $php_desde_ini = 0;

    if (isset($headers['csrf-token']) && hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $mysql_query = "SELECT ";
            $mysql_query .= "id_marca,nombre_marca ";
            $mysql_query .= "FROM ";
            $mysql_query .= "marca ";
            $mysql_query .= "WHERE ";
            $mysql_query .= "nombre_marca LIKE ? LIMIT 5;";

            $form_palabra = strtoupper(htmlspecialchars($_POST["palabra"]) . "%");

            $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
            $mysql_stmt->bind_param('s', $form_palabra);

            if ($mysql_stmt->execute()) {

                $mysql_result = $mysql_stmt->get_result();

                if (mysqli_num_rows($mysql_result) > 0) {
                    $json_status = "bien";
                    while ($fila = $mysql_result->fetch_assoc()) {
                        $json_options[$php_desde_ini] = array(
                            "id" => htmlspecialchars($fila['id_marca']),
                            "nombre" => htmlspecialchars($fila['nombre_marca']),
                        );

                        $php_desde_ini++;
                    }
                } else {
                    $json_status = "sin_resultado";
                    $json_options[0] = array(
                        "id" => 0,
                        "nombre" => "SIN RESULTADOS",
                    );
                }
                $mysql_stmt->close();
            }

            $database->close();

        } else {
            $json_status = "base_de_datos";
            $json_options[0] = array(
                "id" => 0,
                "nombre" => "Imposible conectar a la base de datos",
            );
        }

    } else {
        $json_status = "csrf";
        $json_options = htmlspecialchars("Wrong CSRF token.");
    }

    $datos = array(
        'status' => $json_status,
        'options' => $json_options,
        'count' => $php_desde_ini,
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'options' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'options' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}