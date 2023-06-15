<?php
class DatosVehiculo
{

    public $array_datos_vehiculo = array();
    public $contador_datos_vehiculo = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getDatosVehiculo($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,veh.placa_vehiculo, pai.nombre_pais, ser.nombre_servicio, cla.nombre_clase, mar.nombre_marca, lin.nombre_linea, veh.modelo_vehiculo, veh.cilindraje_vehiculo, ";
        $mysql_query .= "timo.nombre_tiempos_motor, naci.nombre_nacionalidad, tive.nombre_tipo_vehiculo, combus.nombre_combustible, veh.potencia_vehiculo, veh.numero_exostos_vehiculo, ";
        $mysql_query .= "veh.diametro_exostos_vehiculo, tica.nombre_tipo_carroceria, col.nombre_color, veh.blindado_vehiculo, veh.numero_puertas, ticaja.nombre_tipo_caja, veh.numero_serie_vehiculo, ";
        $mysql_query .= "veh.numero_motor_vehiculo, veh.repotenciado, veh.vin_vehiculo, veh.certificado_gncv_vehiculo, veh.fecha_gncv_vehiculo, veh.clasico_antiguo, veh.regrabacion_chasis, ";
        $mysql_query .= "veh.numero_regrabacion_chasis, veh.regrabacion_vin, veh.numero_regrabacion_vin, veh.regrabacion_serie, veh.numero_regrabacion_serie, veh.regrabacion_motor, ";
        $mysql_query .= "veh.numero_regrabacion_motor, veh.fecha_matricula_vehiculo, pozo.numero_poliza_soat, pozo.fecha_expedicion_soat, ";
        $mysql_query .= "pozo.fecha_vencimiento_soat, cd.nombre_cda, certm.numero_rtm, certm.fecha_expedicion_rtm, certm.fecha_vencimiento_rtm, lugpre.nombre_lugar_preventiva, ";
        $mysql_query .= "revpre.numero_revision_preventiva, revpre.fecha_expedicion_preventiva, revpre.fecha_vencimiento_preventiva, aseso.nombre_aseguradora_soat, ";
        $mysql_query .= "emp.nombre_empresa, ciuem.nombre_ciudad, depaem.nombre_departamento, emp.nit, emp.telefono, emp.direccion, emp.correo, ";
        $mysql_query .= "daveh.capacidad_carga, daveh.peso_bruto_vehiculo, daveh.capacidad_pasajeros, daveh.capacidad_pasajeros_sentados, daveh.numero_ejes, tao.numero_tarjeta_operacion, ";
        $mysql_query .= "tao.fecha_expedicion_tarjeta_operacion,tao.fecha_vencimiento_tarjeta_operacion, mota.nombre_modalidad_transporte, mose.nombre_modalidad_servicio, ";
        $mysql_query .="raac.nombre_radio_accion, estao.nombre_estado_tarjeta_operacion, veh.fecha_formulario,  CONCAT (usu.nombre_usuario,'  ', usu.apellido_usuario) as nombre_completo, usu.firma_usuario ";
        

        $mysql_query .= "FROM vehiculo veh ";

        $mysql_query .= "LEFT JOIN  pais pai ON veh.id_pais = pai.id_pais ";
        $mysql_query .= "LEFT JOIN  servicio ser ON veh.id_servicio = ser.id_servicio ";
        $mysql_query .= "LEFT JOIN  clase cla ON veh.id_clase = cla.id_clase ";
        $mysql_query .= "LEFT JOIN  linea lin ON veh.id_linea = lin.id_linea ";
        $mysql_query .= "LEFT JOIN  marca mar ON lin.id_marca = mar.id_marca ";
        $mysql_query .= "LEFT JOIN  tiempos_motor timo ON veh.id_tiempos_motor = timo.id_tiempos_motor ";
        $mysql_query .= "LEFT JOIN  nacionalidad naci ON veh.id_nacionalidad = naci.id_nacionalidad ";
        $mysql_query .= "LEFT JOIN  tipo_vehiculo tive ON veh.id_tipo_vehiculo = tive.id_tipo_vehiculo ";
        $mysql_query .= "LEFT JOIN  combustible combus ON veh.id_combustible = combus.id_combustible ";
        $mysql_query .= "LEFT JOIN  tipo_carroceria tica ON veh.id_tipo_carroceria = tica.id_tipo_carroceria ";
        $mysql_query .= "LEFT JOIN  color col ON veh.id_color = col.id_color ";
        $mysql_query .= "LEFT JOIN  tipo_caja ticaja ON veh.id_tipo_caja = ticaja.id_tipo_caja ";
        $mysql_query .= "LEFT JOIN  poliza_soat pozo ON veh.id_vehiculo = pozo.id_vehiculo ";
        $mysql_query .= "LEFT JOIN  certificado_rtm certm ON veh.id_vehiculo = certm.id_vehiculo ";
        $mysql_query .= "LEFT JOIN  cda cd ON certm.id_cda = cd.id_cda ";
        $mysql_query .= "LEFT JOIN  revision_preventiva revpre ON veh.id_revision_preventiva = revpre.id_revision_preventiva ";
        $mysql_query .= "LEFT JOIN  lugar_preventiva lugpre ON revpre.id_lugar_preventiva = lugpre.id_lugar_preventiva ";
        $mysql_query .= "LEFT JOIN  aseguradora_soat aseso ON pozo.id_aseguradora_soat = aseso.id_aseguradora_soat ";
        $mysql_query .= "LEFT JOIN  tarjeta_operacion tao ON veh.id_vehiculo = tao.id_vehiculo ";
        $mysql_query .= "LEFT JOIN  empresa emp ON tao.id_empresa = emp.id_empresa ";
        $mysql_query .= "LEFT JOIN  ciudad ciuem ON emp.id_ciudad = ciuem.id_ciudad  ";
        $mysql_query .= "LEFT JOIN  departamento depaem ON ciuem.id_departamento = depaem.id_departamento ";
        $mysql_query .= "LEFT JOIN  datos_tecnicos_vehiculo daveh ON veh.id_vehiculo = daveh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN  modalidad_transporte mota ON tao.id_modalidad_transporte = mota.id_modalidad_transporte ";
        $mysql_query .= "LEFT JOIN  modalidad_servicio mose ON tao.id_modalidad_servicio = mose.id_modalidad_servicio ";
        $mysql_query .= "LEFT JOIN  radio_accion raac ON tao.id_radio_accion = raac.id_radio_accion ";
        $mysql_query .= "LEFT JOIN  estado_tarjeta_operacion estao ON tao.id_estado_tarjeta_operacion = estao.id_estado_tarjeta_operacion ";

        $mysql_query .= "LEFT JOIN  usuario usu ON veh.id_usuario = usu.id_usuario ";
      

        
        $mysql_query .= "WHERE veh.id_vehiculo = ?";


        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);



        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_datos_vehiculo, array(

                    'placa' => $row['placa_vehiculo'],
                    'pais' => $row['nombre_pais'],
                    'servicio' => $row['nombre_servicio'],
                    'clase' => $row['nombre_clase'],
                    'marca' => $row['nombre_marca'],
                    'linea' => $row['nombre_linea'],
                    'modelo' => $row['modelo_vehiculo'],
                    'cilindraje' => $row['cilindraje_vehiculo'],
                    'tipo_motor' => $row['nombre_tiempos_motor'],
                    'nacionalidad' => $row['nombre_nacionalidad'],
                    'tipo_vehiculo' => $row['nombre_tipo_vehiculo'],
                    'combustible' => $row['nombre_combustible'],
                    'potencia' => $row['potencia_vehiculo'],
                    'numero_exostos' => $row['numero_exostos_vehiculo'],
                    'diametro_exostos' => $row['diametro_exostos_vehiculo'],
                    'tipo_carroceria' => $row['nombre_tipo_carroceria'],
                    'color' => $row['nombre_color'],
                    'vehiculo_blindado' => $row['blindado_vehiculo'],
                    'puertas' => $row['numero_puertas'],
                    'caja' => $row['nombre_tipo_caja'],
                    'numero_serie' => $row['numero_serie_vehiculo'],
                    'numero_motor' => $row['numero_motor_vehiculo'],
                    'repotenciado' => $row['repotenciado'],
                    'numero_vin' => $row['vin_vehiculo'],
                    'certificado_gas' => $row['certificado_gncv_vehiculo'],
                    'fecha_certificado_gas' => $row['fecha_gncv_vehiculo'],
                    'clasico' => $row['clasico_antiguo'],
                    'regrabacion_chasis' => $row['regrabacion_chasis'],
                    'numero_regrabacion_chasis' => $row['numero_regrabacion_chasis'],
                    'regrabacion_vin' => $row['regrabacion_vin'],
                    'numero_regrabacion_vin' => $row['numero_regrabacion_vin'],
                    'regrabacion_serie' => $row['regrabacion_serie'],
                    'numero_regrabacion_serie' => $row['numero_regrabacion_serie'],
                    'regrabacion_motor' => $row['regrabacion_motor'],
                    'numero_regrabacion_motor' => $row['numero_regrabacion_motor'],
                    'fecha_matricula' => $row['fecha_matricula_vehiculo'],
                    'nombre_soat' => $row['nombre_aseguradora_soat'],
                    'numero_soat' => $row['numero_poliza_soat'],
                    'numero_regrabacion_motor' => $row['numero_regrabacion_motor'],
                    'expedicion_soat' => $row['fecha_expedicion_soat'],
                    'vencimiento_soat' => $row['fecha_vencimiento_soat'],
                    'cda' => $row['nombre_cda'],
                    'numero_rtm' => $row['numero_rtm'],
                    'expedicion_rtm' => $row['fecha_expedicion_rtm'],
                    'vencimiento_rtm' => $row['fecha_vencimiento_rtm'],
                    'preventiva' => $row['nombre_lugar_preventiva'],
                    'numero_preventiva' => $row['numero_revision_preventiva'],
                    'fecha_preventiva' => $row['fecha_expedicion_preventiva'],
                    'vencimiento_preventiva' => $row['fecha_vencimiento_preventiva'],
                    'capacidad_carga' => $row['capacidad_carga'],
                    'peso_vehiculo' => $row['peso_bruto_vehiculo'],
                    'pasajeros' => $row['capacidad_pasajeros'],
                    'pasajeros_sentados' => $row['capacidad_pasajeros_sentados'],
                    'numero_ejes' => $row['numero_ejes'],
                    'empresa_tarjeta_operacion' => $row['nombre_empresa'],
                    'modalidad_transporte' => $row['nombre_modalidad_transporte'],
                    'modalidad_servicio' => $row['nombre_modalidad_servicio'],
                    'radio_accion' => $row['nombre_radio_accion'],
                    'numero_tarjeta_operacion' => $row['numero_tarjeta_operacion'],
                    'estado_tarjeta_operacion' => $row['nombre_estado_tarjeta_operacion'],
                    'expedicion_tarjeta_operacion' => $row['fecha_expedicion_tarjeta_operacion'],
                    'vencimiento_tarjeta_operacion' => $row['fecha_vencimiento_tarjeta_operacion'],
                    'fecha_formulario' => $row['fecha_formulario'],
                    'nombre_usuario' => $row['nombre_completo'],
                    'firma_habeas' => $row['firma_usuario'],
                    'nit' => $row['nit'],
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono'],
                    'correo' => $row['correo'],
                    'ciudad' => $row['nombre_ciudad'],
                    'departamento' => $row['nombre_departamento'],

                ));
}

}
return $this->array_datos_vehiculo;
}

}