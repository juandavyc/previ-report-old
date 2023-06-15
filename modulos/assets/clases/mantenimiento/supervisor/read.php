<?php
class ReadMantenimientoSuper
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayUsuarios = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getMantenimientoSuper(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
            'LIMITE' => '0',
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'mant.id_mantenimiento',
            'ID_VEHICULO' => 'vehi.id_vehiculo',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "empr.id_empresa,empr.nit,empr.nombre_empresa, ";
        #tabla manteinimiento
        $mysqlQuery .= "mant.id_mantenimiento,mant.periodo_mantenimiento,mant.order_servicio_mantenimiento, ";
        $mysqlQuery .= "mant.numero_order_servicio_mantenimiento,mant.fecha_mantenimiento, ";
        $mysqlQuery .= "mant.firma_supervisor,mant.firma_mecanico, ";
        $mysqlQuery .= "mant.precio_mano_obra_mantenimiento, ";
        $mysqlQuery .= "mant.cantidad_repuestos_mantenimiento_total, mant.precio_repuestos_mantenimiento_total, ";
        $mysqlQuery .= "mant.fecha_inicio_mantenimiento,mant.hora_inicio_mantenimiento,mant.hora_fin_mantenimiento, mant.fecha_fin_mantenimiento, ";
        $mysqlQuery .= "mant.observaciones_mantenimiento,mant.fecha_formulario, ";
        #tabla tipo mantenimiento
        $mysqlQuery .= "tipo.id_tipo_mantenimiento,tipo.nombre_tipo_mantenimiento, ";
        #tabla usuario # mecanico
        $mysqlQuery .= "usum.id_usuario As id_mecanico, CONCAT(usum.nombre_usuario,' ',usum.apellido_usuario) As nombre_mecanico, ";
        #tabla # TALLER
        $mysqlQuery .= "tall.id_taller, tall.nit_taller, tall.nombre_taller, ";
        #tabla # VEHICULO
        $mysqlQuery .= "vehi.id_vehiculo, vehi.placa_vehiculo, ";

        #tabla# revuelta por que se me dio
        $mysqlQuery .= "usum.foto_usuario, CONCAT(usu.nombre_usuario,' ',usu.apellido_usuario) As nombre_autoriza, usu.cedula_usuario As cedula_autoriza,usu.telefono_usuario As telefono_autoriza, ran.nombre_rango, ";
        $mysqlQuery .= "usum.cedula_usuario As cedula_mecanico, usum.telefono_usuario As telefono_mecanico, usum.correo_usuario As correo_mecanico, ciu.nombre_ciudad, tall.telefono_taller, tall.direccion_taller, tall.correo_taller, ";
        $mysqlQuery .= "mant.descripcion_trabajo_a_realizar, mant.repuesto_a_utilizar, mant.observaciones_mantenimiento, habmant.firma_habeas,concat (us.nombre_usuario,' ', us.apellido_usuario) As responsable_habeas, habmant.fecha_formulario_habeas_mantenimiento,hab.nombre_habeas_data, mant.procedimiento_fin_realizado ";

        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "mantenimiento mant ";
        #JOIN
        $mysqlQuery .= "INNER JOIN vehiculo vehi ON vehi.id_vehiculo = mant.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN usuario usum ON usum.id_usuario = mant.id_usuario "; # Mecanico
        $mysqlQuery .= "INNER JOIN usuario usu ON usu.id_usuario = mant.id_usuario_formulario "; # AUTORIZA
        $mysqlQuery .= "INNER JOIN tipo_mantenimiento tipo ON tipo.id_tipo_mantenimiento = mant.id_tipo_mantenimiento ";
        $mysqlQuery .= "INNER JOIN taller tall ON tall.id_taller = usum.id_taller ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = vehi.id_empresa ";
        $mysqlQuery .= "INNER JOIN rango ran ON usu.id_rango = ran.id_rango ";
        $mysqlQuery .= "INNER JOIN rango rang ON usum.id_rango = rang.id_rango ";
        $mysqlQuery .= "INNER JOIN ciudad ciu ON tall.id_ciudad = ciu.id_ciudad ";
        $mysqlQuery .= "LEFT JOIN habeas_mantenimiento habmant ON mant.id_mantenimiento = habmant.id_mantenimiento ";
        $mysqlQuery .= "LEFT JOIN usuario us ON habmant.id_usuario = us.id_usuario ";
        $mysqlQuery .= "LEFT JOIN habeas_data hab ON habmant.id_habeas_data = hab.id_habeas_data ";

        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY mant.id_mantenimiento DESC LIMIT " . $_condicional_['LIMITE'] . "; ";

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
                            "id" => htmlspecialchars($row['id_mantenimiento']),
                            "periodo" => htmlspecialchars($row['periodo_mantenimiento']),
                            "orden" => htmlspecialchars($row['order_servicio_mantenimiento']),
                            "numero_orden" => htmlspecialchars($row['numero_order_servicio_mantenimiento']),
                            "fecha_mantenimiento" => htmlspecialchars($row['fecha_mantenimiento']),
                            "firma_supervisor" => htmlspecialchars($row['firma_supervisor']),
                            "firma_mecanico" => htmlspecialchars($row['firma_mecanico']),
                            "precio_mano_de_obra" => htmlspecialchars($row['precio_mano_obra_mantenimiento']),
                            "cantidad_respuestos" => htmlspecialchars($row['cantidad_repuestos_mantenimiento_total']),
                            "precio_repuestos" => htmlspecialchars($row['precio_repuestos_mantenimiento_total']),
                            "fecha_inicio" => htmlspecialchars($row['fecha_inicio_mantenimiento']),
                            "fecha_fin" => htmlspecialchars($row['fecha_fin_mantenimiento']),
                            "observaciones" => htmlspecialchars($row['observaciones_mantenimiento']),
                            "id_tipo" => htmlspecialchars($row['id_tipo_mantenimiento']),
                            "nombre_tipo" => htmlspecialchars($row['nombre_tipo_mantenimiento']),
                            "id_mecanico" => htmlspecialchars($row['id_mecanico']),
                            "nombre_mecanico" => htmlspecialchars($row['nombre_mecanico']),
                            "id_taller" => htmlspecialchars($row['id_taller']),
                            "nit_taller" => htmlspecialchars($row['nit_taller']),
                            "nombre_taller" => htmlspecialchars($row['nombre_taller']),
                            "id_vehiculo" => htmlspecialchars($row['placa_vehiculo']),
                            "placa" => htmlspecialchars($row['placa_vehiculo']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                            "cedula_supervisor" => htmlspecialchars($row['cedula_autoriza']),
                            "cedula_mecanico" => htmlspecialchars($row['cedula_mecanico']),
                            "nombre_autoriza" => htmlspecialchars($row['nombre_autoriza']),
                            "habeas" => htmlspecialchars($row['nombre_habeas_data']),
                            "nombre_habeas" => htmlspecialchars($row['responsable_habeas']),
                            "fecha_habeas" => htmlspecialchars($row['fecha_formulario_habeas_mantenimiento']),
                            # verificar firma
                            "firma_habeas" => htmlspecialchars(is_null($row['firma_habeas']) ? '/images/sin_firma.png' : ($row['firma_habeas'])),
                            "telefono_autoriza" => htmlspecialchars($row['telefono_autoriza']),
                            "cargo" => htmlspecialchars($row['nombre_rango']),
                            "telefono_mecanico" => htmlspecialchars($row['telefono_mecanico']),
                            "correo_mecanico" => htmlspecialchars($row['correo_mecanico']),
                            "ciudad_taller" => htmlspecialchars($row['nombre_ciudad']),
                            "telefono_taller" => htmlspecialchars($row['telefono_taller']),
                            "direccion_taller" => htmlspecialchars($row['direccion_taller']),
                            "correo_taller" => htmlspecialchars($row['correo_taller']),
                            "descripcion_danos" => htmlspecialchars($row['descripcion_trabajo_a_realizar']),
                            "repuestos_utilizados" => htmlspecialchars($row['repuesto_a_utilizar']),
                            "procedimiento_realizado" => htmlspecialchars($row['procedimiento_fin_realizado']),
                            "vehiculo_fotos" => htmlspecialchars($row['id_vehiculo']),
                            "hora_inicio" => htmlspecialchars($row['hora_inicio_mantenimiento']),
                            "hora_fin" => htmlspecialchars($row['hora_fin_mantenimiento']),

                        )
                    );
                }

                // var_dump($row['nombre_ciudad']);

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

    public function getMantenimientoBuscador(
        #Condicion del SQL
        $_condicional_ = array(
            'ORDER' => 'mant.id_mantenimiento',
            'BY' => 'DESC',
            'PAGE' => '1',
            'ROWS' => '25',
            'COLUMN' => 'mant.id_mantenimiento',
            'CONTENT' => '%%',
            'TIPO_MANTENIMIENTO' => '%%',
            'EMPRESA' => '%%',
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
        $mysqlQueryCount = "SELECT COUNT(mant.id_mantenimiento) As MY_TOTAL_ROWS ";
        $mysqlQueryColumns = "SELECT ";
        #Columnas
        $mysqlQueryColumns .= "mant.id_mantenimiento,mant.periodo_mantenimiento, ";
        $mysqlQueryColumns .= "mant.fecha_formulario, ";
        $mysqlQueryColumns .= "vehi.placa_vehiculo,empr.nombre_empresa,tipo.nombre_tipo_mantenimiento ";
        #Tabla
        $mysqlQuery = "FROM ";
        $mysqlQuery .= "mantenimiento mant ";
        $mysqlQuery .= "INNER JOIN vehiculo vehi ON vehi.id_vehiculo = mant.id_vehiculo ";
        $mysqlQuery .= "INNER JOIN empresa empr ON empr.id_empresa = vehi.id_empresa ";
        $mysqlQuery .= "INNER JOIN tipo_mantenimiento tipo ON tipo.id_tipo_mantenimiento = mant.id_tipo_mantenimiento ";
        #Condicion
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $_condicional_['COLUMN'] . " LIKE ? ";
        $mysqlQuery .= "AND empr.id_empresa LIKE ? ";
        $mysqlQuery .= "AND mant.id_tipo_mantenimiento LIKE ? ";
        $mysqlQuery .= "AND mant.fecha_formulario BETWEEN ? AND ? ";
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
            $_condicional_['TIPO_MANTENIMIENTO'],
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
                    $_condicional_['TIPO_MANTENIMIENTO'],
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
                                "periodo" => htmlspecialchars($row['periodo_mantenimiento']),
                                "tipo" => htmlspecialchars($row['nombre_tipo_mantenimiento']),
                                "empresa" => htmlspecialchars($row['nombre_empresa']),
                                "agregado" => getSpecialDateTime($row['fecha_formulario']),
                                "opciones" => encrypt($row['id_mantenimiento'], 1),
                            )
                        );
                    }
                    // var_dump($mysqlArraySiniestro);
                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'elements' => $mysqlArrayElements,
                        'mantenimiento' => $mysqlArray,
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