<?php

class UpdateSiniestro
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setInformacionSiniestro(
        $_datos_ = array(
            'ID' => 1,
            'ID_TIPO' => 1,
            'FECHA' => '2999-01-01',
            'HORA' => '00:00:01',
            'CIUDAD' => 1,
            'DIRECCION' => '',
            'HERIDOS' => 2,
            'MUERTOS' => 2,
            'VEHICULOS' => 2,
            'DESCRIPCION' => '...',
            'FIRMA' => '/images/sin_firma.png',
            'ID_USUARIO' => 1,
        )
    ) {

        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "siniestro ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "id_tipo_siniestro = ?,fecha_siniestro = ?, ";
        $mysqlQuery .= "hora_siniestro = ?,direccion_siniestro = ?, ";
        $mysqlQuery .= "id_ciudad = ?,heridos_siniestro = ?, ";
        $mysqlQuery .= "muertos_siniestro = ?,vehiculos_implicados_siniestro = ?, ";
        $mysqlQuery .= "descripcion_siniestro = ?,firma_siniestro = ?, ";
        $mysqlQuery .= "id_usuario = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_siniestro = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'isssiiiissii',
            $_datos_['ID_TIPO'],
            $_datos_['FECHA'],
            $_datos_['HORA'],
            $_datos_['DIRECCION'],
            $_datos_['CIUDAD'],
            $_datos_['HERIDOS'],
            $_datos_['MUERTOS'],
            $_datos_['VEHICULOS'],
            $_datos_['DESCRIPCION'],
            $_datos_['FIRMA'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información del Siniestro Guardada',
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