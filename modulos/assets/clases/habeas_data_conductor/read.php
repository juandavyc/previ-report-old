<?php
class HabeasDataConductor
{

    public $array_habeas_data_conductor = array();

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getHabeasDataConductor(
        $_condicional_ = array(
            'TYPE' => 'ID_CONDUCTOR',
            'VALUE' => 1,
            'LIMITE' => '0',
            
        )
    ) {
     
        $arrayCondicional = array(
            'ID_VEHICULO' => 'veh.id_vehiculo',
            'ID_CONDUCTOR' => 'con.id_conductor',

        );

        $mysql_query = "SELECT ";
        $mysql_query .= "con.id_conductor,CONCAT (usu.nombre_usuario,'  ', usu.apellido_usuario) as nombre_completo_habeas,
        habcon.firma_habeas, dat.nombre_habeas_data, habcon.fecha_formulario_habeas_conductor ";
        
        $mysql_query .= "FROM conductor con ";

        $mysql_query .= "LEFT JOIN usuario usu ON con.id_usuario = usu.id_usuario ";
        $mysql_query .= "LEFT JOIN habeas_conductor habcon ON con.id_conductor = habcon.id_conductor ";
        $mysql_query .= "LEFT JOIN habeas_data dat ON habcon.id_habeas_data = dat.id_habeas_data ";
        $mysql_query .= "LEFT JOIN vehiculo_conductor vehco ON con.id_conductor = vehco.id_conductor ";
        $mysql_query .= "LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo ";

         #Condicion
        $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";


         #Ordenamiento
        $mysql_query .= "ORDER BY habcon.id_habeas_conductor DESC LIMIT " . $_condicional_['LIMITE'] . "; ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_habeas_data_conductor, array(

                    'nombre_habeas' => $row['nombre_completo_habeas'],
                    'firma_habeas' => $row['firma_habeas'],
                    'habeas_data' => $row['nombre_habeas_data'],
                    'fecha_habeas' => $row['fecha_formulario_habeas_conductor'],
                    
                ));
            }
            
        }
        return $this->array_habeas_data_conductor;
    }

}