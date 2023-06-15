<?php
class CertificadoEmpresaConductor
{

    public $array_certificado_empresa_conductor = array();
    public $contador_certificado_empresa_conductor = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getCertificadoEmpresaConductor($id_empresa)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "emp.id_empresa, ceremp.nombre_certificado_empresa, ceremp.fecha_expedicion_certificado_empresa, ceremp.fecha_vencimiento_certificado_empresa ";
      


        $mysql_query .= "FROM  certificado_empresa ceremp ";

        $mysql_query .= "LEFT JOIN empresa emp ON ceremp.id_empresa = emp.id_empresa ";
        $mysql_query .= "LEFT JOIN entidad_certificado encer ON ceremp.id_entidad_certificado = encer.id_entidad_certificado ";
       
        
        $mysql_query .= "WHERE emp.id_empresa = ? ";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_empresa);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                array_push($this->array_certificado_empresa_conductor, array(

                    'nombre' => $row['nombre_certificado_empresa'],
                    'fecha_expedicion' => $row['fecha_expedicion_certificado_empresa'],
                    'fecha_vencimiento' => $row['fecha_vencimiento_certificado_empresa'],
                              
                ));

            }
           
        }
        return $this->array_certificado_empresa_conductor;
    }

}