<?php

class UpdatePreoperacional
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setInformacionPreoperacional(
        $_datos_ = array(
            'ID' => 1,
            'VIGENCIA_TARJETA' => 3,
            'ENTIDAD_TARJETA' => '', 
            'FECHA_TARJETA' => '2999-01-01',
            'VIGENCIA_RTM' => 3,
            'ENTIDAD_RTM' => '',
            'FECHA_RTM' =>'2999-01-01',
            'VIGENCIA_GASES' => 3,
            'ENTIDAD_GASES' => '',
            'FECHA_GASES' => '2999-01-01',
            'VIGENCIA_FUEC' => 3,
            'ENTIDAD_FUEC' => '',
            'FECHA_FUEC' => '2999-01-01',
            'VIGENCIA_LICENCIA' => 3,
            'ENTIDAD_LICENCIA' => '',
            'FECHA_LICENCIA' => '2999-01-01',
            'VIGENCIA_POLIZA' => 3,
            'ENTIDAD_POLIZA' => '',
            'FECHA_POLIZA' => '2999-01-01',
            'VIGENCIA_SOAT' => 3,
            'ENTIDAD_SOAT' => '',
            'FECHA_SOAT' => '2999-01-01',
            'FOTO_KILOMETRAJE' => '/images/sin_imagen.png',
            'FOTO_COMBUSTIBLE' => '/images/sin_imagen.png',
            'ID_USUARIO' => 1,
        )
    ) { 

        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "preoperacional ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "tarjeta_propiedad_vigencia = ?, tarjeta_propiedad_entidad = ?, tarjeta_propiedad_fecha = ?,  ";
        $mysqlQuery .= "revision_rtm_vigencia = ?, revision_rtm_entidad = ?, revision_rtm_fecha = ?,  ";
        $mysqlQuery .= "certificado_gases_vigencia = ?, certificado_gases_entidad = ?, certificado_gases_fecha = ?,  ";
        $mysqlQuery .= "planilla_fuec_vigencia = ?, planilla_fuec_entidad = ?, planilla_fuec_fecha = ?,  ";
        $mysqlQuery .= "licencia_conduccion_vigencia = ?, licencia_conduccion_entidad = ?, licencia_conduccion_fecha = ?,  ";
        $mysqlQuery .= "poliza_vigencia = ?, poliza_entidad = ?, poliza_fecha = ?, ";
        $mysqlQuery .= "poliza_soat_vigencia = ?, poliza_soat_entidad = ?, poliza_soat_fecha = ?, ";
        $mysqlQuery .= "foto_tacometro_kilometraje = ?, foto_tacometro_combustible = ?, id_usuario_realiza = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_preoperacional = ? ; ";   

        // var_dump($mysqlQuery);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'issississississississssii',
            $_datos_['VIGENCIA_TARJETA'],
            $_datos_['ENTIDAD_TARJETA'],
            $_datos_['FECHA_TARJETA'],
            $_datos_['VIGENCIA_RTM'],
            $_datos_['ENTIDAD_RTM'],
            $_datos_['FECHA_RTM'],
            $_datos_['VIGENCIA_GASES'],
            $_datos_['ENTIDAD_GASES'],
            $_datos_['FECHA_GASES'],
            $_datos_['VIGENCIA_FUEC'],
            $_datos_['ENTIDAD_FUEC'],
            $_datos_['FECHA_FUEC'],
            $_datos_['VIGENCIA_LICENCIA'],
            $_datos_['ENTIDAD_LICENCIA'],
            $_datos_['FECHA_LICENCIA'],
            $_datos_['VIGENCIA_POLIZA'],
            $_datos_['ENTIDAD_POLIZA'],
            $_datos_['FECHA_POLIZA'],
            $_datos_['VIGENCIA_SOAT'],
            $_datos_['ENTIDAD_SOAT'],
            $_datos_['FECHA_SOAT'],
            $_datos_['FOTO_KILOMETRAJE'],
            $_datos_['FOTO_COMBUSTIBLE'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
        );
        

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información de Preoperativo Guardado',
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
