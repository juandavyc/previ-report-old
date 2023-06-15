<?php
class RepuestoMantenimiento
{

    public $array_repuesto_mantenimiento = array();
    public $contador_repuesto_mantenimiento = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getRepuestoMantenimiento(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'mant.id_mantenimiento',
            'ID_VEHICULO' => 'veh.id_vehiculo',
        );

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, remant.nombre_repuesto, remant.cantidad_repuesto, remant.valor_repuesto ";
      


        $mysql_query .= "FROM mantenimiento mant ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON mant.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN repuesto_mantenimiento remant ON mant.id_mantenimiento = remant.id_mantenimiento ";
    
        $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ".";";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

         $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_repuesto_mantenimiento, array(

                    'nombre_repuesto' => $row['nombre_repuesto'],
                    'cantidad_repuesto' => $row['cantidad_repuesto'],
                    'precio_repuesto' => $row['valor_repuesto'],
                   
                                                
                ));

            }
           
        }
        return $this->array_repuesto_mantenimiento;
    }

}