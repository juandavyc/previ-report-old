<?php
class ReadRevision
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getRevison(
        $_placa,
        $_documento
    ) {


        //$arrayCondicional = $arrayCondicional[];
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla tallesa
        $mysqlQuery .= "rev.id_previautos_pdf,tip.nombre_reviautos_tipo_pdf,tip.id_previautos_tipo_pdf,";
        $mysqlQuery .= "rev.bimensual_previautos_pdf,usu.nombre_usuario,usu.apellido_usuario, ";
        $mysqlQuery .= "rev.fecha_expedicion_previautos_pdf,rev.fecha_vencimiento_previautos_pdf, ";
        $mysqlQuery .= "rev.archivo_previautos_pdf,veh.placa_previautos_vehiculo ";
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "previautos_pdf rev ";
        $mysqlQuery .= "INNER JOIN previautos_tipo_pdf tip ";
        $mysqlQuery .= "ON tip.id_previautos_tipo_pdf = rev.id_previautos_tipo_pdf ";

        $mysqlQuery .= "INNER JOIN usuario usu ";
        $mysqlQuery .= "ON usu.id_usuario = rev.id_usuario ";

        $mysqlQuery .= "INNER JOIN previautos_vehiculo veh ";
        $mysqlQuery .= "ON veh.id_previautos_vehiculo = rev.id_previautos_vehiculo ";

        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "veh.placa_previautos_vehiculo = ? ";
        $mysqlQuery .= "AND ";
        $mysqlQuery .= "veh.documento_previautos_vehiculo = ? ";
        $mysqlQuery .= "AND ";
        $mysqlQuery .= "rev.is_visible = 1 ";
        #Ordenamiento
        $mysqlQuery .= "ORDER BY rev.id_previautos_pdf DESC; ";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('ss', $_placa, $_documento);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            //  "id" => htmlspecialchars($row['id_previautos_pdf']),
                            // "id_tipo" => htmlspecialchars($row['id_previautos_tipo_pdf']),
                            "tipo" => htmlspecialchars($row['nombre_reviautos_tipo_pdf']),
                            "bimensual" => htmlspecialchars($row['bimensual_previautos_pdf']),
                            "ingeniero" => htmlspecialchars($row['nombre_usuario'] . ' ' . $row['apellido_usuario']),
                            "expedicion" => htmlspecialchars($row['fecha_expedicion_previautos_pdf']),
                            "vencimiento" => htmlspecialchars($row['fecha_vencimiento_previautos_pdf']),
                            "archivo" => htmlspecialchars($row['archivo_previautos_pdf']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'revision' => $mysqlArray,
                );
            } else {
                $this->arrayResponse = array(
                    'status' => 'sin_resultados',
                    'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
                );
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta: ' . htmlspecialchars($mysqlStmt->error),
            );
        }

        return $this->arrayResponse;
    }
}