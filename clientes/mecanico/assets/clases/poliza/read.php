<?php
class Poliza
{

    public $array_poliza = array();
    public $contador_poliza = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getPolizaVehiculo($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, tipolz.nombre_tipo_poliza, asepolz.nombre_aseguradora_poliza, ";
        $mysql_query .= "polz.fecha_expedicion_poliza, polz.fecha_vencimiento_polzia, polz.id_tipo_poliza ";
        $mysql_query .= "FROM poliza polz ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON polz.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN tipo_poliza tipolz ON polz.id_tipo_poliza = tipolz.id_tipo_poliza ";
        $mysql_query .= "LEFT JOIN aseguradora_poliza asepolz ON polz.id_aseguradora_poliza = asepolz.id_aseguradora_poliza ";
        $mysql_query .= "WHERE veh.id_vehiculo = ? ORDER BY polz.id_poliza DESC LIMIT 0,5";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_poliza, array(
                   
                    'vehiculo' => $row['id_vehiculo'],
                    'nombre_poliza' => $row['nombre_tipo_poliza'],
                    'aseguradora_poliza' => $row['nombre_aseguradora_poliza'],
                    'expedicion_poliza' => $row['fecha_expedicion_poliza'],
                    'vencimiento_polzia' => $row['fecha_vencimiento_polzia'],
                ));
            }
            
        }
        return $this->array_poliza;
    }

}