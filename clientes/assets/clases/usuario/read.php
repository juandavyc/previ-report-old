<?php
class ReadUsuario
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayUsuarios = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getUsuarioInformacion(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'usua.id_usuario',
            'CEDULA' => 'usua.cedula_usuario',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";
        #tabla usuario
        $mysqlQuery .= "usua.id_usuario,usua.nombre_usuario,usua.apellido_usuario, ";
        $mysqlQuery .= "usua.correo_usuario,usua.telefono_usuario,usua.firma_usuario, ";
        $mysqlQuery .= "usua.fecha_formulario,usua.cedula_usuario,usua.fecha_nacimiento_usuario, ";
        #tabla rango
        $mysqlQuery .= "rang.id_rango,rang.nombre_rango, ";
        #tabla estado
        $mysqlQuery .= "estd.id_estado,estd.nombre_estado, ";
        #tabla usuario - responsable
        $mysqlQuery .= "usac.id_usuario As id_responsable, ";
        $mysqlQuery .= "usac.nombre_usuario As nombre_responsable, ";
        $mysqlQuery .= "usac.apellido_usuario As apellido_responsable ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "usuario usua ";
        #JOIN
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = usua.id_empresa ";
        $mysqlQuery .= "INNER JOIN rango rang ON rang.id_rango = usua.id_rango ";
        $mysqlQuery .= "INNER JOIN estado_usuario estd ON estd.id_estado = usua.id_estado ";
        $mysqlQuery .= "INNER JOIN usuario usac ON usac.id_usuario = usua.id_usuario_formulario ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND usua.id_rango > 1 ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY usua.id_usuario DESC; ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_usuario']),
                            "cedula" => htmlspecialchars($row['cedula_usuario']),
                            "nombre" => htmlspecialchars($row['nombre_usuario']),
                            "apellido" => htmlspecialchars($row['apellido_usuario']),
                            "correo" => htmlspecialchars($row['correo_usuario']),
                            "telefono" => htmlspecialchars($row['telefono_usuario']),
                            "fecha_nacimiento" => htmlspecialchars($row['fecha_nacimiento_usuario']),
                            "firma" => htmlspecialchars($row['firma_usuario']),
                            "id_empresa" => htmlspecialchars($row['id_empresa']),
                            "nit" => htmlspecialchars($row['nit']),
                            "empresa" => htmlspecialchars($row['nombre_empresa']),
                            "id_rango" => htmlspecialchars($row['id_rango']),
                            "rango" => htmlspecialchars($row['nombre_rango']),
                            "id_estado" => htmlspecialchars($row['id_estado']),
                            "estado" => htmlspecialchars($row['nombre_estado']),
                            "usuario" => htmlspecialchars($row['nombre_responsable'] . " " . $row['apellido_responsable']),
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

    public function getUsuarioBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'usua.id_usuario',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'usua.id_usuario',
            'CONTENT' => '%%',
            'RANGO' => '%%',
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

        $mysqlArrayUsuario = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(usua.id_usuario) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "usua.id_usuario,usua.cedula_usuario,usua.nombre_usuario,usua.apellido_usuario, ";
        $mysqlQueryColumns .= "empr.nombre_empresa,rang.nombre_rango,estd.nombre_estado ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "usuario usua ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = usua.id_empresa ";
        $mysqlQuery .= "INNER JOIN rango rang ON rang.id_rango = usua.id_rango ";
        $mysqlQuery .= "INNER JOIN estado_usuario estd ON estd.id_estado = usua.id_estado ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        $mysqlQuery .= "AND rang.id_rango LIKE ?  AND rang.id_rango > 1 ";
        $mysqlQuery .= "AND estd.id_estado LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param(
            'ssss',
            $_condicional_['CONTENT'],
            $_condicional_['EMPRESA'],
            $_condicional_['RANGO'],
            $_condicional_['ESTADO'],
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
                    'ssss',
                    $_condicional_['CONTENT'],
                    $_condicional_['EMPRESA'],
                    $_condicional_['RANGO'],
                    $_condicional_['ESTADO'],
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
                                "cedula" => htmlspecialchars($row['cedula_usuario']),
                                "nombre" => htmlspecialchars($row['nombre_usuario']),
                                "apellido" => htmlspecialchars($row['apellido_usuario']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "rango" => htmlspecialchars($row['nombre_rango']),
                                "estado" => htmlspecialchars($row['nombre_estado']),
                                "opciones" => $row['id_usuario'],
                            )
                        );

                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'usuario' => $mysqlArrayUsuario,
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