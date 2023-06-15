<?php
class ReadConductor
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getConductor(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1',
        $_empresa_ = '%%'
    ) {

        $arrayCondicional = array(
            'ID' => 'cond.id_conductor',
            'DOCUMENTO' => 'cond.numero_documento',
        );

        // $arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";

        #tabla conductor
        $mysqlQuery .= "cond.id_conductor,cond.nombre_conductor,cond.apellido_conductor, ";
        $mysqlQuery .= "cond.telefono_conductor,cond.celular_conductor,cond.whatsapp_conductor, ";
        $mysqlQuery .= "cond.direccion_conductor,cond.correo_conductor,cond.numero_documento, ";
        $mysqlQuery .= "cond.firma_conductor,cond.foto_conductor, ";
        $mysqlQuery .= "cond.fecha_formulario, ";
        #tabla tipo sangre
        $mysqlQuery .= "tipsa.id_tipo_sangre,tipsa.nombre_tipo_sangre, ";
        #tabla tipo identificacion
        $mysqlQuery .= "tipid.id_tipo_identificacion,tipid.nombre_tipo_identificacion, ";
        #tabla ciudad
        $mysqlQuery .= "ciud.id_ciudad,ciud.nombre_ciudad, ";
        #tabla usuario
        $mysqlQuery .= "usua.nombre_usuario,usua.apellido_usuario ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "conductor cond ";
        #JOIN
        $mysqlQuery .= "LEFT JOIN empresa empr ON cond.id_empresa = empr.id_empresa ";
        $mysqlQuery .= "LEFT JOIN tipo_sangre tipsa ON cond.id_tipo_sangre = tipsa.id_tipo_sangre ";
        $mysqlQuery .= "LEFT JOIN ciudad ciud ON cond.id_ciudad = ciud.id_ciudad ";
        $mysqlQuery .= "LEFT JOIN tipo_identificacion tipid ON cond.id_tipo_identificacion = tipid.id_tipo_identificacion ";
        $mysqlQuery .= "LEFT JOIN usuario usua ON cond.id_usuario = usua.id_usuario ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND cond.id_empresa LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY empr.id_empresa DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('ss', $_condicional_['VALUE'], $_empresa_);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_conductor']),
                            "documento" => htmlspecialchars($row['numero_documento']),
                            "nombre" => htmlspecialchars($row['nombre_conductor']),
                            "apellido" => htmlspecialchars($row['apellido_conductor']),
                            "telefono" => htmlspecialchars($row['telefono_conductor']),
                            "celular" => htmlspecialchars($row['celular_conductor']),
                            "whatsapp" => htmlspecialchars($row['whatsapp_conductor']),
                            "direccion" => htmlspecialchars($row['direccion_conductor']),
                            "correo" => htmlspecialchars($row['correo_conductor']),
                            "firma" => htmlspecialchars($row['firma_conductor']),
                            "foto" => htmlspecialchars($row['foto_conductor']),
                            "sangre" => array(
                                "id" => htmlspecialchars($row['id_tipo_sangre']),
                                "tipo" => htmlspecialchars($row['nombre_tipo_sangre']),
                            ),
                            "identificacion" => array(
                                "id" => htmlspecialchars($row['id_tipo_identificacion']),
                                "tipo" => htmlspecialchars($row['nombre_tipo_identificacion']),
                            ),
                            "ciudad" => array(
                                "id" => htmlspecialchars($row['nombre_ciudad']),
                                "ciudad" => htmlspecialchars($row['nombre_ciudad']),
                            ),
                            "empresa" => array(
                                "id" => htmlspecialchars($row['id_empresa']),
                                "nit" => htmlspecialchars($row['nit']),
                                "nombre" => htmlspecialchars($row['nombre_empresa']),
                            ),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'usuario' => $mysqlArray,
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

    public function getConductorBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'con.id_conductor',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'con.id_conductor',
            'CONTENT' => '%%',
            'EMPRESA' => '%%',
        )
    ) {

        // var_dump($_condicional_);
        #resultados
        $mysqlArrayElements = array(
            'SQL_ROWS' => 0,
            'SQL_PAGE' => 0,
            'SQL_TOTAL_PAGES' => 0,
            'SQL_LIMIT' => 0,
            'SQL_INCREMENT' => 0,
            'SQL_COUNT' => 0,
        );

        $mysqlArrayUsuario = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(con.id_conductor) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "con.id_conductor, con.nombre_conductor, con.apellido_conductor,con.numero_documento, IFNULL(empr.nombre_empresa,'NO ENCONTRADO') AS nombre_empresa ";
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "conductor con ";
        $mysqlQuery .= "LEFT JOIN empresa empr ON empr.id_empresa = con.id_empresa ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas

        $mysqlQueryCount .= $mysqlQuery;
        // echo $mysqlQueryCount;
        $mysqlQueryColumns .= $mysqlQuery;
        // echo $mysqlQueryColumns;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param(
            'ss',
            $_condicional_['CONTENT'],
            $_condicional_['EMPRESA']
        );

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
                $mysqlStmt->bind_param(
                    'ss',
                    $_condicional_['CONTENT'],
                    $_condicional_['EMPRESA']
                );
                ///empr.nit,empr.nombre_empresa,empr.direccion
                if ($mysqlStmt->execute()) {
                    $mysqlResult = $mysqlStmt->get_result();
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push($mysqlArrayUsuario,
                            array(
                                "nro" => htmlspecialchars(
                                    (strtolower($_condicional_['BY']) == 'asc') ? $mysqlArrayElements['SQL_COUNT']-- : $mysqlArrayElements['SQL_COUNT']++
                                ),
                                "documento" => htmlspecialchars($row['numero_documento']),
                                "nombre" => htmlspecialchars($row['nombre_conductor']),
                                "apellido" => htmlspecialchars($row['apellido_conductor']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "opciones" => encrypt($row['id_conductor'], 1),
                            )
                        );

                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'conductor' => $mysqlArrayUsuario,
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
        // var_dump($this->arrayResponse);
        return $this->arrayResponse;
    }

}