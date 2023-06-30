<?php
class IncapacidadConductor
{
    
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }

    public function getIncapacidadConductor($id_conductor)
    {


        $mysql_query = "SELECT ";
        $mysql_query .= "inco.numero_dias_incapacidad_conductor, eps.nombre_eps, arl.nombre_arl, inco.concepto_incapacidad_conductor, inco.numero_dias_incapacidad_conductor,inco.foto_incapacidad_conductor ";
        $mysql_query .= "FROM incapacidad_conductor inco ";
        $mysql_query .= "LEFT JOIN conductor con ON inco.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN eps eps ON inco.id_eps = eps.id_eps ";
        $mysql_query .= "LEFT JOIN arl arl ON inco.id_arl = arl.id_arl ";

        #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? AND inco.is_visible = 1 ";
        $mysql_stmt = mysqli_prepare($this->databaseConnection, $mysql_query);
        $mysql_stmt->bind_param('i', $id_conductor);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($this->arrayResponse, array(
                    'dias' => $row['numero_dias_incapacidad_conductor'],
                    'concepto' => $row['concepto_incapacidad_conductor'],
                    'eps' => $row['nombre_eps'],
                    'arl' => $row['nombre_arl'],
                    'foto' => $row['foto_incapacidad_conductor'],
                ));
            }
        }
        return $this->arrayResponse;
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
            incc.id_incapacidad_conductor,
            incc.fecha_inicio_incapacidad,
            incc.fecha_fin_incapacidad,
            arl.nombre_arl,
            eps.nombre_eps,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            incapacidad_conductor incc
                LEFT JOIN
            conductor cond ON incc.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
            LEFT JOIN
            arl ON arl.id_arl = incc.id_arl
            LEFT JOIN
            eps ON eps.id_eps = incc.id_eps
        WHERE
            incc.is_visible = 1
        ORDER BY incc.id_incapacidad_conductor DESC;';
            
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
                                htmlspecialchars($row['nombre_arl']),
                                htmlspecialchars($row['nombre_eps']),
                                setSpecialDate($row['fecha_inicio_incapacidad']),
                                setSpecialDate($row['fecha_fin_incapacidad']),                               
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_incapacidad_conductor']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Incapacidad',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro", 
                            "Arl",
                            "Eps",
                            "Fecha Inicio",
                            "Fecha Final",                            
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
