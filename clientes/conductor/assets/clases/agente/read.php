<?php
class ReadAgente
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayEmpresas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getAgente(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'agen.id_agente',
            'ID_SINIESTRO' => 'agen.id_siniestro',
        );

        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "agen.id_agente_transito,agen.nombre_agente_transito,agen.telefono_agente_transito, ";
        $mysqlQuery .= "agen.correo_agente_transito,agen.id_siniestro ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "agente_transito agen ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "ORDER BY agen.id_agente_transito DESC; ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);

        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_agente_transito']),
                            "nombre" => htmlspecialchars($row['nombre_agente_transito']),
                            "telefono" => htmlspecialchars($row['telefono_agente_transito']),
                            "correo" => htmlspecialchars($row['correo_agente_transito']),
                            "id_siniestro" => htmlspecialchars($row['id_siniestro']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'agente' => $mysqlArray,
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