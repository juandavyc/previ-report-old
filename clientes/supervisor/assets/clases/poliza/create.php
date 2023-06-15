<?php

class CreatePoliza
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setPoliza(
        $_id_aseguradora = 1,
        $_numero = '',
        $_fecha_expedicion = '2999-01-01',
        $_fecha_vencimiento = '2999-01-01',
        $_tipo = 1,
        $_foto = '/images/sin_imagen.png',
        $_id_vehiculo = 1,
        $_id_usuario = 1
    ) {
        $mysqlQuery = "CALL proc_vehiculo_poliza ";
        $mysqlQuery .= "(?,?,?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'iissisii',
            $_id_aseguradora,
            $_numero,
            $_fecha_expedicion,
            $_fecha_vencimiento,
            $_tipo,
            $_foto,
            $_id_vehiculo,
            $_id_usuario,
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