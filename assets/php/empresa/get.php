<?php
class ReadEmpresas
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayEmpresas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getEmpresas(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'empr.id_empresa',
            'NIT' => 'empr.nit',
            'NOMBRE' => 'empr.6',
        );

        //$arrayCondicional = $arrayCondicional[];
        $mysqlArrayEmpresa = array();

        $mysqlQuery = "SELECT ";
        #tabla empresa
        $mysqlQuery .= "id_empresa,nombre_empresa,nit ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "empresa ";
        $mysqlQuery .= "WHERE id_estado = 1 ";
        $mysqlQuery .= "ORDER BY nombre_empresa ASC; ";
        
        // var_dump($mysqlQuery);
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);

        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArrayEmpresa,
                        array(
                            "id" => ($row['id_empresa']),
                            "nombre" => htmlspecialchars($row['nombre_empresa']),
                            "nit" => htmlspecialchars($row['nit']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'empresa' => $mysqlArrayEmpresa,
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