<?php

class UpdateMantenimiento
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setInformacionMantenimiento(
        $_datos_ = array(
            'ID' => 1,
            'ID_TIPO' => 1,
            'PERIODO' => 1,
            'FECHA' => '2999-01-01',
            'DIRECCION' => '',
            'PRECIO_MANO' => 1,
            'PRECIO_REPUESTOS' => '',
            'CANTIDAD' => 1,    
            'ID_USUARIO' => 1,
        )
    ) {


        // var_dump($_datos_);
        
        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "mantenimiento ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "id_tipo_mantenimiento = ?, periodo_mantenimiento = ?, fecha_mantenimiento = ?, ";
        $mysqlQuery .= "direccion_mantenimiento = ?, precio_mano_obra_mantenimiento = ?, ";
        $mysqlQuery .= "precio_repuestos_mantenimiento_total = ?, cantidad_repuestos_mantenimiento_total = ?,  ";
        $mysqlQuery .= "id_usuario = ?  ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_mantenimiento = ? ; ";

        // var_dump($mysqlQuery);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'iisssssii',
            $_datos_['ID_TIPO'],
            $_datos_['PERIODO'],
            $_datos_['FECHA'],
            $_datos_['DIRECCION'],
            $_datos_['PRECIO_MANO'],
            $_datos_['PRECIO_REPUESTOS'],
            $_datos_['CANTIDAD'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );
        

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información de Mantenimiento Guardado',
            );
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }


    public function setProcedimientoMantenimiento(
        $_datos_ = array(
            'ID' => 1,   
            'FIRMA' => 'SIN_FIRMA',    
            'REPUESTO' => '',    
            'FECHA_INICIAL' => '2999-01-01', 
            'HORA_INICIAL' => '00:00:01', 
            'FECHA_FINAL' => '2999-01-01', 
            'HORA_FINAL' => '00:00:01', 
            'DESCRIPCION_REALIZAR' => '', 
            'DESCRIPCION_REALIZADO' => '', 
            'ID_USUARIO' => 1,
        )
    ) {

        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "mantenimiento ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "repuesto_a_utilizar = ?, fecha_inicio_mantenimiento = ?, hora_inicio_mantenimiento = ?, ";
        $mysqlQuery .= "descripcion_trabajo_a_realizar = ?, ";
        $mysqlQuery .= "fecha_fin_mantenimiento = ?, hora_fin_mantenimiento = ?, ";
        $mysqlQuery .= "descripcion_procedimiento_realizado = ?,firma_mecanico = ?, id_usuario = ?  ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_mantenimiento = ?;";

        // var_dump($mysqlQuery);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ssssssssii',
            $_datos_['REPUESTO'],
            $_datos_['FECHA_INICIAL'],
            $_datos_['HORA_INICIAL'],
            $_datos_['DESCRIPCION_REALIZAR'],
            $_datos_['FECHA_FINAL'],
            $_datos_['HORA_FINAL'],
            $_datos_['DESCRIPCION_REALIZADO'],
            $_datos_['FIRMA'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );


        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información de Mantenimiento Guardado',
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
