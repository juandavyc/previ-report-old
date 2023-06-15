<?php
class ComparendoConductor
{

    public $array_comparendo_conductor = array();
    public $contador_comparendo_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getComparendoConductor($id_conductor)
         {

       
        $mysql_query = "SELECT ";
        $mysql_query .= "comco.fecha_comparendo_conductor, ticomco.nombre_tipo_comparendo_conductor,  comco.motivo_comparendo_conductor ";



        $mysql_query .= "FROM comparendo_conductor comco ";

        $mysql_query .= "LEFT JOIN tipo_comparendo_conductor ticomco ON comco.id_tipo_comparendo_conductor = ticomco.id_tipo_comparendo_conductor ";
        $mysql_query .= "LEFT JOIN conductor con ON comco.id_conductor = con.id_conductor ";
        

        
         #Condicion
            $mysql_query .= "WHERE con.id_conductor = ? ORDER BY con.id_conductor DESC ";
          
        
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_comparendo_conductor, array(

                    'tipo' => $row['nombre_tipo_comparendo_conductor'],
                    'fecha' => $row['fecha_comparendo_conductor'],
                    'motivo' => $row['motivo_comparendo_conductor'],

                ));

            }

        }
        return $this->array_comparendo_conductor;
    }

}