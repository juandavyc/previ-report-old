<?php
class CertificadoVehiculo
{

    public $array_certificado_vehiculo = array();
    public $contador_certificado_vehiculo = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getCertificadoVehiculo($id_vehiculo)
    {

        $mysql_query = "SELECT ";
        $mysql_query .= "veh.id_vehiculo, ticer.nombre_tipo_certificado, encer.nombre_entidad_certificado, cer.fecha_expedicion_certificado, cer.fecha_vencimiento_certificado ";

        $mysql_query .= "FROM certificado cer ";

        $mysql_query .= "LEFT JOIN  vehiculo veh ON cer.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN  tipo_certificado ticer ON cer.id_tipo_certificado = ticer.id_tipo_certificado ";
        $mysql_query .= "LEFT JOIN  entidad_certificado encer ON cer.id_entidad_certificado = encer.id_entidad_certificado  ";

        $mysql_query .= "WHERE veh.id_vehiculo = ? ORDER BY cer.id_certificado DESC LIMIT 0,5";

        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($this->array_certificado_vehiculo, array(

                    'tipo_certificado' => $row['nombre_tipo_certificado'],
                    'ente_otorga' => $row['nombre_entidad_certificado'],
                    'fecha_expedicion_certificado' => $row['fecha_expedicion_certificado'],
                    'fecha_vencimiento_certificado' => $row['fecha_vencimiento_certificado'],

                ));
            }

        }
        return $this->array_certificado_vehiculo;
    }

}