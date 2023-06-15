<?php
class ReadFotoMantenimiento
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayUsuarios = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }



    public function getFotoInformacion(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'fotm.id_foto_mantenimiento',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        $mysqlQuery .= "fotm.descripcion_foto_mantenimiento,fotm.foto_mantenimiento, fotm.id_foto_mantenimiento , ";
        $mysqlQuery .= "usu.nombre_usuario ,cfot.nombre_categoria_foto_mantenimiento, fotm.fecha_formulario ";
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "foto_mantenimiento fotm ";
        $mysqlQuery .= "INNER JOIN categoria_foto_mantenimiento cfot ON cfot.id_categoria_foto_mantenimiento = fotm.id_categoria_foto_mantenimiento ";
        $mysqlQuery .= "INNER JOIN usuario usu ON usu.id_usuario = fotm.id_usuario ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "ORDER BY fotm.id_foto_mantenimiento DESC; ";

        // var_dump($mysqlQuery);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_foto_mantenimiento']),
                            "descripcion" => htmlspecialchars($row['descripcion_foto_mantenimiento']),
                            "foto" => htmlspecialchars($row['foto_mantenimiento']),
                            "usuario" => htmlspecialchars($row['nombre_usuario']),
                            "categoria" => htmlspecialchars($row['nombre_categoria_foto_mantenimiento']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }

                // var_dump($mysqlArray);

                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'mantenimiento' => $mysqlArray,
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
        $mysqlQueryColumns .= "sini.id_siniestro,sini.fecha_siniestro,sini.hora_siniestro, ";
        $mysqlQueryColumns .= "empr.nombre_empresa,tsini.nombre_tipo_siniestro,con.nombre_conductor ";
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
                                "fecha" => htmlspecialchars($row['fecha_siniestro']),
                                "hora" => htmlspecialchars($row['hora_siniestro']),
                                "tipo" => htmlspecialchars($row['nombre_tipo_siniestro']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "conductor" => htmlspecialchars($row['nombre_conductor']),
                                "opciones" => encrypt($row['id_siniestro'],1),
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