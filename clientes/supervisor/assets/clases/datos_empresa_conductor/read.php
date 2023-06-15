<?php
class DatosEmpresaConductor
{

    public $array_datos_empresa_conductor = array();
    public $contador_datos_empresa_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getDatosEmpresaConductor(
        $_condicional_ = array(
            'TYPE' => 'ID_CONDUCTOR',
            'VALUE' => 1,
            
        )
    ) {

        $arrayCondicional = array(
            'ID_VEHICULO' => 'veh.id_vehiculo',
            'ID_CONDUCTOR' => 'con.id_conductor',
        );
        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo,emp.nombre_empresa, emp.nit, emp.correo, emp.telefono, emp.direccion, ciu.nombre_ciudad, dep.nombre_departamento, conco.tiempo_en_empresa_conductor, ";
        $mysql_query .= "conco.fecha_ingreso_empresa_conductor, tico.nombre_tipo_contrato, conco.fecha_vencimiento_contrato_empresa_conductor, emp.id_empresa ";


        $mysql_query .= "FROM contrato_empresa_conductor conco ";

        $mysql_query .= "LEFT JOIN conductor con ON conco.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN empresa emp ON conco.id_empresa = emp.id_empresa ";
        $mysql_query .= "LEFT JOIN ciudad ciu ON emp.id_ciudad = ciu.id_ciudad ";
        $mysql_query .= "LEFT JOIN departamento dep ON ciu.id_departamento = dep.id_departamento ";
        $mysql_query .= "LEFT JOIN tipo_contrato tico ON conco.id_tipo_contrato = tico.id_tipo_contrato ";
        $mysql_query .= "LEFT JOIN vehiculo_conductor vehco ON con.id_conductor = vehco.id_conductor ";
        $mysql_query .= " LEFT JOIN vehiculo veh ON vehco.id_vehiculo = veh.id_vehiculo  ";
        
         #Condicion
            $mysql_query .= "WHERE ";
            $mysql_query .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? "."; ";
        
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('s', $_condicional_['VALUE']);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_datos_empresa_conductor, array(

                    'empresa' => $row['nombre_empresa'],
                    'nit_empresa' => $row['nit'],
                    'correo_empresa' => $row['correo'],
                    'telefono_empresa' => $row['telefono'],
                    'direccion_empresa' => $row['direccion'],
                    'ciudad_empresa' => $row['nombre_ciudad'],
                    'departamento_empresa' => $row['nombre_departamento'],
                    'tiempo_en_empresa' => $row['tiempo_en_empresa_conductor'],
                    'ingreso_empresa' => $row['fecha_ingreso_empresa_conductor'],
                    'tipo_contrato' => $row['nombre_tipo_contrato'],
                    'vencimiento_empresa' => $row['fecha_vencimiento_contrato_empresa_conductor'],   
                    'empresa_id' => $row['id_empresa'],           
                ));

            }

        }
        return $this->array_datos_empresa_conductor;
    }

}