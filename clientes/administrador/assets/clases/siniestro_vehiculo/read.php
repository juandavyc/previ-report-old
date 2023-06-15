<?php
class SiniestroVehiculo
{

    public $array_siniestro_vehiculo = array();
    public $contador_siniestro_vehiculo = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getSiniestroVehiculo(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
            'LIMITE' => '0',
            
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'sin.id_siniestro',
            'ID_VEHICULO' => 'veh.id_vehiculo',
        );

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,veh.placa_vehiculo, tisi.nombre_tipo_siniestro, sin.fecha_siniestro, sin.hora_siniestro, dep.nombre_departamento, ciu.nombre_ciudad, sin.heridos_siniestro, ";
        $mysql_query .= "sin.muertos_siniestro, sin.vehiculos_implicados_siniestro, sin.descripcion_siniestro, vehsin.placa_vehiculo_implicado, vehsin.marca_implicado, vehsin.modelo_vehiculo_implicado, ";
        $mysql_query .= "vehsin.conductor_implicado, vehsin.telefono_implicado, vehsin.direccion_implicado, vehsin.correo_implicado, ";
        $mysql_query .= "vehsin.aseguradora_implicado,vehsin.telefono_aseguradora_implicado, vehsin.tipo_poliza_implicado, vehsin.aseguradora_poliza_implicado, ";
        $mysql_query .= "vehsin.fecha_expedicion_poliza_implicado, vehsin.fecha_vencimiento_poliza_implicado, age.nombre_agente_transito, age.telefono_agente_transito, age.correo_agente_transito, ";
        $mysql_query .= "tesi.nombre_testigo_siniestro, tesi.telefono_testigo_siniestro, tesi.direccion_testigo_siniestro, tesi.correo_testigo_siniestro, sin.foto_1_siniestro, ";
        $mysql_query .= "sin.foto_2_siniestro,sin.foto_3_siniestro,sin.foto_4_siniestro, sin.firma_siniestro, sin.direccion_siniestro, hab.firma_habeas, dat.nombre_habeas_data, 
        concat (usu.nombre_usuario, ' ', usu.apellido_usuario) as nombre_completo, hab.fecha_formulario_habeas_siniestro,sin.id_siniestro ";


        $mysql_query .= "FROM siniestro sin ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON sin.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN conductor con ON sin.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN empresa emp ON sin.id_empresa = emp.id_empresa ";
        $mysql_query .= "LEFT JOIN tipo_siniestro tisi ON sin.id_tipo_siniestro = tisi.id_tipo_siniestro ";
        $mysql_query .= "LEFT JOIN ciudad ciu ON sin.id_ciudad = ciu.id_ciudad ";
        $mysql_query .= "LEFT JOIN departamento dep ON ciu.id_departamento = dep.id_departamento ";
        $mysql_query .= "LEFT JOIN vehiculo_implicado_siniestro vehsin ON sin.id_siniestro = vehsin.id_siniestro ";
        $mysql_query .= "LEFT JOIN agente_transito age ON sin.id_siniestro = age.id_siniestro ";
        $mysql_query .= "LEFT JOIN testigo_siniestro tesi ON sin.id_siniestro = tesi.id_siniestro ";
        $mysql_query .= "LEFT JOIN usuario usu ON sin.id_usuario = usu.id_usuario ";
        $mysql_query .= "LEFT JOIN habeas_siniestro hab ON usu.id_usuario = hab.id_usuario ";
        $mysql_query .= "LEFT JOIN habeas_data dat ON hab.id_habeas_data = dat.id_habeas_data ";

               #Condicion
        $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        #Ordenamiento
        $mysql_query .= "ORDER BY veh.id_vehiculo DESC LIMIT " . $_condicional_['LIMITE'] . "; ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);
        $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_siniestro_vehiculo, array(

                    'placa' => $row['placa_vehiculo'],
                    'tipo_siniestro' => $row['nombre_tipo_siniestro'],
                    'fecha' => $row['fecha_siniestro'],
                    'hora' => $row['hora_siniestro'],
                    'departamento' => $row['nombre_departamento'],
                    'ciudad' => $row['nombre_ciudad'],
                    'lugar' => $row['direccion_siniestro'],
                    'heridos' => $row['heridos_siniestro'],
                    'muertos' => $row['muertos_siniestro'],
                    'vehiculo_implicado' => $row['vehiculos_implicados_siniestro'],
                    'nombre_agente' => $row['nombre_agente_transito'],
                    'telefono_agente' => $row['telefono_agente_transito'],
                    'correo_agente' => $row['correo_agente_transito'],
                    'descripcion' => $row['descripcion_siniestro'],
                    'placa_implicado' => $row['placa_vehiculo_implicado'],
                    'marca' => $row['marca_implicado'],
                    'modelo' => $row['modelo_vehiculo_implicado'],
                    'nombre' => $row['conductor_implicado'],
                    'telefono' => $row['telefono_implicado'],
                    'direccion' => $row['direccion_implicado'],
                    'correo' => $row['correo_implicado'],
                    'aseguradora' => $row['aseguradora_implicado'],
                    'telefono_aseguradora' => $row['telefono_aseguradora_implicado'],
                    'tipo_poliza' => $row['tipo_poliza_implicado'],
                    'aseguradora_poliza' => $row['aseguradora_poliza_implicado'],
                    'expedicion_poliza' => $row['fecha_expedicion_poliza_implicado'],
                    'vencimiento_poliza' => $row['fecha_vencimiento_poliza_implicado'],
                    'nombre_testigo' => $row['nombre_testigo_siniestro'],
                    'telefono_testigo' => $row['telefono_testigo_siniestro'],
                    'direccion_testigo' => $row['direccion_testigo_siniestro'],
                    'correo_testigo' => $row['correo_testigo_siniestro'],
                    'foto_1' => $row['foto_1_siniestro'],
                    'foto_2' => $row['foto_2_siniestro'],
                    'foto_3' => $row['foto_3_siniestro'],
                    'foto_4' => $row['foto_4_siniestro'],
                    'firma' => $row['firma_siniestro'],
                    'nombre_completo' => $row['nombre_completo'],
                    'habeas_data' => $row['nombre_habeas_data'],
                    'fecha_hora_habeas' => $row['fecha_formulario_habeas_siniestro'],
                    'firma_habeas' => $row['firma_habeas'],

                ));
            }
            
        }
        return $this->array_siniestro_vehiculo;
    }

}