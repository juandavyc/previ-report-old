<?php
class ReadSiniestro
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayUsuarios = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getSiniestroInformacion(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'sini.id_siniestro',
            'CEDULA' => 'sini.cedula_usuario',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";
        #tabla SINIESTRO
        $mysqlQuery .= "sini.id_siniestro,sini.fecha_siniestro,TIME_FORMAT(sini.hora_siniestro, '%H:%i') As time_hora_siniestro, con.nombre_conductor, ";
        $mysqlQuery .= "sini.direccion_siniestro,sini.heridos_siniestro,sini.muertos_siniestro, usu.apellido_usuario, ";
        $mysqlQuery .= "sini.vehiculos_implicados_siniestro,sini.descripcion_siniestro,sini.foto_1_siniestro, ";
        $mysqlQuery .= "sini.foto_2_siniestro, sini.foto_3_siniestro,sini.foto_4_siniestro, ";
        $mysqlQuery .= "sini.firma_siniestro,sini.fecha_formulario, ";

        #tabla CIUDAD
        $mysqlQuery .= "ciu.id_ciudad,ciu.nombre_ciudad, ";
        #tabla CIUDAD
        $mysqlQuery .= "depa.id_departamento,depa.nombre_departamento, ";
        #tabla TIPO SINIESTRO
        $mysqlQuery .= " tsini.id_tipo_siniestro,tsini.nombre_tipo_siniestro, ";
        #tabla VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        #tabla CONDUCTOR
        $mysqlQuery .= "con.id_conductor,con.numero_documento, ";
        #tabla USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario  ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "siniestro sini ";
        #JOIN
        $mysqlQuery .= "INNER JOIN tipo_siniestro tsini ON tsini.id_tipo_siniestro = sini.id_tipo_siniestro ";
        $mysqlQuery .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = sini.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN conductor con ON con.id_conductor = sini.id_conductor ";
        $mysqlQuery .= "INNER JOIN usuario usu ON usu.id_usuario = sini.id_usuario ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = sini.id_empresa ";
        $mysqlQuery .= "INNER JOIN ciudad ciu ON ciu.id_ciudad = sini.id_ciudad ";
        $mysqlQuery .= "INNER JOIN departamento depa ON depa.id_departamento = ciu.id_departamento ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY sini.id_siniestro DESC; ";

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
                            "id" => htmlspecialchars($row['id_siniestro']),
                            "fecha_siniestro" => htmlspecialchars($row['fecha_siniestro']),
                            "hora" => htmlspecialchars($row['time_hora_siniestro']),
                            "direccion" => htmlspecialchars($row['direccion_siniestro']),
                            "id_tipo" => htmlspecialchars($row['id_tipo_siniestro']),
                            "tipo_siniestro" => htmlspecialchars($row['nombre_tipo_siniestro']),
                            "heridos" => htmlspecialchars($row['heridos_siniestro']),
                            "muertos" => htmlspecialchars($row['muertos_siniestro']),
                            "implicados_siniestro" => htmlspecialchars($row['vehiculos_implicados_siniestro']),
                            "descripcion" => htmlspecialchars($row['descripcion_siniestro']),
                            "foto_1" => htmlspecialchars($row['foto_1_siniestro']),
                            "foto_2" => htmlspecialchars($row['foto_2_siniestro']),
                            "foto_3" => htmlspecialchars($row['foto_3_siniestro']),
                            "foto_4" => htmlspecialchars($row['foto_4_siniestro']),
                            "firma" => htmlspecialchars($row['firma_siniestro']),
                            "id_vehiculo" => htmlspecialchars($row['id_vehiculo']),
                            "placa" => htmlspecialchars($row['placa_vehiculo']),
                            "id_conductor" => htmlspecialchars($row['id_conductor']),
                            "nombre_conductor" => htmlspecialchars($row['nombre_conductor']),
                            "id_ciudad" => htmlspecialchars($row['id_ciudad']),
                            "ciudad" => htmlspecialchars($row['nombre_ciudad']),
                            "id_departamento" => htmlspecialchars($row['id_departamento']),
                            "departamento" => htmlspecialchars($row['nombre_departamento']),
                            "empresa" => htmlspecialchars($row['id_empresa']),
                            "nombre_empresa" => htmlspecialchars($row['nombre_empresa']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }

                // var_dump($row['nombre_ciudad']);

                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'siniestro' => $mysqlArray,
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

    public function getSiniestroBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'sini.id_siniestro',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'sini.id_siniestro',
            'CONTENT' => '%%',
            'TIPO_SINIESTRO' => '%%',
            'CONDUCTOR' => '%%',
            'EMPRESA' => '%%',
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

        $mysqlArraySiniestro = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(sini.id_siniestro) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "sini.id_siniestro,sini.fecha_siniestro,TIME_FORMAT(sini.hora_siniestro, '%H:%i') As time_hora_siniestro, ";
        $mysqlQueryColumns .= "empr.nombre_empresa,tsini.nombre_tipo_siniestro,con.nombre_conductor,veh.placa_vehiculo ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "siniestro sini ";
        $mysqlQuery .= "INNER JOIN vehiculo veh ON veh.id_vehiculo = sini.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = veh.id_empresa ";
        $mysqlQuery .= "INNER JOIN tipo_siniestro tsini ON tsini.id_tipo_siniestro = sini.id_tipo_siniestro ";
        $mysqlQuery .= "INNER JOIN conductor con ON con.id_conductor = sini.id_conductor ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        $mysqlQuery .= "AND tsini.id_tipo_siniestro LIKE ?  AND con.id_conductor LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        // var_dump($mysqlQueryCount.$mysqlQueryColumns);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param(
            'ssss',
            $_condicional_['CONTENT'],
            $_condicional_['EMPRESA'],
            $_condicional_['TIPO_SINIESTRO'],
            $_condicional_['CONDUCTOR'],
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
                    'ssss',
                    $_condicional_['CONTENT'],
                    $_condicional_['EMPRESA'],
                    $_condicional_['TIPO_SINIESTRO'],
                    $_condicional_['CONDUCTOR'],
                );
                ///empr.nit,empr.nombre_empresa,empr.direccion
                if ($mysqlStmt->execute()) {
                    $mysqlResult = $mysqlStmt->get_result();
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArraySiniestro,
                            // mysqlArraySiniestro
                            array(
                                "nro" => htmlspecialchars(
                                    (strtolower($_condicional_['BY']) == 'asc') ? $mysqlArrayElements['SQL_COUNT']-- : $mysqlArrayElements['SQL_COUNT']++
                                ),

                                "placa" => htmlspecialchars($row['placa_vehiculo']),
                                "fecha" => htmlspecialchars($row['fecha_siniestro']),
                                "hora" => htmlspecialchars($row['time_hora_siniestro']),

                                "tipo" => htmlspecialchars($row['nombre_tipo_siniestro']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "conductor" => htmlspecialchars($row['nombre_conductor']),
                                "opciones" => encrypt($row['id_siniestro'], 1),
                            )
                        );
                    }
                    // var_dump($mysqlArraySiniestro);
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'siniestro' => $mysqlArraySiniestro,
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