<?php

class UpdateCertificado
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setIsVisible(
        $_datos_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
            'ID_USUARIO' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'id_certificado_empresa',
            'ID_EMPRESA' => 'id_empresa',
        );

        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "certificado_empresa ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "is_visible = 2,";
        $mysqlQuery .= "id_usuario = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_datos_['TYPE']] . " = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ii',
            $_datos_['ID_USUARIO'],
            $_datos_['VALUE']
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Certificado Eliminado',
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