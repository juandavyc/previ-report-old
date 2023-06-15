<?php

class CreateVehiculoImplicado
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setVehiculo(
        $_datos_ = array(
            'PLACA' => '',
            'MARCA' => 1,
            'MODELO' => '2999',
            'CONDUCTOR' => '',
            'TELEFONO' => '',
            'CORREO' => '',
            'DIRECCION' => '',
            'ASEGURADORA' => '',
            'ASEGURADORA_TELEFONO' => '',
            'POLIZA' => '',
            'POLIZA_ASEGURADORA' => '',
            'FECHA_EXPEDICION' => '2999-01-01',
            'FECHA_VENCIMIENTO' => '2999-01-01',
            'ID_SINIESTRO' => 1,
            'ID_USUARIO' => 1,
        )
    ) {

        $mysqlQuery = "CALL proc_siniestro_vehiculo_implicado ";
        $mysqlQuery .= "(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'sssssssssssssii',
            $_datos_['PLACA'],
            $_datos_['MARCA'],
            $_datos_['MODELO'],
            $_datos_['CONDUCTOR'],
            $_datos_['TELEFONO'],
            $_datos_['CORREO'],
            $_datos_['DIRECCION'],
            $_datos_['ASEGURADORA'],
            $_datos_['ASEGURADORA_TELEFONO'],
            $_datos_['POLIZA'],
            $_datos_['POLIZA_ASEGURADORA'],
            $_datos_['FECHA_EXPEDICION'],
            $_datos_['FECHA_VENCIMIENTO'],
            $_datos_['ID_SINIESTRO'],
            $_datos_['ID_USUARIO'],
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
                    'nombre' => isset($mysqlDecode[3]) ? $mysqlDecode[3] : '',
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