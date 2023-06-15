<?php
class IncapacidadConductor
{

    public $array_incapacidad_conductor = array();
    public $contador_incapacidad_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getIncapacidadConductor(
        $_condicional_ = array(
            'TYPE' => 'ID_CONDUCTOR',
            'VALUE' => 1,
            
        )
    ) {

        $arrayCondicional = array(
            'ID_VEHICULO' => 'veh.id_vehiculo',
            'ID_CONDUCTOR' => 'con.id_conductor',
        );

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,con.id_conductor, inco.numero_dias_incapacidad_conductor, eps.nombre_eps, arl.nombre_arl, inco.concepto_incapacidad_conductor, inco.numero_dias_incapacidad_conductor,inco.foto_incapacidad_conductor ";
        

        $mysql_query .= "FROM incapacidad_conductor inco ";

        $mysql_query .= "LEFT JOIN conductor con ON inco.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN eps eps ON inco.id_eps = eps.id_eps ";
        $mysql_query .= "LEFT JOIN arl arl ON inco.id_arl = arl.id_arl ";

        $mysql_query .= "LEFT JOIN vehiculo_conductor vehco ON con.id_conductor = vehco.id_conductor ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo ";

          #Condicion
        $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ".";";
        
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_incapacidad_conductor, array(

                    'dias' => $row['numero_dias_incapacidad_conductor'],
                    'concepto' => $row['concepto_incapacidad_conductor'],
                    'eps' => $row['nombre_eps'],  
                    'arl' => $row['nombre_arl'],  
                    'foto' => $row['foto_incapacidad_conductor'], 


                ));
            }
            
        }
        return $this->array_incapacidad_conductor;
    }

}