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
    public function getVehiculo(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,

        ),
        $_limite_ = '0,1',
        $_empresa_ = '%%'
    ) {

        $arrayCondicional = array(
            'ID' => 'veh.id_vehiculo',
            'PLACA' => 'veh.placa_vehiculo',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        $mysqlQuery .= "veh.fecha_matricula_vehiculo, ";
        $mysqlQuery .= "veh.numero_licencia_vehiculo, tveh.id_tipo_vehiculo, ";
        $mysqlQuery .= "veh.modelo_vehiculo, ";
        $mysqlQuery .= "veh.numero_serie_vehiculo, veh.numero_motor_vehiculo,  ";
        $mysqlQuery .= "veh.vin_vehiculo, veh.cilindraje_vehiculo,  ";
        $mysqlQuery .= "veh.gravamenes_vehiculo, veh.clasico_antiguo, veh.repotenciado ,veh.estado_vehiculo, ";
        $mysqlQuery .= "veh.ensenianza_vehiculo,  ";
        $mysqlQuery .= "veh.regrabacion_motor, veh.numero_regrabacion_motor, ";
        $mysqlQuery .= "veh.regrabacion_chasis, veh.numero_regrabacion_chasis, ";
        $mysqlQuery .= "veh.regrabacion_vin, veh.numero_regrabacion_vin, ";
        $mysqlQuery .= "veh.regrabacion_serie, veh.numero_regrabacion_serie, ";
        $mysqlQuery .= "veh.kilometraje_vehiculo, ";
        # AUTORIDAD
        $mysqlQuery .= "aut.id_autoridad_de_transito ,aut.nombre_autoridad_de_transito, ";

        # MARCA
        $mysqlQuery .= "mar.id_marca, mar.nombre_marca, ";
        # LINEA
        $mysqlQuery .= "lin.id_linea, lin.nombre_linea, ";
        # SERVICIO
        $mysqlQuery .= "ser.id_servicio, ser.nombre_servicio, ";
        # COLOR
        $mysqlQuery .= "col.id_color,col.nombre_color, ";
        # COMBUSTIBLE
        $mysqlQuery .= "tcom.id_combustible,tcom.nombre_combustible, ";
        # EMPRESA
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa,  ";
        # CLASE
        $mysqlQuery .= "cla.id_clase, cla.nombre_clase, ";
        # TIPO
        $mysqlQuery .= "tveh.id_tipo_vehiculo, tveh.nombre_tipo_vehiculo, ";
        # CARROCERIA
        $mysqlQuery .= "car.id_tipo_carroceria,car.nombre_tipo_carroceria, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario,usu.apellido_usuario, ";
        # FOTOS
        $mysqlQuery .= "veh.foto_delantera,veh.foto_trasera,veh.foto_costado_izquierdo,veh.foto_costado_derecho, ";
        $mysqlQuery .= "veh.fecha_formulario ";

        $mysqlQuery .= "FROM vehiculo veh ";
        $mysqlQuery .= "INNER JOIN clase cla ON cla.id_clase = veh.id_clase ";
        $mysqlQuery .= "INNER JOIN tipo_vehiculo tveh ON tveh.id_tipo_vehiculo = cla.id_tipo_vehiculo ";
        $mysqlQuery .= "INNER JOIN servicio ser ON ser.id_servicio = veh.id_servicio ";
        $mysqlQuery .= "INNER JOIN linea lin ON lin.id_linea = veh.id_linea ";
        $mysqlQuery .= "INNER JOIN marca mar ON mar.id_marca = lin.id_marca ";
        $mysqlQuery .= "INNER JOIN color col ON col.id_color = veh.id_color ";
        $mysqlQuery .= "INNER JOIN combustible tcom ON tcom.id_combustible = veh.id_combustible ";
        $mysqlQuery .= "INNER JOIN usuario usu ON usu.id_usuario = veh.id_usuario ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = veh.id_empresa ";
        $mysqlQuery .= "LEFT JOIN tipo_carroceria car ON car.id_tipo_carroceria = veh.id_tipo_carroceria  ";
        $mysqlQuery .= "LEFT JOIN autoridad_de_transito aut ON aut.id_autoridad_de_transito = veh.id_autoridad_de_transito ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        $mysqlQuery .= "ORDER BY veh.id_vehiculo DESC LIMIT " . $_limite_ . ";";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('ss', $_condicional_['VALUE'], $_empresa_);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_vehiculo']),
                            "placa" => htmlspecialchars($row['placa_vehiculo']),
                            "id_tipo" => htmlspecialchars($row['id_tipo_vehiculo']),
                            "tipo" => htmlspecialchars($row['nombre_tipo_vehiculo']),
                            "id_servicio" => htmlspecialchars($row['id_servicio']),
                            "servicio" => htmlspecialchars($row['nombre_servicio']),
                            "id_clase" => htmlspecialchars($row['id_clase']),
                            "clase" => htmlspecialchars($row['nombre_clase']),
                            "id_marca" => htmlspecialchars($row['id_marca']),
                            "marca" => htmlspecialchars($row['nombre_marca']),
                            "id_linea" => htmlspecialchars($row['id_linea']),
                            "linea" => htmlspecialchars($row['nombre_linea']),
                            "modelo" => htmlspecialchars($row['modelo_vehiculo']),
                            "id_color" => htmlspecialchars($row['id_color']),
                            "color" => htmlspecialchars($row['nombre_color']),
                            "kilometraje" => htmlspecialchars($row['kilometraje_vehiculo']),
                            "id_combustible" => htmlspecialchars($row['id_combustible']),
                            "combustible" => htmlspecialchars($row['nombre_combustible']),
                            "cilindraje" => htmlspecialchars($row['cilindraje_vehiculo']),

                            "id_carroceria" => htmlspecialchars($row['id_tipo_carroceria']),
                            "carroceria" => htmlspecialchars($row['nombre_tipo_carroceria']),

                            "id_empresa" => htmlspecialchars($row['id_empresa']),
                            "nit" => htmlspecialchars($row['nit']),
                            "nombre_empresa" => htmlspecialchars($row['nombre_empresa']),

                            "numero_serie" => htmlspecialchars($row['numero_serie_vehiculo']),
                            "numero_motor" => htmlspecialchars($row['numero_motor_vehiculo']),
                            "vin" => htmlspecialchars($row['vin_vehiculo']),

                            "gravamene" => htmlspecialchars($row['gravamenes_vehiculo']),

                            "clasico_antiguo" => htmlspecialchars($row['clasico_antiguo']),
                            "repotenciado" => htmlspecialchars($row['repotenciado']),
                            "estado_vehiculo" => htmlspecialchars($row['estado_vehiculo']),
                            "ensenianza" => htmlspecialchars($row['ensenianza_vehiculo']),
                            "regrabacion_motor" => htmlspecialchars($row['regrabacion_motor']),

                            "numero_regrabacion_motor" => htmlspecialchars($row['numero_regrabacion_motor']),
                            "regrabacion_chasis" => htmlspecialchars($row['regrabacion_chasis']),
                            "numero_regrabacion_chasis" => htmlspecialchars($row['numero_regrabacion_chasis']),
                            "regrabacion_vin" => htmlspecialchars($row['regrabacion_vin']),
                            "numero_regrabacion_vin" => htmlspecialchars($row['numero_regrabacion_vin']),
                            "regrabacion_serie" => htmlspecialchars($row['regrabacion_serie']),
                            "numero_regrabacion_serie" => htmlspecialchars($row['numero_regrabacion_serie']),
                            "fecha_matricula" => htmlspecialchars($row['fecha_matricula_vehiculo']),
                            "numero_licencia" => htmlspecialchars($row['numero_licencia_vehiculo']),
                            "foto_delantera" => htmlspecialchars($row['foto_delantera']),
                            "foto_trasera" => htmlspecialchars($row['foto_trasera']),
                            "foto_costado_izquierdo" => htmlspecialchars($row['foto_costado_izquierdo']),
                            "foto_costado_derecho" => htmlspecialchars($row['foto_costado_derecho']),

                            "id_autoridad_de_transito" => htmlspecialchars($row['id_autoridad_de_transito']),
                            "autoridad_de_transito" => htmlspecialchars($row['nombre_autoridad_de_transito']),

                            "usuario" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                        )
                    );
                }

                // var_dump($row['nombre_ciudad']);

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

    public function getVehiculoBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'usua.id_usuario',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'usua.id_usuario',
            'CONTENT' => '%%',
            'TIPO' => '%%',
            'SERVICIO' => '%%',
            
        )
    ) {

        // var_dump($_condicional_});
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
        $mysqlQueryCount = "SELECT COUNT(veh.id_vehiculo) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        $mysqlQueryColumns .= "veh.fecha_matricula_vehiculo,cla.nombre_clase, ";
        $mysqlQueryColumns .= "veh.numero_licencia_vehiculo, tveh.nombre_tipo_vehiculo, ";
        $mysqlQueryColumns .= "empr.nombre_empresa,ser.nombre_servicio ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "vehiculo veh ";
        $mysqlQuery .= "LEFT JOIN servicio ser ON veh.id_servicio = ser.id_servicio ";
        $mysqlQuery .= "LEFT JOIN clase cla ON cla.id_clase = veh.id_clase ";
        $mysqlQuery .= "LEFT JOIN tipo_vehiculo tveh ON tveh.id_tipo_vehiculo = cla.id_tipo_vehiculo ";
        $mysqlQuery .= "LEFT JOIN empresa empr ON empr.id_empresa = veh.id_empresa ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND tveh.id_tipo_vehiculo LIKE ? ";
        $mysqlQuery .= "AND ser.id_servicio LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY " . $_condicional_['ORDER'] . " " . $_condicional_['BY'] . " ";
        #Une las consultas

        $mysqlQueryCount .= $mysqlQuery;
        $mysqlQueryColumns .= $mysqlQuery;

        // var_dump($mysqlQueryColumns);
        // echo $mysqlQueryCount;
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQueryCount);
        $mysqlStmt->bind_param(
            'ssss',
            $_condicional_['CONTENT'],
            $_condicional_['TIPO'],
            $_condicional_['SERVICIO'],
            $_condicional_['EMPRESA'],
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
                    $_condicional_['TIPO'],
                    $_condicional_['SERVICIO'],
                    $_condicional_['EMPRESA'],
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
                                "placa" => htmlspecialchars($row['placa_vehiculo']),
                                "tipo" => htmlspecialchars($row['nombre_tipo_vehiculo']),
                                "clase" => htmlspecialchars($row['nombre_clase']),
                                "servicio" => htmlspecialchars($row['nombre_servicio']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "opciones" => encrypt($row['id_vehiculo'], 1),
                            )
                        );

                    }
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'vehiculo' => $mysqlArrayUsuario,
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