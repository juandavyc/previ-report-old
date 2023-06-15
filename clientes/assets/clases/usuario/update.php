<?php

class UpdateUsuario
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setDatosUsuario(
        $_datos_ = array(
            'ID' => 0,
            'NOMBRE' => '',
            'APELLIDO' => '',
            'FIRMA' => '/images/sin_firma.png',
            'TELEFONO' => '',
            'CORREO' => 'sin_correo@sin_correo.com',
            'FECHA_NACIMIENTO' => '2999-01-01',
            'ID_EMPRESA' => 1,
            'ID_RANGO' => 6,
            'ID_USUARIO' => 1,
        )
    ) {
        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "usuario ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "nombre_usuario = ?,apellido_usuario = ?, firma_usuario = ?, ";
        $mysqlQuery .= "telefono_usuario = ?,correo_usuario = ?, id_empresa = ?, ";
        $mysqlQuery .= "fecha_nacimiento_usuario = ?,id_usuario_formulario = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_usuario = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'sssssisii',
            $_datos_['NOMBRE'],
            $_datos_['APELLIDO'],
            $_datos_['FIRMA'],
            $_datos_['TELEFONO'],
            $_datos_['CORREO'],
            $_datos_['ID_EMPRESA'],
            $_datos_['FECHA_NACIMIENTO'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información del usuario actualizada',
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