<?php
class CapacitacionConductor
{

    public $array_capacitacion_conductor = array();
    public $contador_capacitacion_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getCapacitacionConductor(
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
        $mysql_query .= "veh.id_vehiculo,con.id_conductor, encap.nombre_entidad_capacitacion, ticap.nombre_tipo_capacitacion, cap.nombre_capacitacion, cap.duracion_capacitacion,cap.fecha_realizacion_capacitacion, cap.fecha_refuerzo_capacitacion ";
        

        $mysql_query .= "FROM capacitacion cap ";

        $mysql_query .= "LEFT JOIN conductor con ON cap.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN entidad_capacitacion encap ON cap.id_entidad_capacitacion = encap.id_entidad_capacitacion ";
        $mysql_query .= "LEFT JOIN tipo_capacitacion ticap ON cap.id_tipo_capacitacion = ticap.id_tipo_capacitacion ";
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
                array_push($this->array_capacitacion_conductor, array(

                    'entidad' => $row['nombre_entidad_capacitacion'],
                    'nombre' => $row['nombre_capacitacion'],
                    'tipo' => $row['nombre_tipo_capacitacion'],  
                    'duracion' => $row['duracion_capacitacion'],  
                    'expedicion' => $row['fecha_realizacion_capacitacion'], 
                    'vencimiento' => $row['fecha_refuerzo_capacitacion'],  

                ));
            }
            
        }
        return $this->array_capacitacion_conductor;
    }

}