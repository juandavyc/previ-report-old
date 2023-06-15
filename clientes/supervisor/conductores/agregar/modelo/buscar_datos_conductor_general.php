<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
$headers = apache_request_headers();

// var_dump($_POST);

if (
    isset($_POST['id_conductor']) &&
    isset($_POST['id_consulta']) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 2
) {

    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hdv_resources.php';

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

                $id_consulta = htmlspecialchars($_POST['id_consulta']);

                $id_conductor = htmlspecialchars(strtoupper(encrypt($_POST["id_conductor"], 2)));
                // consulta para retornar datos basicos de conductor
                if (strcmp($id_consulta, "1") == 0) {

                    require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/datos_conductor/read_id_conductor.php';
                    $conductor = new readConductor($database->myconn);
                    $arrayResponse = $conductor->getConductor(
                        array(
                            'TYPE' => 'CONDUCTOR',
                            'VALUE' => $id_conductor,
                            'LIMIT' => '0,1',
                        )
                    );
                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['conductor'];
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }

                    // Consulta para retornar datos de emergencia de conductor
                } else if (strcmp($id_consulta, "2") == 0) {
                    require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/contacto_emergencia/read.php';

                    $conductor_emergencia = new ReadContactoEmergencia($database->myconn);
                    $arrayResponse = $conductor_emergencia->getContacto(
                        array(
                            'TYPE' => 'ID_CONDUCTOR',
                            'VALUE' => $id_conductor,
                        ),
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];

                        foreach ($arrayResponse['contacto_emergencia'] as $key => $value) {
                            array_push(
                                $json_message,
                                array(
                                    "nro" => ($key + 1),
                                    "nombre" => ($value['nombre']),
                                    "telefono" => ($value['telefono']),
                                    "parentesco" => ($value['parentesco']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }

                    // Consulta para retornar datos de afiliaciones de conductor
                } else if (strcmp($id_consulta, "3") == 0) {

                    require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/eps/read.php';

                    $eps = new ReadEps($database->myconn);
                    $arrayResponse = $eps->getEps(
                        array(
                            'TYPE' => 'ID_CONDUCTOR',
                            'VALUE' => $id_conductor,
                        ),
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];

                        foreach ($arrayResponse['eps'] as $key => $value) {
                            array_push(
                                $json_message,
                                array(
                                    "nro" => ($key + 1),
                                    "nombre" => ($value['nombre']),
                                    "fecha_afiliacion" => ($value['fecha_afiliacion']),
                                    "estado" => ($value['estado']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }

                    // var_dump($mysql_query);

                } else if (strcmp($id_consulta, "4") == 0) {

                    require DOCUMENT_ROOT . '/clientes/supervisor/assets/clases/arl/read.php';

                    $arl = new ReadArl($database->myconn);
                    $arrayResponse = $arl->getArl(
                        array(
                            'TYPE' => 'ID_CONDUCTOR',
                            'VALUE' => $id_conductor,
                        ),
                        '0,20'
                    );

                    if ($arrayResponse['status'] == 'bien') {
                        $json_status = $arrayResponse['status'];

                        foreach ($arrayResponse['arl'] as $key => $value) {
                            array_push(
                                $json_message,
                                array(
                                    "nro" => ($key + 1),
                                    "nombre" => ($value['nombre']),
                                    "fecha_afiliacion" => ($value['fecha_afiliacion']),
                                    "estado" => ($value['estado']),
                                    "opciones" => encrypt($value['id'], 1),
                                )
                            );
                        }
                    } else {
                        $json_status = $arrayResponse['status'];
                        $json_message = $arrayResponse['message'];
                    }
                } else if ($id_consulta >= 5) {

                    if ($id_consulta == 5) {
                        $mysql_query = "SELECT ";
                        $mysql_query .= "fdpc.id_fondo_pension_conductor As id, ";
                        $mysql_query .= "fdp.nombre_fondo_pension As nombre,";
                        $mysql_query .= "fdpc.fecha_afiliacion_fondo_pension As fecha_afiliacion, ";
                        $mysql_query .= "efdp.nombre_estado_fondo_pension As estado_fdp, ";
                        $mysql_query .= "fdpc.id_fondo_pension_conductor As opciones  ";
                        $mysql_query .= "FROM fondo_pension_conductor fdpc ";
                        $mysql_query .= "INNER JOIN fondo_pension fdp ON fdp.id_fondo_pension = fdpc.id_fondo_pension ";
                        $mysql_query .= "INNER JOIN estado_fondo_pension efdp ON efdp.id_estado_fondo_pension = fdpc.id_estado_fondo_pension ";
                        $mysql_query .= "WHERE fdpc.id_conductor = ? ";
                        $mysql_query .= "AND fdpc.is_visible = 1 ";
                        $mysql_query .= "ORDER BY fdpc.id_fondo_pension_conductor DESC;";
                    } else if ($id_consulta == 6) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "licc.id_licencia_conduccion As id, ";
                        $mysql_query .= "licc.numero_licencia_conduccion As numero,";
                        $mysql_query .= "licc.fecha_expedicion_licencia_conduccion As expedicion, ";
                        $mysql_query .= "licc.fecha_vencimiento_licencia_conduccion As vencimiento, ";
                        $mysql_query .= "clc.nombre_categoria_licencia_conduccion AS categoria_1, ";
                        $mysql_query .= "clc1.nombre_categoria_licencia_conduccion AS categoria_2, ";
                        $mysql_query .= "clc2.nombre_categoria_licencia_conduccion AS categoria_3, ";
                        $mysql_query .= "clc3.nombre_categoria_licencia_conduccion AS categoria_4, ";
                        $mysql_query .= "licc.id_licencia_conduccion As opciones  ";
                        $mysql_query .= "FROM licencia_conduccion licc ";
                        $mysql_query .= "INNER JOIN categoria_licencia_conduccion clc ON clc.id_categoria_licencia_conduccion = licc.id_categoria_1  ";
                        $mysql_query .= "INNER JOIN categoria_licencia_conduccion clc1 ON clc1.id_categoria_licencia_conduccion = licc.id_categoria_2  ";
                        $mysql_query .= "INNER JOIN categoria_licencia_conduccion clc2 ON clc2.id_categoria_licencia_conduccion = licc.id_categoria_3  ";
                        $mysql_query .= "INNER JOIN categoria_licencia_conduccion clc3 ON clc3.id_categoria_licencia_conduccion = licc.id_categoria_4  ";
                        $mysql_query .= "WHERE licc.id_conductor = ? ";
                        $mysql_query .= "AND licc.is_visible = 1 ";
                        $mysql_query .= "ORDER BY licc.id_licencia_conduccion DESC;";

                        // var_dump($mysql_query);

                    } else if ($id_consulta == 7) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "comc.id_comparendo_conductor As id, ";
                        $mysql_query .= "comc.fecha_comparendo_conductor As fecha_comparendo, ";
                        $mysql_query .= "tcom.nombre_tipo_comparendo_conductor As tipo_comparendo, ";
                        $mysql_query .= "comc.motivo_comparendo_conductor As motivo_comparendo, ";
                        $mysql_query .= "comc.id_comparendo_conductor As opciones ";
                        $mysql_query .= "FROM comparendo_conductor comc ";
                        $mysql_query .= "INNER JOIN tipo_comparendo_conductor tcom ON tcom.id_tipo_comparendo_conductor = comc.id_tipo_comparendo_conductor ";
                        $mysql_query .= "WHERE comc.id_conductor = ? ";
                        $mysql_query .= "AND comc.is_visible = 1 ";
                        $mysql_query .= "ORDER BY comc.id_comparendo_conductor DESC;";

                        // var_dump($mysql_query);
                    } else if ($id_consulta == 8) {

                          $mysql_query = "SELECT ";
                        $mysql_query .= "exa.id_examen As id, ";
                        $mysql_query .= "exa.fecha_expedicion_examen As expedicion, ";
                        $mysql_query .= "exa.fecha_vencimiento_examen As vencimiento, ";
                        $mysql_query .= "texa.nombre_tipo_examen As tipo_examen, ";
                        $mysql_query .= "eexa.nombre_entidad_examen As entidad, ";
                        $mysql_query .= "exa.id_examen As opciones ";
                        $mysql_query .= "FROM examen exa ";
                        $mysql_query .= "INNER JOIN entidad_examen eexa ON eexa.id_entidad_examen = exa.id_entidad_examen ";
                        $mysql_query .= "INNER JOIN tipo_examen texa ON texa.id_tipo_examen = exa.id_tipo_examen ";
                        $mysql_query .= "WHERE exa.id_conductor = ? ";
                        $mysql_query .= "AND exa.is_visible = 1 ";
                        $mysql_query .= "ORDER BY exa.id_examen DESC;";


                        // var_dump($mysql_query);

                    } else if ($id_consulta == 9) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "cur.id_curso As id, ";
                        $mysql_query .= "cur.nombre_curso As nombre_curso, ";
                        $mysql_query .= "cur.fecha_realizacion_curso As realizacion, ";
                        $mysql_query .= "cur.fecha_expiracion_curso As expiracion, ";
                        $mysql_query .= "ecur.nombre_entidad_curso As entidad, ";
                        $mysql_query .= "cur.logro_obtenido As logro, ";
                        $mysql_query .= "cur.id_curso As opciones ";
                        $mysql_query .= "FROM curso cur ";
                        $mysql_query .= "INNER JOIN entidad_curso ecur ON ecur.id_entidad_curso = cur.id_entidad_curso ";
                        $mysql_query .= "WHERE cur.id_conductor = ? ";
                        $mysql_query .= "AND cur.is_visible = 1 ";
                        $mysql_query .= "ORDER BY cur.id_conductor DESC;";

                        // var_dump($mysql_query);

                    } else if ($id_consulta == 10) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "cap.id_capacitacion As id, ";
                        $mysql_query .= "cap.nombre_capacitacion As nombre_capacitacion, ";
                        $mysql_query .= "cap.fecha_realizacion_capacitacion As realizacion, ";
                        $mysql_query .= "tcap.nombre_tipo_capacitacion As tipo, ";
                        $mysql_query .= "ecap.nombre_entidad_capacitacion As entidad, ";
                        $mysql_query .= "cap.duracion_capacitacion As duracion, ";
                        $mysql_query .= "cap.id_capacitacion As opciones ";
                        $mysql_query .= "FROM capacitacion cap ";
                        $mysql_query .= "INNER JOIN entidad_capacitacion ecap ON ecap.id_entidad_capacitacion = cap.id_entidad_capacitacion ";
                        $mysql_query .= "INNER JOIN tipo_capacitacion tcap ON tcap.id_tipo_capacitacion = cap.id_tipo_capacitacion ";
                        $mysql_query .= "WHERE cap.id_conductor = ? ";
                        $mysql_query .= "AND cap.is_visible = 1 ";
                        $mysql_query .= "ORDER BY cap.id_conductor DESC;";

                        // var_dump($mysql_query);

                    } else if ($id_consulta == 11) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "inc.id_incapacidad_conductor As id, ";
                        $mysql_query .= "inc.numero_dias_incapacidad_conductor As dias, ";
                        $mysql_query .= "inc.concepto_incapacidad_conductor As concepto, ";
                        $mysql_query .= "einc.nombre_eps As eps, ";
                        $mysql_query .= "ainc.nombre_arl As arl, ";
                        $mysql_query .= "inc.id_incapacidad_conductor As opciones ";
                        $mysql_query .= "FROM incapacidad_conductor inc ";
                        $mysql_query .= "INNER JOIN eps einc ON einc.id_eps = inc.id_eps ";
                        $mysql_query .= "INNER JOIN arl ainc ON ainc.id_arl = inc.id_arl ";
                        $mysql_query .= "WHERE inc.id_conductor = ? ";
                        $mysql_query .= "AND inc.is_visible = 1 ";
                        $mysql_query .= "ORDER BY inc.id_conductor DESC;";

                        // var_dump($mysql_query);

                    } else if ($id_consulta == 12) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "vehc.id_vehiculo_conductor As id, ";
                        $mysql_query .= "veh.placa_vehiculo As placa, ";
                        $mysql_query .= "vehc.fecha_asignacion As asignacion, ";
                        $mysql_query .= "tveh.nombre_tipo_vehiculo As tipo, ";
                        $mysql_query .= "ser.nombre_servicio As servicio, ";
                        $mysql_query .= "vehc.id_vehiculo_conductor As opciones ";
                        $mysql_query .= "FROM vehiculo_conductor vehc ";
                        $mysql_query .= "INNER JOIN usuario usu ON usu.id_usuario = vehc.id_usuario ";
                        $mysql_query .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = vehc.id_vehiculo ";
                        $mysql_query .= "INNER JOIN servicio ser ON ser.id_servicio = veh.id_servicio ";
                        $mysql_query .= "INNER JOIN tipo_vehiculo tveh ON tveh.id_tipo_vehiculo = veh.id_tipo_vehiculo ";
                        $mysql_query .= "WHERE vehc.id_conductor = ? ";
                        $mysql_query .= "AND vehc.is_visible = 1 ";
                        $mysql_query .= "ORDER BY vehc.id_vehiculo_conductor DESC;";

                        // var_dump($mysql_query,$id_conductor);

                    } else if ($id_consulta == 13) {

                        $mysql_query = "SELECT ";
                        $mysql_query .= "cont.id_contrato_empresa_conductor As id,  ";
                        $mysql_query .= "emp.nombre_empresa As Empresa, ";
                        $mysql_query .= "tipo.nombre_tipo_contrato As Contrato, ";
                        $mysql_query .= "cont.fecha_ingreso_empresa_conductor As asignacion, ";
                        $mysql_query .= "cont.fecha_vencimiento_contrato_empresa_conductor As vencimiento, ";
                        $mysql_query .= "cont.id_contrato_empresa_conductor As opciones ";
                        $mysql_query .= "FROM contrato_empresa_conductor cont ";
                        $mysql_query .= "INNER JOIN empresa emp ON emp.id_empresa = cont.id_empresa ";
                        $mysql_query .= "INNER JOIN tipo_contrato tipo ON tipo.id_tipo_contrato = cont.id_tipo_contrato ";
                        $mysql_query .= "WHERE cont.id_conductor = ? ";
                        $mysql_query .= "AND cont.is_visible = 1 ";
                        $mysql_query .= "ORDER BY cont.id_contrato_empresa_conductor DESC;";

                        // var_dump($mysql_query);

                    }
                    $mysql_stmt = mysqli_prepare($database->myconn, $mysql_query);
                    $mysql_stmt->bind_param('s', $id_conductor);

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
            $json_status = "error";
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