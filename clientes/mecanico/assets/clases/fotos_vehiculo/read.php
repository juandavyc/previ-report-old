<?php
class FotosVehiculo
{

    public $array_fotos_vehiculos = array();
    public $contador_fotos_vehiculos = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getFotosVehiculo($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, veh.foto_costado_derecho, veh.foto_costado_izquierdo, veh.foto_delantera, veh.foto_trasera, veh.impronta_chasis, veh.impronta_motor, veh.impronta_serial, veh.licencia_transito_delantera, veh.licencia_transito_trasera ";
        
        $mysql_query .= "FROM vehiculo veh ";
      
        $mysql_query .= "WHERE veh.id_vehiculo = ?";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_fotos_vehiculos, array(
                   
                    'costado_derecho' => $row['foto_costado_derecho'],
                    'costado_izquierdo' => $row['foto_costado_izquierdo'],
                    'delantera' => $row['foto_delantera'],
                    'trasera' => $row['foto_trasera'],
                    'chasis' => $row['impronta_chasis'],
                    'motor' => $row['impronta_motor'],
                    'serial' => $row['impronta_serial'],
                    'licencia_delantera' => $row['licencia_transito_delantera'],
                    'licencia_trasera' => $row['licencia_transito_trasera'],
                ));
            }
            
        }
        return $this->array_fotos_vehiculos;
    }

}