<?php
class ReadVehiculo
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getVehiculoInformacion(
        $_value = '',
        $_type = 'ID'
    ) {

        $arrayCondicional = array(
            'ID' => 'veh.id_previautos_vehiculo',
            'PLACA' => 'veh.placa_previautos_vehiculo',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla tallesa
        $mysqlQuery .= "veh.id_previautos_vehiculo,veh.placa_previautos_vehiculo,";
        $mysqlQuery .= "veh.documento_previautos_vehiculo,veh.fecha_formulario, ";
        $mysqlQuery .= "usu.nombre_usuario, usu.apellido_usuario ";
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "previautos_vehiculo veh ";
        $mysqlQuery .= "LEFT JOIN ";
        $mysqlQuery .= "usuario usu ON usu.id_usuario = veh.id_usuario ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_type] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY veh.id_previautos_vehiculo DESC; ";

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
                            "id" => htmlspecialchars($row['id_previautos_vehiculo']),
                            "placa" => htmlspecialchars($row['placa_previautos_vehiculo']),
                            "documento" => htmlspecialchars($row['documento_previautos_vehiculo']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'vehiculo' => $mysqlArray,
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


    /* public function getRevisionBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'veh.id_previautos_vehiculo',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'veh.id_previautos_vehiculo',
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

        $mysqlArray = array();


        #Contador
        $mysqlQueryCount = "SELECT COUNT(veh.id_previautos_vehiculo) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "veh.id_previautos_vehiculo,veh.placa_previautos_vehiculo,";
        $mysqlQueryColumns .= "veh.documento_previautos_vehiculo,veh.fecha_formulario,";
        $mysqlQueryColumns .= "usu.nombre_usuario, usu.apellido_usuario ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "previautos_vehiculo veh ";
        $mysqlQuery .= "usuario usu ON usu.id_usuario = veh.id_usuario ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        echo $mysqlQueryCount;

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
                                "responsable" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                                # "direccion" => htmlspecialchars($row['direccion']),
                                "opciones" => encrypt($row['id_previautos_vehiculo'], 1),
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
    }*/
}