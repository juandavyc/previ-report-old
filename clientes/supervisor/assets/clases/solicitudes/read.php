<?php
class SolicitudVehiculo
{

    public $array_solicitud_vehiculo = array();
    public $contador_solicitud_vehiculo = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getSolicitudVehiculo($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,  tisol.nombre_tipo_solicitud, sol.fecha_solicitud, sol.numero_solicitud, enta.nombre_entidad_transito, essol.nombre_estado_solicitud ";
        
        

        $mysql_query .= "FROM solicitud sol ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON sol.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN tipo_solicitud tisol ON sol.id_tipo_solicitud = tisol.id_tipo_solicitud ";
        $mysql_query .= "LEFT JOIN entidad_transito enta ON sol.id_entidad_transito = enta.id_entidad_transito ";
        $mysql_query .= "LEFT JOIN  estado_solicitud essol ON sol.id_estado_solicitud = essol.id_estado_solicitud  ";

        
        $mysql_query .= "WHERE veh.id_vehiculo = ? ORDER BY sol.id_solicitud DESC LIMIT 0,5";


        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);



        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_solicitud_vehiculo, array(

                    'tipo_solicitud' => $row['nombre_tipo_solicitud'],
                    'fecha_solicitud' => $row['fecha_solicitud'],
                    'numero_solicitud' => $row['numero_solicitud'],
                    'entidad_transito_solicitud' => $row['nombre_entidad_transito'],
                    'estado' => $row['nombre_estado_solicitud'],
                    
                ));
}

}
return $this->array_solicitud_vehiculo;
}

}