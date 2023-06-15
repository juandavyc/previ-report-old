<?php
class CursoConductor
{

    public $array_curso_conductor = array();
    public $contador_curso_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getCursoConductor($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, con.id_conductor, encur.nombre_entidad_curso, cur.nombre_curso, cur.logro_obtenido, cur.fecha_realizacion_curso, cur.fecha_expiracion_curso ";
        

        $mysql_query .= "FROM curso cur ";

        $mysql_query .= "LEFT JOIN conductor con ON cur.id_conductor = con.id_conductor  ";
        $mysql_query .= "LEFT JOIN entidad_curso encur ON cur.id_entidad_curso = encur.id_entidad_curso ";

        $mysql_query .= "LEFT JOIN vehiculo_conductor vehco ON con.id_conductor = vehco.id_conductor ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo ";

        
        $mysql_query .= "WHERE veh.id_vehiculo = ? ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_curso_conductor, array(

                    'entidad' => $row['nombre_entidad_curso'],
                    'nombre_curso' => $row['nombre_curso'],
                    'logro' => $row['logro_obtenido'],     
                    'expedicion' => $row['fecha_realizacion_curso'], 
                    'vencimiento' => $row['fecha_expiracion_curso'],  

                ));
            }
            
        }
        return $this->array_curso_conductor;
    }

}