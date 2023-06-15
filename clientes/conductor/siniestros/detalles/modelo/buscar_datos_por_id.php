<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

require DOCUMENT_ROOT . '/clientes/conductor/assets/clases/siniestro/read.php';
require DOCUMENT_ROOT . '/clientes/conductor/assets/clases/agente/read.php';
require DOCUMENT_ROOT . '/clientes/conductor/assets/clases/testigo/read.php';
require DOCUMENT_ROOT . '/clientes/conductor/assets/clases/vehiculo_implicado/read.php';

if (
    isset($_POST['id_accordion']) &&
    isset($_POST['id_siniestro']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/clientes/conductor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/conductor/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();
    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                $id_siniestro = encrypt($_POST['id_siniestro'], 2);
                $id_accordion = htmlspecialchars($_POST['id_accordion']);

                /* data-id = 1 */
                /* Información del vehículo */

                if ($id_accordion == 0) {
                    $siniestro = new ReadSiniestro($database->myconn);
                    $arrayResponse = $siniestro->getSiniestroInformacion(
                        array(
                            'TYPE' => 'ID',
                            'VALUE' => $id_siniestro,
                        )
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['siniestro'];

                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 1) {

                    $agente = new ReadAgente($database->myconn);
                    $arrayResponse = $agente->getAgente(
                        array(
                            'TYPE' => 'ID_SINIESTRO',
                            'VALUE' => $id_siniestro,
                        )
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['agente'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "nombre" => ($value['nombre']),
                                    "telefono" => ($value['telefono']),
                                    "correo" => ($value['correo']),
                                    "opciones" => ($value['id']),
                                )
                            );
                        }

                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 2) {

                    $testigo = new ReadTestigo($database->myconn);
                    $arrayResponse = $testigo->getTestigo(
                        array(
                            'TYPE' => 'ID_SINIESTRO',
                            'VALUE' => $id_siniestro,
                        )
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['testigo'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "nombre" => ($value['nombre']),
                                    "telefono" => ($value['telefono']),
                                    "correo" => ($value['correo']),
                                    "direccion" => ($value['direccion']),
                                    "opciones" => ($value['id']),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 3) {

                    $vehiculo = new ReadVehiculoImplicado($database->myconn);
                    $arrayResponse = $vehiculo->getVehiculoImplicado(
                        array(
                            'TYPE' => 'ID_SINIESTRO',
                            'VALUE' => $id_siniestro,
                        )
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['vehiculo'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "placa" => ($value['placa']),
                                    "marca" => ($value['marca']),
                                    "conductor" => ($value['conductor']),
                                    "aseguradora" => ($value['aseguradora']),
                                    "opciones" => ($value['id']),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
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
        'results' => "La sesión fue cerrada, inicie sesión nuevamente.",
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