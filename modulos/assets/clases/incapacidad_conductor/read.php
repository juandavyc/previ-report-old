<?php
class IncapacidadConductor
{

    public $array_incapacidad_conductor = array();
    public $contador_incapacidad_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getIncapacidadConductor($id_conductor)
        {


        $mysql_query = "SELECT ";
        $mysql_query .= "inco.numero_dias_incapacidad_conductor, eps.nombre_eps, arl.nombre_arl, inco.concepto_incapacidad_conductor, inco.numero_dias_incapacidad_conductor,inco.foto_incapacidad_conductor ";
        

        $mysql_query .= "FROM incapacidad_conductor inco ";

        $mysql_query .= "LEFT JOIN conductor con ON inco.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN eps eps ON inco.id_eps = eps.id_eps ";
        $mysql_query .= "LEFT JOIN arl arl ON inco.id_arl = arl.id_arl ";


          #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? AND inco.is_visible = 1 ";
     
        
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);

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