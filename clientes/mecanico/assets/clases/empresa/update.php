<?php

class UpdateEmpresa
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setDatosEmpresa(
        $_datos_ = array(
            'ID' => 0,
            'NOMBRE' => 1,
            'TELEFONO' => 1,
            'DIRECCION' => 'sin_direccion',
            'CORREO' => 'sin_correo@sin_correo.com',
            'ID_CIUDAD' => 1,
            'ID_USUARIO' => 1,
        )
    ) {
        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "empresa ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "nombre_empresa = ?,telefono = ?, ";
        $mysqlQuery .= "direccion = ?,correo = ?,id_ciudad = ?, ";
        $mysqlQuery .= "id_usuario = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_empresa = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ssssiii',
            $_datos_['NOMBRE'],
            $_datos_['TELEFONO'],
            $_datos_['DIRECCION'],
            $_datos_['CORREO'],
            $_datos_['ID_CIUDAD'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información de la empresa actualizada',
            );
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }

}