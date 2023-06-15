<?php
class ReadRevision
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getRevison(
        $_value = '',
        $_type = 'ID'
    ) {

        $arrayCondicional = array(
            'ID' => 'rev.previautos_pdf',
            'VEHICULO' => 'veh.id_previautos_vehiculo',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla tallesa
        $mysqlQuery .= "rev.id_previautos_pdf,tip.nombre_reviautos_tipo_pdf,tip.id_previautos_tipo_pdf,";
        $mysqlQuery .= "rev.bimensual_previautos_pdf,usu.nombre_usuario,usu.apellido_usuario, ";
        $mysqlQuery .= "rev.fecha_expedicion_previautos_pdf,rev.fecha_vencimiento_previautos_pdf, ";
        $mysqlQuery .= "rev.archivo_previautos_pdf,veh.placa_previautos_vehiculo ";
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "previautos_pdf rev ";
        $mysqlQuery .= "INNER JOIN previautos_tipo_pdf tip ";
        $mysqlQuery .= "ON tip.id_previautos_tipo_pdf = rev.id_previautos_tipo_pdf ";

        $mysqlQuery .= "INNER JOIN usuario usu ";
        $mysqlQuery .= "ON usu.id_usuario = rev.id_usuario ";

        $mysqlQuery .= "INNER JOIN previautos_vehiculo veh ";
        $mysqlQuery .= "ON veh.id_previautos_vehiculo = rev.id_previautos_vehiculo ";

        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_type] . " LIKE ? ";
        $mysqlQuery .= "AND rev.is_visible = 1 ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY rev.id_previautos_pdf DESC; ";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_value);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_previautos_pdf']),
                            "id_tipo" => htmlspecialchars($row['id_previautos_tipo_pdf']),
                            "tipo" => htmlspecialchars($row['nombre_reviautos_tipo_pdf']),
                            "bimensual" => htmlspecialchars($row['bimensual_previautos_pdf']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "expedicion" => htmlspecialchars($row['fecha_expedicion_previautos_pdf']),
                            "vencimiento" => htmlspecialchars($row['fecha_vencimiento_previautos_pdf']),
                            "archivo" => htmlspecialchars($row['archivo_previautos_pdf']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'revision' => $mysqlArray,
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

    public function getRevisionBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'rev.id_previautos_pdf',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'rev.id_previautos_pdf',
            'CONTENT' => '%%',
            'TIPO' => '%%',
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
        $mysqlQueryCount = "SELECT COUNT(rev.id_previautos_pdf) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "rev.id_previautos_pdf,tip.nombre_reviautos_tipo_pdf,tip.id_previautos_tipo_pdf,";
        $mysqlQueryColumns .= "rev.bimensual_previautos_pdf,usu.nombre_usuario,usu.apellido_usuario,";
        $mysqlQueryColumns .= "rev.fecha_expedicion_previautos_pdf,rev.fecha_vencimiento_previautos_pdf, ";
        $mysqlQueryColumns .= "rev.archivo_previautos_pdf,rev.fecha_formluario,rev.archivo_previautos_pdf, ";
        $mysqlQueryColumns .= "veh.placa_previautos_vehiculo,veh.documento_previautos_vehiculo ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "previautos_pdf rev ";
        $mysqlQuery .= "INNER JOIN previautos_tipo_pdf tip ";
        $mysqlQuery .= "ON tip.id_previautos_tipo_pdf = rev.id_previautos_tipo_pdf ";

        $mysqlQuery .= "INNER JOIN usuario usu ";
        $mysqlQuery .= "ON usu.id_usuario = rev.id_usuario ";

        $mysqlQuery .= "INNER JOIN previautos_vehiculo veh ";
        $mysqlQuery .= "ON veh.id_previautos_vehiculo = rev.id_previautos_vehiculo ";

        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND rev.is_visible = 1 ";
        $mysqlQuery .= "AND rev.id_previautos_tipo_pdf LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        //  echo $mysqlQueryColumns;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param('ss', $_condicional_['CONTENT'], $_condicional_['TIPO']);
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
                $mysqlStmt->bind_param('ss', $_condicional_['CONTENT'], $_condicional_['TIPO']);
                ///tall.nit,tall.nombre_tallesa,tall.direccion
                if ($mysqlStmt->execute()) {
                    $mysqlResult = $mysqlStmt->get_result();
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArray,
                            array(
                                "nro" => htmlspecialchars(
                                    (strtolower($_condicional_['BY']) == 'asc') ? $mysqlArrayElements['SQL_COUNT']-- : $mysqlArrayElements['SQL_COUNT']++
                                ),
                                "placa" => htmlspecialchars($row['placa_previautos_vehiculo']),
                                "documento" => htmlspecialchars($row['documento_previautos_vehiculo']),
                                "tipo" => htmlspecialchars($row['nombre_reviautos_tipo_pdf']),
                                "bimensual" => htmlspecialchars($row['bimensual_previautos_pdf']),
                                "expedicion" => htmlspecialchars($row['fecha_expedicion_previautos_pdf']),
                                "vencimiento" => htmlspecialchars($row['fecha_vencimiento_previautos_pdf']),
                                "responsable" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                                # "direccion" => htmlspecialchars($row['direccion']),
                                "opciones" => array(
                                    'id' => encrypt($row['id_previautos_pdf'], 1),
                                    'archivo' => ($row['archivo_previautos_pdf']),
                                ),
                            )
                        );
                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'vehiculo' => $mysqlArray,
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