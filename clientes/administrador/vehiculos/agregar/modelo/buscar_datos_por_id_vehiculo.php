<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';

$headers = apache_request_headers();
if (
    isset($_POST['id_accordion']) &&
    isset($_POST['id_vehiculo']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/administrador/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = array();
    $arrayResponse = array();

    $json_host = getposturl($headers['Origin']);

    if ($json_host['status'] == "ok") {

        if (
            isset($headers['csrf-token']) &&
            hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
        ) {

            $database = new dbconnection();
            $database->connect();

            if (strcmp($database->status(), "bien") == 0) {

                $id_vehiculo = htmlspecialchars(encrypt($_POST['id_vehiculo'], 2));
                $id_accordion = htmlspecialchars($_POST['id_accordion']);

                /* data-id = 1 */
                /* Información del vehículo */

                if ($id_accordion == 1) {
                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/vehiculo/read.php';
                    $vehiculo = new ReadVehiculo($database->myconn);
                    $arrayResponse = $vehiculo->getVehiculo(
                        array(
                            'TYPE' => 'ID',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,1'
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['vehiculo'];
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 2) {
                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/certificado_rtm/read.php';
                    $certificado = new ReadCertificadoRTM($database->myconn);
                    $arrayResponse = $certificado->getCertificadoRTM(
                        array(
                            'TYPE' => 'ID_VEHICULO',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];

                        foreach ($arrayResponse['certificado_rtm'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "certificado" => ($value['numero']),
                                    "expedicion" => ($value['fecha_expedicion']),
                                    "vencimiento" => ($value['fecha_vencimiento']),
                                    "cda" => ($value['cda']['nombre']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 3) {
                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/poliza_soat/read.php';
                    $soat = new ReadPolizaSoat($database->myconn);
                    $arrayResponse = $soat->getPolizaSoat(
                        array(
                            'TYPE' => 'ID_VEHICULO',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,20'
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['poliza_soat'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "certificado" => ($value['numero']),
                                    "expedicion" => ($value['fecha_expedicion']),
                                    "vencimiento" => ($value['fecha_vencimiento']),
                                    "aseguradora" => ($value['aseguradora']['nombre']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 4) {
                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/datos_tecnicos_vehiculo/read.php';
                    $datosVehiculo = new ReadDatosVehiculo($database->myconn);
                    $arrayResponse = $datosVehiculo->getDatosVehiculo(
                        array(
                            'TYPE' => 'ID',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,1'
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['datos_tecnicos'];
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 5) {
                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/revision_preventiva/read.php';
                    $preventiva = new ReadRevisionPreventiva($database->myconn);
                    $arrayResponse = $preventiva->getRevisionPreventiva(
                        array(
                            'TYPE' => 'ID_VEHICULO',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,20'
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['preventiva'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "numero" => ($value['numero']),
                                    "expedicion" => ($value['fecha_expedicion']),
                                    "vencimiento" => ($value['fecha_vencimiento']),
                                    "aseguradora" => ($value['lugar']['nombre']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 6) {

                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/tarjeta_operacion/read.php';
                    $preventiva = new ReadTarjetaOperacion($database->myconn);
                    $arrayResponse = $preventiva->getTarjetaOperacion(
                        array(
                            'TYPE' => 'ID_VEHICULO',
                            'VALUE' => $id_vehiculo,
                        ),
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['tarjeta_operacion'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "empresa" => ($value['empresa']['nombre']),
                                    "numero" => ($value['numero']),
                                    "expedicion" => ($value['fecha_expedicion']),
                                    "vencimiento" => ($value['fecha_vencimiento']),
                                    "estado" => ($value['estado']['nombre']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion == 7) {

                    require DOCUMENT_ROOT . '/clientes/administrador/assets/clases/poliza/read_c.php';
                    $preventiva = new Poliza($database->myconn);
                    $arrayResponse = $preventiva->getPolizaVehiculo(
                        $id_vehiculo,
                        1,
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        foreach ($arrayResponse['poliza'] as $key => $value) {
                            array_push(
                                $json_message, array(
                                    "nro" => ($key + 1),
                                    "numero" => ($value['numero']),
                                    "aseguradora" => ($value['aseguradora']['nombre']),
                                    "tipo" => ($value['tipo']['nombre']),
                                    "expedicion" => ($value['expedicion_poliza']),
                                    "vencimiento" => ($value['vencimiento_polzia']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_accordion >= 8) {

                    if ($id_accordion == 8) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "cert.id_certificado As id, ";
                        $mysql_query .= "cert.numero_certificado As Numero, ";
                        $mysql_query .= "enti.nombre_entidad_certificado As Entidad, ";
                        $mysql_query .= "tipo.nombre_tipo_certificado As Tipo, ";
                        $mysql_query .= "cert.fecha_expedicion_certificado As expedicion, ";
                        $mysql_query .= "cert.fecha_vencimiento_certificado As vecimiento, ";
                        $mysql_query .= "cert.id_certificado As opciones ";
                        $mysql_query .= "FROM certificado cert ";
                        $mysql_query .= "LEFT JOIN entidad_certificado enti ON enti.id_entidad_certificado = cert.id_entidad_certificado ";
                        $mysql_query .= "LEFT JOIN tipo_certificado tipo ON tipo.id_tipo_certificado = cert.id_tipo_certificado ";
                        $mysql_query .= "WHERE cert.id_vehiculo = ? ";
                        $mysql_query .= "AND cert.is_visible = 1  ";
                        $mysql_query .= "ORDER BY cert.id_certificado DESC;";
                        // echo $mysql_query;

                    } else if ($id_accordion == 9) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "soli.id_solicitud As id, ";
                        $mysql_query .= "soli.numero_solicitud As Numero, ";
                        $mysql_query .= "enti.nombre_entidad_transito As Entidad, ";
                        $mysql_query .= "tipo.nombre_tipo_solicitud As Tipo, ";
                        $mysql_query .= "soli.fecha_solicitud As Solicitud, ";
                        $mysql_query .= "esta.nombre_estado_solicitud As Estado, ";
                        $mysql_query .= "soli.id_solicitud As opciones ";
                        $mysql_query .= "FROM solicitud soli ";
                        $mysql_query .= "LEFT JOIN entidad_transito enti ON enti.id_entidad_transito = soli.id_entidad_transito ";
                        $mysql_query .= "LEFT JOIN tipo_solicitud tipo ON tipo.id_tipo_solicitud = soli.id_tipo_solicitud ";
                        $mysql_query .= "LEFT JOIN estado_solicitud esta ON esta.id_estado_solicitud = soli.id_estado_solicitud ";
                        $mysql_query .= "WHERE soli.id_vehiculo = ? ";
                        $mysql_query .= "AND soli.is_visible = 1  ";
                        $mysql_query .= "ORDER BY soli.id_solicitud DESC;";
                        //echo $mysql_query;

                    } else if ($id_accordion == 10) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "foto_delantera,foto_trasera, ";
                        $mysql_query .= "foto_costado_izquierdo,foto_costado_derecho ";
                        $mysql_query .= "FROM vehiculo ";
                        $mysql_query .= "WHERE id_vehiculo = ?;";
                        //echo $mysql_query;
                    } else if ($id_accordion == 11) {

                          $mysql_query = "SELECT ";
                        $mysql_query .= "impronta_chasis,impronta_serial, ";
                        $mysql_query .= "impronta_motor,impronta_opcional_1, ";
                        $mysql_query .= "impronta_opcional_2,impronta_opcional_3 ";
                        $mysql_query .= "FROM vehiculo ";
                        $mysql_query .= "WHERE id_vehiculo = ?;";
                        //echo $mysql_query;
                    } else if ($id_accordion == 12) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "licencia_transito_delantera,licencia_transito_trasera ";
                        $mysql_query .= "FROM vehiculo ";
                        $mysql_query .= "WHERE id_vehiculo = ?;";
                        //echo $mysql_query;
                    }

                    $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                    $mysql_stmt->bind_param('s', $id_vehiculo);

                    if ($mysql_stmt->execute()) {

                        $mysql_result = $mysql_stmt->get_result();
                        $mysql_rowcount = mysqli_num_rows($mysql_result);
                        // Con resultados
                        if ($mysql_rowcount > 0) {
                            $json_status = "bien";
                            $json_message = (mysqli_fetch_all($mysql_result, MYSQLI_ASSOC));
                        }
                        // Sin resultados
                        else {
                            $json_status = "sin_resultados";
                            $json_message = "Sin resultados";
                        }
                    } else {
                        $json_status = "error";
                        $json_message = "Error en la consulta " . htmlspecialchars($mysql_stmt->error);
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