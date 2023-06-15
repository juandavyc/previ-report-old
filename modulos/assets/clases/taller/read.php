<?php
class ReadTaller
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arraytallesas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getTallerInformacion(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
            'EMPRESA' => '%%',
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'tall.id_taller',
            'NIT' => 'tall.nit_taller',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla tallesa
        $mysqlQuery .= "tall.id_taller,tall.nit_taller,tall.nombre_taller,tall.direccion_taller, ";
        $mysqlQuery .= "tall.fecha_formulario,tall.telefono_taller,tall.correo_taller,";
        #tabla ciudad
        $mysqlQuery .= "ciud.nombre_ciudad,ciud.id_ciudad, ";
        #tabla departamento
        $mysqlQuery .= "dept.nombre_departamento,dept.id_departamento, ";
        #tabla usuario
        $mysqlQuery .= "usua.nombre_usuario,usua.apellido_usuario, ";
        #tabla EMPRESA
        $mysqlQuery .= "emp.id_empresa,emp.nombre_empresa ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "taller tall ";
        #JOIN
        $mysqlQuery .= "LEFT JOIN ciudad ciud ON tall.id_ciudad = ciud.id_ciudad ";
        $mysqlQuery .= "LEFT JOIN departamento dept ON dept.id_departamento = ciud.id_departamento ";
        $mysqlQuery .= "LEFT JOIN usuario usua ON tall.id_usuario = usua.id_usuario ";
        $mysqlQuery .= "LEFT JOIN empresa emp ON tall.id_empresa = emp.id_empresa ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? AND ";
        $mysqlQuery .= "tall.id_empresa LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY tall.id_taller DESC; ";


        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('ss', $_condicional_['VALUE'], $_condicional_['EMPRESA']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_taller']),
                            "nit" => htmlspecialchars($row['nit_taller']),
                            "nombre" => htmlspecialchars($row['nombre_taller']),
                            "telefono" => htmlspecialchars($row['telefono_taller']),
                            "direccion" => htmlspecialchars($row['direccion_taller']),
                            "correo" => htmlspecialchars($row['correo_taller']),
                            "id_ciudad" => htmlspecialchars($row['id_ciudad']),
                            "ciudad" => htmlspecialchars($row['nombre_ciudad']),
                            "id_departamento" => htmlspecialchars($row['id_departamento']),
                            "departamento" => htmlspecialchars($row['nombre_departamento']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                            "empresa" => htmlspecialchars($row['id_empresa']),
                            "nombre_empresa" => htmlspecialchars($row['nombre_empresa']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'taller' => $mysqlArray,
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

    public function getTallerBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'tall.id_taller',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'tall.id_taller',
            'CONTENT' => '%%',
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

        $mysqlArray = array();
        #Contador
        $mysqlQueryCount = "SELECT COUNT(tall.id_taller) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "tall.id_taller,tall.nit_taller,tall.nombre_taller, empr.id_empresa, empr.nombre_empresa,";
        $mysqlQueryColumns .= "ciud.nombre_ciudad ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "taller tall ";
        $mysqlQuery .= "LEFT JOIN ciudad ciud ON tall.id_ciudad = ciud.id_ciudad ";
        $mysqlQuery .= "LEFT JOIN empresa empr ON tall.id_empresa = empr.id_empresa ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND tall.id_empresa LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas
        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        // echo $mysqlQueryCount;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param('ss', $_condicional_['CONTENT'], $_condicional_['EMPRESA']);
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
                $mysqlStmt->bind_param('ss', $_condicional_['CONTENT'], $_condicional_['EMPRESA']);
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
                                "nit" => htmlspecialchars($row['nit_taller']),
                                "nombre" => htmlspecialchars($row['nombre_taller']),
                                "ciudad" => htmlspecialchars($row['nombre_ciudad']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                # "direccion" => htmlspecialchars($row['direccion']),
                                "opciones" => encrypt($row['id_taller'], 1),
                            )
                        );
                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'taller' => $mysqlArray,
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