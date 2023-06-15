<?php
class ReadCertificado
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayEmpresas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getCertificado(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'cert.id_certificado_empresa',
            'ID_EMPRESA' => 'cert.id_empresa',
        );

        $mysqlArrayCertificado = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";
        #tabla tipo_certificado
        $mysqlQuery .= "tipc.id_tipo_certificado,tipc.nombre_tipo_certificado, ";
        #tabla entidad
        $mysqlQuery .= "enti.id_entidad_certificado,enti.nombre_entidad_certificado, ";
        #tabla certificado_empresa
        $mysqlQuery .= "cert.id_certificado_empresa,cert.nombre_certificado_empresa, ";
        $mysqlQuery .= "cert.fecha_expedicion_certificado_empresa,cert.fecha_vencimiento_certificado_empresa, ";
        $mysqlQuery .= "cert.fecha_formulario,cert.foto_certificado_empresa, ";
        # tabla usuario
        $mysqlQuery .= "usua.id_usuario,usua.nombre_usuario,usua.apellido_usuario ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "certificado_empresa cert ";
        #JOIN
        $mysqlQuery .= "LEFT JOIN empresa empr ON empr.id_empresa = cert.id_empresa ";
        $mysqlQuery .= "LEFT JOIN tipo_certificado tipc ON tipc.id_tipo_certificado = cert.id_tipo_certificado ";
        $mysqlQuery .= "LEFT JOIN entidad_certificado enti ON enti.id_entidad_certificado = cert.id_entidad_certificado ";
        $mysqlQuery .= "LEFT JOIN usuario usua ON usua.id_usuario = cert.id_usuario ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND cert.is_visible = 1 ";
        $mysqlQuery .= "ORDER BY cert.id_certificado_empresa DESC; ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);

        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArrayCertificado,
                        array(
                            "id" => htmlspecialchars($row['id_certificado_empresa']),
                            "nombre" => htmlspecialchars($row['nombre_certificado_empresa']),
                            "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_certificado_empresa']),
                            "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_certificado_empresa']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                            "foto" => htmlspecialchars($row['foto_certificado_empresa']),
                            "id_usuario" => htmlspecialchars($row['id_usuario']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "id_entidad" => htmlspecialchars($row['id_entidad_certificado']),
                            "entidad" => htmlspecialchars($row['nombre_entidad_certificado']),
                            "id_tipo" => htmlspecialchars($row['id_tipo_certificado']),
                            "tipo" => htmlspecialchars($row['nombre_tipo_certificado']),
                            "id_empresa" => htmlspecialchars($row['id_empresa']),
                            "nit" => htmlspecialchars($row['nit']),
                            "empresa" => htmlspecialchars($row['nombre_empresa']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'certificado' => $mysqlArrayCertificado,
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

    public function getEmpresaBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'empr.nit',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'empr.id_empresa',
            'CONTENT' => '%%',
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

        $mysqlArrayEmpresa = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(empr.id_empresa) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "empr.id_empresa,empr.nit,empr.nombre_empresa,empr.direccion ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "empresa empr ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param('s', $_condicional_['CONTENT']);
        # Se ejecuta
        if ($mysqlStmt->execute()) {
            # Obtener
            $mysqlResult = $mysqlStmt->get_result();
            # Numero de filas
            $mysqlArrayElements['SQL_ROWS'] = intval($mysqlResult->fetch_assoc()['MY_TOTAL_ROWS']);
            # Si la busqueda tiene resultados
            if (intval($mysqlArrayElements['SQL_ROWS']) > 0) {
                $mysqlStmt->close();
                # Paginacion
                $mysqlArrayElements['SQL_TOTAL_PAGES'] = ceil($mysqlArrayElements['SQL_ROWS'] / $_condicional_['ROWS']);
                $mysqlArrayElements['SQL_PAGE'] = ($_condicional_['PAGE']);
                $mysqlArrayElements['SQL_LIMIT'] = (($mysqlArrayElements['SQL_PAGE'] - 1) * $_condicional_['ROWS']);
                $mysqlArrayElements['SQL_COUNT'] = (strtolower($_condicional_['BY']) == 'asc') ? ($mysqlArrayElements['SQL_ROWS'] - $mysqlArrayElements['SQL_LIMIT']) : ($mysqlArrayElements['SQL_LIMIT'] + 1);
                #SQL LIMITE
                $mysqlQueryColumns .= "LIMIT " . $mysqlArrayElements['SQL_LIMIT'] . "," . $_condicional_['ROWS'] . ";";

                $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryColumns);
                $mysqlStmt->bind_param('s', $_condicional_['CONTENT']);
                ///empr.nit,empr.nombre_empresa,empr.direccion
                if ($mysqlStmt->execute()) {
                    $mysqlResult = $mysqlStmt->get_result();
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push($mysqlArrayEmpresa,
                            array(
                                "nro" => htmlspecialchars(
                                    (strtolower($_condicional_['BY']) == 'asc') ? $mysqlArrayElements['SQL_COUNT']-- : $mysqlArrayElements['SQL_COUNT']++
                                ),
                                "nit" => htmlspecialchars($row['nit']),
                                "nombre" => htmlspecialchars($row['nombre_empresa']),
                                "direccion" => htmlspecialchars($row['direccion']),
                                "opciones" => $row['id_empresa'],
                            )
                        );

                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'empresa' => $mysqlArrayEmpresa,
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

    public function getEmpresaVehiculo($id_vehiculo)
    {

        /* $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, tipolz.nombre_tipo_poliza, asepolz.nombre_aseguradora_poliza, ";
        $mysql_query .= "polz.fecha_expedicion_poliza, polz.fecha_vencimiento_polzia, polz.id_tipo_poliza ";
        $mysql_query .= "FROM poliza polz ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON polz.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN tipo_poliza tipolz ON polz.id_tipo_poliza = tipolz.id_tipo_poliza ";
        $mysql_query .= "LEFT JOIN aseguradora_poliza asepolz ON polz.id_aseguradora_poliza = asepolz.id_aseguradora_poliza ";
        $mysql_query .= "WHERE veh.id_vehiculo = ? ORDER BY polz.id_poliza DESC LIMIT 0,5";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
        $result = $mysql_stmt->get_result();

        while ($row = $result->fetch_assoc()) {
        array_push($this->array_poliza, array(

        'vehiculo' => $row['id_vehiculo'],
        'nombre_poliza' => $row['nombre_tipo_poliza'],
        'aseguradora_poliza' => $row['nombre_aseguradora_poliza'],
        'expedicion_poliza' => $row['fecha_expedicion_poliza'],
        'vencimiento_polzia' => $row['fecha_vencimiento_polzia'],
        ));
        }

        }*/
        return $this->arrayResponse;
    }

}