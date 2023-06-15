<?php

class CreateTestigo
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setTestigo(
        $_datos_ = array(
            'NOMBRE' => '',
            'TELEFONO' => '',
            'CORREO' => '',
            'DIRECCION' => '',
            'ID_SINIESTRO' => 1,
            'ID_USUARIO' => 1,
        )
    ) {

        $mysqlQuery = "CALL proc_siniestro_testigo ";
        $mysqlQuery .= "(?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ssssii',
            $_datos_['NOMBRE'],
            $_datos_['TELEFONO'],
            $_datos_['CORREO'],
            $_datos_['DIRECCION'],
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