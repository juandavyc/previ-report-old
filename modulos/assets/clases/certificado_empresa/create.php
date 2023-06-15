<?php

class CreateCertificadoEmpresa
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setCertificado(
        $_datos_ = array(
            'ID_ENTIDAD' => 1,
            'NOMBRE' => 1,
            'FECHA_EXP' => '2021-11-01',
            'FECHA_VEN' => '2999-11-01',
            'ID_TIPO' => 1,
            'FOTO' => '/images/sin_imagen.png',
            'ID_EMPRESA' => 1,
            'ID_USUARIO' => 1,
        )
    ) {
        $mysqlQuery = "CALL proc_empresa_certificado ";
        $mysqlQuery .= "(?,?,?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'isssisii',
            $_datos_['ID_ENTIDAD'],
            $_datos_['NOMBRE'],
            $_datos_['FECHA_EXP'],
            $_datos_['FECHA_VEN'],
            $_datos_['ID_TIPO'],
            $_datos_['FOTO'],
            $_datos_['ID_EMPRESA'],
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