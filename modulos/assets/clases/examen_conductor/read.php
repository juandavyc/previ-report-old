<?php
class ExamenConductor
{

    public $array_examen_conductor = array();
    public $contador_examen_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getExamenConductor($id_conductor)
        {

       
        $mysql_query = "SELECT ";
        $mysql_query .= "tiex.nombre_tipo_examen, enex.nombre_entidad_examen, ex.recomendaciones, ex.fecha_expedicion_examen, ex.fecha_vencimiento_examen ";
        

        $mysql_query .= "FROM examen ex ";

        $mysql_query .= "LEFT JOIN conductor con ON ex.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN tipo_examen tiex ON ex.id_tipo_examen = tiex.id_tipo_examen ";
        $mysql_query .= "LEFT JOIN entidad_examen enex ON ex.id_entidad_examen = enex.id_entidad_examen ";
    

        #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? AND ex.is_visible = 1 ";
       
        
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_examen_conductor, array(

                    'entidad' => $row['nombre_entidad_examen'],
                    'tipo_examen' => $row['nombre_tipo_examen'],
                    'recomendacion' => $row['recomendaciones'],     
                    'expedicion' => $row['fecha_expedicion_examen'], 
                    'vencimiento' => $row['fecha_vencimiento_examen'],  

                ));
            }
            
        }
        return $this->array_examen_conductor;
    }

}