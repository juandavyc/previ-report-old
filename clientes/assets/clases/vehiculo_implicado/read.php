<?php
class ReadTestigo
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayEmpresas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getTestigo(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'test.id_agente',
            'ID_SINIESTRO' => 'test.id_siniestro',
        );

        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "test.id_testigo_siniestro,test.nombre_testigo_siniestro,test.telefono_testigo_siniestro, ";
        $mysqlQuery .= "test.correo_testigo_siniestro,test.direccion_testigo_siniestro,test.id_siniestro ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "testigo_siniestro test ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "ORDER BY test.id_testigo_siniestro DESC; ";

        //echo $mysqlQuery;
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);

        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_testigo_siniestro']),
                            "nombre" => htmlspecialchars($row['nombre_testigo_siniestro']),
                            "telefono" => htmlspecialchars($row['telefono_testigo_siniestro']),
                            "correo" => htmlspecialchars($row['correo_testigo_siniestro']),
                            "direccion" => htmlspecialchars($row['direccion_testigo_siniestro']),
                            "id_siniestro" => htmlspecialchars($row['id_siniestro']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'testigo' => $mysqlArray,
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