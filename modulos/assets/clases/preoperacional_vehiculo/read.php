<?php
class PreoperacionalVehiculo
{

    public $array_preoperacional_vehiculo = array();
    public $contador_preoperacional_vehiculo = 0;

    public function __construct($_database)

    {

        $this->conn = $_database;
    }
    public function getPreoperacional(
        $_condicional_ = array(

            'TYPE' => 'ID_PREOPERACIONAL',
            'VALUE' => 1,
            'LIMITE' => '0',

        )

    ) {
        
        $arrayCondicional = array(
            'ID_VEHICULO' => 'veh.id_vehiculo',
            'ID_PREOPERACIONAL' => 'pre.id_preoperacional',
        );

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,veh.placa_vehiculo, emp.id_empresa, concat(usu.nombre_usuario,' ',usu.apellido_usuario) As nombre_autoriza, usu.cedula_usuario As documento_autoriza, us.id_usuario As conductor_asignado, ";
        $mysql_query .= "hab.nombre_habeas_data, concat(usua.nombre_usuario,' ',usua.apellido_usuario) As nombre_habeas, habpre.fecha_formulario_habeas_preoperacional,habpre.firma_habeas, ";

        $mysql_query .= "pre.tarjeta_propiedad_vigencia,pre.tarjeta_propiedad_fecha,pre.tarjeta_propiedad_entidad,pre.revision_rtm_vigencia,pre.revision_rtm_fecha,pre.revision_rtm_entidad, ";
        $mysql_query .= "pre.certificado_gases_vigencia,pre.certificado_gases_fecha,pre.certificado_gases_entidad,pre.planilla_fuec_vigencia,pre.planilla_fuec_fecha,pre.planilla_fuec_entidad, ";
        $mysql_query .= "pre.licencia_conduccion_vigencia,pre.licencia_conduccion_fecha,pre.licencia_conduccion_entidad,
        pre.foto_tacometro_combustible,pre.foto_tacometro_kilometraje,pre.fecha_formulario, pre.datos_preoperacional, usu.firma_usuario, pre.observaciones_usuario_autoriza,pre.id_preoperacional,veh.id_vehiculo ";

        $mysql_query .= "FROM preoperacional pre ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON pre.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN empresa emp ON pre.id_empresa = emp.id_empresa ";
        $mysql_query .= "LEFT JOIN usuario usu ON pre.id_usuario_autoriza = usu.id_usuario ";
        $mysql_query .= "LEFT JOIN usuario us ON pre.id_usuario_realiza = us.id_usuario ";
        $mysql_query .= "LEFT JOIN habeas_preoperacional habpre ON pre.id_preoperacional = habpre.id_preoperacional ";
        $mysql_query .= "LEFT JOIN usuario usua ON usu.id_usuario = usua.id_usuario ";
        $mysql_query .= "LEFT JOIN habeas_data hab ON habpre.id_habeas_data = hab.id_habeas_data ";

        #Condicion
        $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";

        #Ordenamiento
        $mysql_query .= "ORDER BY pre.id_preoperacional DESC LIMIT " . $_condicional_['LIMITE'] . "; ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($this->array_preoperacional_vehiculo, array(

                    'habeas' => $row['nombre_habeas_data'],
                    'nombre_habeas' => $row['nombre_habeas'],
                    'fecha_habeas' => $row['fecha_formulario_habeas_preoperacional'],
                    'firma_habeas' => $row['firma_habeas'],
                    'placa' => $row['placa_vehiculo'],
                    'nombre_supervisor' => $row['nombre_autoriza'],
                    'documento_supervisor' => $row['documento_autoriza'],
                    'tarjeta_vencimiento' => $row['tarjeta_propiedad_fecha'],
                    'tarjeta_entidad' => $row['tarjeta_propiedad_entidad'],
                    'vencimiento_rtm' => $row['revision_rtm_fecha'],
                    'entidad_rtm' => $row['revision_rtm_entidad'],
                    'vencimiento_gases' => $row['certificado_gases_fecha'],
                    'entidad_gases' => $row['certificado_gases_entidad'],
                    'vencimiento_fuec' => $row['planilla_fuec_fecha'],
                    'entidad_fuec' => $row['planilla_fuec_entidad'],
                    'vencimiento_licencia' => $row['licencia_conduccion_fecha'],
                    'entidad_licencia' => $row['licencia_conduccion_entidad'],
                    'fecha_hora' => $row['fecha_formulario'],
                    'foto_kilometraje' => $row['foto_tacometro_kilometraje'],
                    'foto_combustible' => $row['foto_tacometro_combustible'],
                    'listado' => $row['datos_preoperacional'],
                    'firma_supervisor' => $row['firma_usuario'],
                    'observaciones_supervisor' => $row['observaciones_usuario_autoriza'],
                    'vehiculo' => $row['id_vehiculo'],

                ));
            }

        }
        return $this->array_preoperacional_vehiculo;
    }

}