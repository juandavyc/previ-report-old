<?php
class DatosConductor
{

    public $array_datos_conductor = array();
    public $contador_datos_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getDatosConductor(
        $_condicional_ = array(
            'TYPE' => 'ID_CONDUCTOR',
            'VALUE' => 1,
            'LIMITE' => '0',
            
        )
    ) {

        $arrayCondicional = array(
            'ID_VEHICULO' => 'veh.id_vehiculo',
            'ID_CONDUCTOR' => 'con.id_conductor',
        );

        
        // var_dump($id_vehiculo);

            $mysql_query = "SELECT ";
            $mysql_query .= "con.id_conductor, CONCAT (con.nombre_conductor,'  ',con.apellido_conductor) AS nombre_completo,  CONCAT (tiid.nombre_tipo_identificacion,' - ', con.numero_documento) AS documento, ";
            $mysql_query .= "tisa.nombre_tipo_sangre, con.direccion_conductor, con.telefono_conductor, con.celular_conductor, con.whatsapp_conductor, con.correo_conductor, ciu.nombre_ciudad, depa.nombre_departamento, ";
            $mysql_query .= "con.firma_conductor, con.foto_conductor, conemer.nombre_contacto_de_emergencia_conductor, conemer.telefono_contacto_de_emergencia_conductor, conemer.parentesco_contacto_de_emergencia_conductor, ";
            $mysql_query .= "epscon.fecha_afiliacion_eps, eps.nombre_eps, eseps.nombre_estado_eps, fonco.fecha_afiliacion_fondo_pension, fon.nombre_fondo_pension, esfon.nombre_estado_fondo_pension, arlco.fecha_afiliacion_arl, ";
            $mysql_query .= "arl.nombre_arl, esarl.nombre_estado_arl, arl.nombre_arl, esarl.nombre_estado_arl ";

            $mysql_query .= "FROM conductor con ";

            $mysql_query .= "LEFT JOIN tipo_sangre tisa ON con.id_tipo_sangre = tisa.id_tipo_sangre ";
            $mysql_query .= "LEFT JOIN tipo_identificacion tiid ON con.id_tipo_identificacion = tiid.id_tipo_identificacion ";
            $mysql_query .= "LEFT JOIN ciudad ciu ON con.id_ciudad = ciu.id_ciudad ";
            $mysql_query .= "LEFT JOIN departamento depa ON ciu.id_departamento = depa.id_departamento ";
            $mysql_query .= "LEFT JOIN contacto_de_emergencia_conductor conemer ON con.id_conductor = conemer.id_conductor ";
            $mysql_query .= "LEFT JOIN eps_conductor epscon ON con.id_conductor = epscon.id_conductor ";
            $mysql_query .= "LEFT JOIN eps eps ON epscon.id_eps = eps.id_eps ";
            $mysql_query .= "LEFT JOIN estado_eps eseps ON epscon.id_estado_eps = eseps.id_estado_eps ";
            $mysql_query .= "LEFT JOIN fondo_pension_conductor fonco ON con.id_conductor = fonco.id_conductor ";
            $mysql_query .= "LEFT JOIN fondo_pension fon ON fonco.id_fondo_pension = fon.id_fondo_pension ";
            $mysql_query .= "LEFT JOIN estado_fondo_pension esfon ON fonco.id_estado_fondo_pension = esfon.id_estado_fondo_pension ";
            $mysql_query .= "LEFT JOIN arl_conductor arlco ON con.id_conductor = arlco.id_conductor ";
            $mysql_query .= "LEFT JOIN arl arl ON arlco.id_arl = arl.id_arl ";
            $mysql_query .= "LEFT JOIN estado_arl esarl ON arlco.id_estado_arl = esarl.id_estado_arl ";
            $mysql_query .= "LEFT JOIN vehiculo_conductor conveh ON con.id_conductor = conveh.id_conductor ";
            $mysql_query .= "LEFT JOIN vehiculo veh ON conveh.id_vehiculo = veh.id_vehiculo ";

      #Condicion
            $mysql_query .= "WHERE ";
            $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";

              #Ordenamiento
            $mysql_query .= "ORDER BY con.id_conductor DESC LIMIT " . $_condicional_['LIMITE'] . " ; ";



            $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

            $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

            if ($mysql_stmt->execute()) {
                $result = $mysql_stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    array_push($this->array_datos_conductor, array(
                        'id' => $row['id_conductor'],
                        'nombre' => $row['nombre_completo'],
                        'documento' => $row['documento'],
                        'sangre' => $row['nombre_tipo_sangre'],
                        'direccion' => $row['direccion_conductor'],
                        'telefono' => $row['telefono_conductor'], 
                        'celular' => $row['celular_conductor'],
                        'whatsapp' => $row['whatsapp_conductor'],
                        'correo' => $row['correo_conductor'],
                        'ciudad' => $row['nombre_ciudad'],
                        'departamento' => $row['nombre_departamento'],
                        'emergencia' => $row['nombre_contacto_de_emergencia_conductor'],
                        'telefono_emergencia' => $row['telefono_contacto_de_emergencia_conductor'],
                        'parentesco' => $row['parentesco_contacto_de_emergencia_conductor'],
                        'eps' => $row['nombre_eps'],
                        'fecha_eps' => $row['fecha_afiliacion_eps'],
                        'estado_eps' => $row['nombre_estado_eps'],
                        'fondo' => $row['nombre_fondo_pension'],
                        'fecha_fondo' => $row['fecha_afiliacion_fondo_pension'],
                        'estado_fondo' => $row['nombre_estado_fondo_pension'],
                        'arl' => $row['nombre_arl'],
                        'fecha_arl' => $row['fecha_afiliacion_arl'],
                        'estado_arl' => $row['nombre_estado_arl'],
                        'foto' => $row['foto_conductor'],
                        'firma' => $row['firma_conductor'],


                    ));
                }

            }
            return $this->array_datos_conductor;

        }

    }