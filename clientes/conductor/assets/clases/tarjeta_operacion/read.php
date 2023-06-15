<?php
class ReadTarjetaOperacion
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getTarjetaOperacion(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'tarj.id_tarjeta_operacion',
            'ID_VEHICULO' => 'tarj.id_vehiculo',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # TARJETA DE OPERACION
        $mysqlQuery .= "tarj.id_tarjeta_operacion, ";
        $mysqlQuery .= "tarj.numero_tarjeta_operacion,tarj.foto_tarjeta_operacion, ";
        $mysqlQuery .= "tarj.fecha_expedicion_tarjeta_operacion,tarj.fecha_vencimiento_tarjeta_operacion, ";
        $mysqlQuery .= "tarj.fecha_formulario, ";
        # EMPRESA
        $mysqlQuery .= "empr.id_empresa, empr.nit, empr.nombre_empresa, ";
        # VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        # MODALIDAD SERVICIO
        $mysqlQuery .= "mods.id_modalidad_servicio,mods.nombre_modalidad_servicio, ";
        # MODALIDAD TRANSPORTE
        $mysqlQuery .= "modt.id_modalidad_transporte,modt.nombre_modalidad_transporte, ";
        # RADIO ACCION
        $mysqlQuery .= "radi.id_radio_accion,radi.nombre_radio_accion, ";
        # ESTADO TARJ OPERACION
        $mysqlQuery .= "estt.id_estado_tarjeta_operacion, estt.nombre_estado_tarjeta_operacion, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario ";

        $mysqlQuery .= "FROM tarjeta_operacion tarj ";
        $mysqlQuery .= "LEFT JOIN empresa empr ON empr.id_empresa = tarj.id_empresa ";
        $mysqlQuery .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = tarj.id_vehiculo ";
        $mysqlQuery .= "LEFT JOIN modalidad_servicio mods ON mods.id_modalidad_servicio = tarj.id_modalidad_servicio ";
        $mysqlQuery .= "LEFT JOIN modalidad_transporte modt ON modt.id_modalidad_transporte = tarj.id_modalidad_transporte ";
        $mysqlQuery .= "LEFT JOIN radio_accion radi ON radi.id_radio_accion = tarj.id_radio_accion ";
        $mysqlQuery .= "LEFT JOIN estado_tarjeta_operacion estt ON estt.id_estado_tarjeta_operacion = tarj.id_estado_tarjeta_operacion ";
        $mysqlQuery .= "LEFT JOIN usuario usu ON usu.id_usuario = tarj.id_usuario ";
        $mysqlQuery .= "WHERE " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND tarj.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY tarj.id_tarjeta_operacion DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            if ($mysqlStmt->execute()) {
                $mysqlResult = $mysqlStmt->get_result();
                if (intval($mysqlResult->num_rows) > 0) {
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArray,
                            array(
                                "id" => htmlspecialchars($row['id_tarjeta_operacion']),
                                "numero" => htmlspecialchars($row['numero_tarjeta_operacion']),
                                "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_tarjeta_operacion']),
                                "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_tarjeta_operacion']),
                                "foto" => htmlspecialchars($row['foto_tarjeta_operacion']),
                                "empresa" => array(
                                    "id" => htmlspecialchars($row['id_empresa']),
                                    "nit" => htmlspecialchars($row['nit']),
                                    "nombre" => htmlspecialchars($row['nombre_empresa']),
                                ),
                                "servicio" => array(
                                    "id" => htmlspecialchars($row['id_modalidad_servicio']),
                                    "nombre" => htmlspecialchars($row['nombre_modalidad_servicio']),
                                ),
                                "transporte" => array(
                                    "id" => htmlspecialchars($row['id_modalidad_transporte']),
                                    "nombre" => htmlspecialchars($row['nombre_modalidad_transporte']),
                                ),
                                "radio" => array(
                                    "id" => htmlspecialchars($row['id_radio_accion']),
                                    "nombre" => htmlspecialchars($row['nombre_radio_accion']),
                                ),
                                "estado" => array(
                                    "id" => htmlspecialchars($row['id_estado_tarjeta_operacion']),
                                    "nombre" => htmlspecialchars($row['nombre_estado_tarjeta_operacion']),
                                ),
                                "vehiculo" => array(
                                    "id" => htmlspecialchars($row['id_vehiculo']),
                                    "placa" => htmlspecialchars($row['placa_vehiculo']),
                                ),
                                "usuario" => array(
                                    "id" => htmlspecialchars($row['id_usuario']),
                                    "nombre" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                                ),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'tarjeta_operacion' => $mysqlArray,
                    );
                } else {
                    $this->arrayResponse = array(
                        'status' => 'sin_resultados',
                        'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
                    );
                }
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta: ' . htmlspecialchars($mysqlStmt->error),
            );
        }

        return $this->arrayResponse;
    }
}