<?php
class FotosMantenimiento
{

    public $array_repuesto_foto_mantenimiento = array();
    public $contador_repuesto_foto_mantenimiento = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getFotosMantenimiento(
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
        $mysql_query .= "veh.id_vehiculo,cafomant.id_categoria_foto_mantenimiento, cafomant.nombre_categoria_foto_mantenimiento, fomant.foto_mantenimiento, fomant.fecha_formulario, CONCAT(usu.nombre_usuario, ' ', usu.apellido_usuario) AS nombre, fomant.descripcion_foto_mantenimiento ";
        


        $mysql_query .= "FROM mantenimiento mant ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON mant.id_vehiculo = veh.id_vehiculo ";
        
        $mysql_query .= "LEFT JOIN foto_mantenimiento fomant ON mant.id_mantenimiento = fomant.id_mantenimiento ";
        $mysql_query .= "LEFT JOIN categoria_foto_mantenimiento cafomant ON fomant.id_categoria_foto_mantenimiento = cafomant.id_categoria_foto_mantenimiento ";
        $mysql_query .= " LEFT JOIN usuario usu ON mant.id_usuario = usu.id_usuario ";
        
         $mysql_query .= "WHERE ";
        $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ".";";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

         $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_repuesto_foto_mantenimiento, array(

                 'id_categoria' => $row['id_categoria_foto_mantenimiento'],
                 'fotos' => $row['foto_mantenimiento'],
                 'descripcion' => $row['descripcion_foto_mantenimiento'],
                 'usuario' => $row['nombre'],
                 'fecha' => $row['fecha_formulario'],
                 
             ));

            }
            
        }
        return $this->array_repuesto_foto_mantenimiento;
    }

}