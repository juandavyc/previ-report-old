<?php
class ReadPreoperacionalSuper
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayUsuarios = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getPreoperacionalSuper(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
            'LIMITE' => '0',
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'preo.id_preoperacional',
            'ID_VEHICULO' => 'vehi.id_vehiculo',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";

        $mysqlQuery .= "preo.id_preoperacional,preo.tarjeta_propiedad_vigencia,preo.revision_rtm_vigencia, ";
        $mysqlQuery .= "preo.certificado_gases_vigencia,preo.planilla_fuec_vigencia, ";
        $mysqlQuery .= "preo.licencia_conduccion_vigencia,preo.poliza_vigencia,preo.poliza_soat_vigencia, ";
        $mysqlQuery .= "preo.firma_usuario_autoriza,preo.firma_usuario_realiza, ";
        $mysqlQuery .= "preo.observaciones_usuario_autoriza,preo.observaciones_usuario_realiza, ";
        $mysqlQuery .= "preo.foto_vehiculo_uno,preo.foto_vehiculo_dos,preo.fecha_formulario, ";

        #tabla estado (resultado)
        $mysqlQuery .= "esta.id_estado_preoperacional,esta.nombre_estado_preoperacional, ";
        #tabla usuario # realiza
        $mysqlQuery .= "usur.id_usuario As id_usuario_realiza, CONCAT(usur.nombre_usuario,' ',usur.apellido_usuario) As nombre_usuario_realiza, ";
        #tabla usuario # autoriza
        $mysqlQuery .= "usua.id_usuario As id_usuario_autoriza, CONCAT(usua.nombre_usuario,' ',usua.apellido_usuario) As nombre_usuario_autoriza, ";
        #tabla # VEHICULO
        $mysqlQuery .= "vehi.id_vehiculo, vehi.placa_vehiculo ";

        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "preoperacional preo ";
        #JOIN
        $mysqlQuery .= "INNER JOIN vehiculo vehi ON vehi.id_vehiculo = preo.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = preo.id_empresa ";
        $mysqlQuery .= "INNER JOIN estado_preoperacional esta ON esta.id_estado_preoperacional = preo.id_estado_preoperacional ";
        $mysqlQuery .= "INNER JOIN usuario usur ON usur.id_usuario = preo.id_usuario_realiza ";
        $mysqlQuery .= "INNER JOIN usuario usua ON usua.id_usuario = preo.id_usuario_autoriza ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY preo.id_preoperacional DESC LIMIT " . $_condicional_['LIMITE'] . "; ";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_preoperacional']),
                            // is_vigente
                            "vigente" => array(
                                "tarjeta" => htmlspecialchars($row['tarjeta_propiedad_vigencia']),
                                "revision" => htmlspecialchars($row['revision_rtm_vigencia']),
                                "gases" => htmlspecialchars($row['certificado_gases_vigencia']),
                                "fuec" => htmlspecialchars($row['planilla_fuec_vigencia']),
                                "licencia" => htmlspecialchars($row['licencia_conduccion_vigencia']),
                                "poliza" => htmlspecialchars($row['poliza_vigencia']),
                                "soat" => htmlspecialchars($row['poliza_soat_vigencia']),
                            ),
                            // usuario autoriza
                            "autoriza" => array(
                                "id" => htmlspecialchars($row['id_usuario_autoriza']),
                                "nombre" => htmlspecialchars($row['nombre_usuario_autoriza']),
                                "firma" => htmlspecialchars($row['firma_usuario_autoriza']),
                                "observaciones" => htmlspecialchars($row['observaciones_usuario_autoriza']),
                            ),
                            // usuario realiza
                            "realiza" => array(
                                "id" => htmlspecialchars($row['id_usuario_realiza']),
                                "nombre" => htmlspecialchars($row['nombre_usuario_realiza']),
                                "firma" => htmlspecialchars($row['firma_usuario_realiza']),
                                "observaciones" => htmlspecialchars($row['observaciones_usuario_realiza']),
                            ),
                            // fotos
                            "foto_uno" => htmlspecialchars($row['foto_vehiculo_uno']),
                            "foto_dos" => htmlspecialchars($row['foto_vehiculo_dos']),
                            // estado (resultado)
                            "estado" => array(
                                "id" => htmlspecialchars($row['id_estado_preoperacional']),
                                "nombre" => htmlspecialchars($row['nombre_estado_preoperacional']),
                            ),
                            "vehiculo" => array(
                                "id" => htmlspecialchars($row['id_vehiculo']),
                                "placa" => htmlspecialchars($row['placa_vehiculo']),
                            ),
                            // formulario
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }

                // var_dump($row['nombre_ciudad']);

                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'preoperacional' => $mysqlArray,
                );
            } else {
                $this->arrayResponse = array(
                    'status' => 'sin_resultados',
                    'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
                );
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta: ' . htmlspecialchars($mysqlStmt->error),
            );
        }

        return $this->arrayResponse;
    }

    public function getPreoperacionalBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'preo.id_preoperacional',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'preo.id_preoperacional',
            'CONTENT' => '%%',
            'EMPRESA' => '%%',
            'RESULTADO' => '%%',
            'F_INICIAL' => '2000-01-01',
            'F_FINAL' => '2000-01-01'
        )
    ) {
        #resultados
        $mysqlArrayElements = array(
            'SQL_ROWS' => 0,
            'SQL_PAGE' => 0,
            'SQL_TOTAL_PAGES' => 0,
            'SQL_LIMIT' => 0,
            'SQL_INCREMENT' => 0,
            'SQL_COUNT' => 0,
        );

        $mysqlArray = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(preo.id_preoperacional) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "preo.id_preoperacional, ";
        $mysqlQueryColumns .= "preo.fecha_formulario, ";
        $mysqlQueryColumns .= "vehi.placa_vehiculo,empr.nombre_empresa, ";
        $mysqlQueryColumns .= "cond.nombre_usuario,cond.apellido_usuario, ";
        $mysqlQueryColumns .= "esta.nombre_estado_preoperacional ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "preoperacional preo ";
        $mysqlQuery .= "INNER JOIN vehiculo vehi ON vehi.id_vehiculo = preo.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = preo.id_empresa ";
        $mysqlQuery .= "INNER JOIN usuario cond ON preo.id_usuario_realiza = cond.id_usuario ";
        $mysqlQuery .= "INNER JOIN estado_preoperacional esta ON esta.id_estado_preoperacional = preo.id_estado_preoperacional ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        $mysqlQuery .= "AND preo.id_estado_preoperacional LIKE ? ";
        $mysqlQuery .= "AND preo.fecha_formulario BETWEEN ? AND ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";

        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;
        
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param(
            'sssss',
            $_condicional_['CONTENT'],
            $_condicional_['EMPRESA'],
            $_condicional_['RESULTADO'],
            $_condicional_['F_INICIAL'],
            $_condicional_['F_FINAL']
        );

        # Se ejecuta
        if ($mysqlStmt->execute()) {
            # Obtener

            $mysqlResult = $mysqlStmt->get_result();
            # Numero de filas
            $mysqlArrayElements['SQL_ROWS'] = intval($mysqlResult->fetch_assoc()['MY_TOTAL_ROWS']);

            # Si la busqueda tiene resultados
            if (intval($mysqlArrayElements['SQL_ROWS']) > 0) {
                // echo "OKOKO";
                $mysqlStmt->close();
                # Paginacion
                $mysqlArrayElements['SQL_TOTAL_PAGES'] = ceil($mysqlArrayElements['SQL_ROWS'] / $_condicional_['ROWS']);
                $mysqlArrayElements['SQL_PAGE'] = ($_condicional_['PAGE']);
                $mysqlArrayElements['SQL_LIMIT'] = (($mysqlArrayElements['SQL_PAGE'] - 1) * $_condicional_['ROWS']);
                $mysqlArrayElements['SQL_COUNT'] = (strtolower($_condicional_['BY']) == 'asc') ? ($mysqlArrayElements['SQL_ROWS'] - $mysqlArrayElements['SQL_LIMIT']) : ($mysqlArrayElements['SQL_LIMIT'] + 1);
                #SQL LIMITE
                $mysqlQueryColumns .= "LIMIT " . $mysqlArrayElements['SQL_LIMIT'] . "," . $_condicional_['ROWS'] . ";";

                $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryColumns);
                $mysqlStmt->bind_param(
                    'sssss',
                    $_condicional_['CONTENT'],
                    $_condicional_['EMPRESA'],
                    $_condicional_['RESULTADO'],
                    $_condicional_['F_INICIAL'],
                    $_condicional_['F_FINAL']
                );
                ///empr.nit,empr.nombre_empresa,empr.direccion
                if ($mysqlStmt->execute()) {
                    $mysqlResult = $mysqlStmt->get_result();
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArray,
                            // mysqlArraySiniestro
                            array(
                                "nro" => htmlspecialchars(
                                    (strtolower($_condicional_['BY']) == 'asc') ? $mysqlArrayElements['SQL_COUNT']-- : $mysqlArrayElements['SQL_COUNT']++
                                ),
                                "placa" => htmlspecialchars($row['placa_vehiculo']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "resultado" => htmlspecialchars($row['nombre_estado_preoperacional']),
                                //cond.nombre_usuario,cond.apellido_usuario,
                                "realiza" => htmlspecialchars($row['nombre_usuario'].' '.$row['apellido_usuario'] ),
                                "agregado" => getSpecialDateTime($row['fecha_formulario']),
                                "opciones" => encrypt($row['id_preoperacional'], 1),
                            )
                        );
                    }
                    // var_dump($mysqlArraySiniestro);
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'preoperacional' => $mysqlArray,
                    );
                    // var_dump($this->arrayResponse);
                } else {
                    $this->arrayResponse = array(
                        'status' => 'error',
                        'message' => 'Error en la consulta # 2 : ' . htmlspecialchars($mysqlStmt->error),
                    );
                }
            } else {
                $this->arrayResponse = array(
                    'status' => 'sin_resultados',
                    'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
                );
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta # 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }
}