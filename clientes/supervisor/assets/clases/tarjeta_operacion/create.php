<?php

class CreateTarjetaOperacion
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setTarjetaOperacion(
        $_id_empresa = 1,
        $_modalidad_transporte = 1,
        $_modalidad_servicio = 1,
        $_radio_de_accion = 1,
        $_numero_tarjeta_operacion = '',
        $_estado_tarjeta_operacion = 1,
        $_fecha_expedicion = '2999-01-01',
        $_fecha_vencimiento = '2999-01-01',
        $_foto_tarjeta_de_operacion = '/images/sin_imagen.png',
        $_id_vehiculo = 1,
        $_id_usuario = 1,
        $_numero_vehiculo_interno = ''
    ) {

        $mysqlQuery = "CALL proc_vehiculo_tarjeta_de_operacion ";
        $mysqlQuery .= "(?,?,?,?,?,?,?,?,?,?,?,?,@respuesta);";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'iiiisisssiis',
            $_id_empresa,
            $_modalidad_transporte,
            $_modalidad_servicio,
            $_radio_de_accion,
            $_numero_tarjeta_operacion,
            $_estado_tarjeta_operacion,
            $_fecha_expedicion,
            $_fecha_vencimiento,
            $_foto_tarjeta_de_operacion,
            $_id_vehiculo,
            $_id_usuario,
            $_numero_vehiculo_interno
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();

            $mysqlQuery = "SELECT @respuesta As JSON_PROC; ";
            $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
            if ($mysqlStmt->execute()) {

                $mysqlResult = $mysqlStmt->get_result();
                $row = $mysqlResult->fetch_assoc();
                $mysqlDecode = json_decode($row['JSON_PROC']);

                $mysqlStmt->close();

                $this->arrayResponse = array(
                    'status' => $mysqlDecode[0],
                    'message' => $mysqlDecode[1],
                    'id' => isset($mysqlDecode[2]) ? $mysqlDecode[2] : '',
                    'numero' => isset($mysqlDecode[3]) ? $mysqlDecode[3] : '',
                );
            } else {
                $this->arrayResponse = array(
                    'status' => 'error',
                    'message' => 'Error en la consulta #2 : ' . htmlspecialchars($mysqlStmt->error),
                );
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta #1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }

}