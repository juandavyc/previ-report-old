<?php
class VehiculoConductor
{

    public $array_vehiculo_conductor = array();
    public $contador_vehiculo_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getVehiculoConductor($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, con.id_conductor, veh.placa_vehiculo, veh.numero_vehiculo_interno, vehco.fecha_asignacion ";
        

        $mysql_query .= "FROM vehiculo_conductor vehco ";

        $mysql_query .= "LEFT JOIN conductor con ON vehco.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo ";
       

        $mysql_query .= "WHERE veh.id_vehiculo = ? ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_vehiculo_conductor, array(

                    'placa' => $row['placa_vehiculo'],
                    'numero' => $row['numero_vehiculo_interno'],
                    'fecha' => $row['fecha_asignacion'],      
                
                ));
            }
            
        }
        return $this->array_vehiculo_conductor;
    }

}