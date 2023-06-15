<?php
class DocumentosConductor
{

    public $array_documentos_conductor = array();
    public $contador_documentos_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getDocumentosConductor($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, lico.numero_licencia_conduccion, concat( cali1.nombre_categoria_licencia_conduccion,' ', cali2.nombre_categoria_licencia_conduccion,' ',cali3.nombre_categoria_licencia_conduccion,' ',cali4.nombre_categoria_licencia_conduccion) as categoria,  ";
        $mysql_query .= "lico.fecha_expedicion_licencia_conduccion,lico.fecha_vencimiento_licencia_conduccion, lico.restricciones_del_conductor, lico.foto_delantera_licencia_conduccion, lico.foto_trasera_licencia_conduccion ";


        $mysql_query .= "FROM licencia_conduccion lico ";

        $mysql_query .= "LEFT JOIN estado_licencia esli ON lico.id_estado_licencia = esli.id_estado_licencia ";
        $mysql_query .= "LEFT JOIN conductor con ON lico.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN categoria_licencia_conduccion cali1 ON lico.id_categoria_1 = cali1.id_categoria_licencia_conduccion ";
        $mysql_query .= "LEFT JOIN categoria_licencia_conduccion cali2 ON lico.id_categoria_2 = cali2.id_categoria_licencia_conduccion ";
        $mysql_query .= "LEFT JOIN categoria_licencia_conduccion cali3 ON lico.id_categoria_3 = cali3.id_categoria_licencia_conduccion ";
        $mysql_query .= "LEFT JOIN categoria_licencia_conduccion cali4 ON lico.id_categoria_4 = cali4.id_categoria_licencia_conduccion ";
        
        $mysql_query .= "LEFT JOIN vehiculo_conductor vehco ON con.id_conductor = vehco.id_conductor ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo ";

        
        $mysql_query .= "WHERE veh.id_vehiculo = ? ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_documentos_conductor, array(

                    'numero' => $row['numero_licencia_conduccion'],                  
                    'categorias' => $row['categoria'],
                    'expedicion' => $row['fecha_expedicion_licencia_conduccion'],
                    'vencimiento' => $row['fecha_vencimiento_licencia_conduccion'],
                    'restricciones' => $row['restricciones_del_conductor'],
                    'delantera' => $row['foto_delantera_licencia_conduccion'],
                    'trasera' => $row['foto_trasera_licencia_conduccion'],
                    
                ));

            }
            
        }
        return $this->array_documentos_conductor;
    }

}