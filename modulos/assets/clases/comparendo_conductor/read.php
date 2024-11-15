<?php
class ComparendoConductor
{

    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getComparendoConductor($id_conductor)
    {
        $mysqlArray = array();

        $mysql_query = "SELECT ";
        $mysql_query .= "comco.fecha_comparendo_conductor, ticomco.nombre_tipo_comparendo_conductor,  comco.motivo_comparendo_conductor ";
        $mysql_query .= "FROM comparendo_conductor comco ";
        $mysql_query .= "LEFT JOIN tipo_comparendo_conductor ticomco ON comco.id_tipo_comparendo_conductor = ticomco.id_tipo_comparendo_conductor ";
        $mysql_query .= "LEFT JOIN conductor con ON comco.id_conductor = con.id_conductor ";
        #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? ORDER BY con.id_conductor DESC ";
        $mysql_stmt = mysqli_prepare($this->databaseConnection, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push(
                    $mysqlArray,
                    array(
                        'tipo' => $row['nombre_tipo_comparendo_conductor'],
                        'fecha' => $row['fecha_comparendo_conductor'],
                        'motivo' => $row['motivo_comparendo_conductor'],

                    )
                );
            }
        }
        return $mysqlArray;
    }


    public function getDocumentos(
        $_empresa = '%%',
        $_filtro = '%%',
        $_contenido = '%%'
    ) {
        // $arrayCondicional = array(
        //     'ID' => 'arl.id_arl',
        //     'ID_CONDUCTOR' => 'arlc.id_conductor',
        // );
        $mysqlArray = array();

        $mysqlQuery = '
        SELECT 
            comc.id_comparendo_conductor,
            tipc.nombre_tipo_comparendo_conductor,
            comc.fecha_comparendo_conductor,    
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            comparendo_conductor comc
                LEFT JOIN
            tipo_comparendo_conductor tipc ON tipc.id_tipo_comparendo_conductor = comc.id_tipo_comparendo_conductor
                LEFT JOIN
            conductor cond ON comc.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            comc.is_visible = 1
        ORDER BY comc.id_comparendo_conductor DESC;';
            
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        //$mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            if ($mysqlStmt->execute()) {
                $mysqlResult = $mysqlStmt->get_result();
                if (intval($mysqlResult->num_rows) > 0) {
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArray,
                            array(
                                htmlspecialchars($row['nombre_tipo_comparendo_conductor']),
                                setSpecialDate($row['fecha_comparendo_conductor']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_comparendo_conductor']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'comparendo',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Tipo",
                            "Fecha",
                            "Conduc. Documento",
                            "Conduc. Nombre",
                            "Conduc. Apellido", 
                            "Empresa",
                            "Opciones",
                        )
                    );
                } else {
                    $this->arrayResponse = array(
                        'status' => 'sin_resultados',
                        'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo o más tarde',
                    );
                }
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
