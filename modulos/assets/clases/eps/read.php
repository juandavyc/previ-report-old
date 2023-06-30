<?php
class ReadEps
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getEps(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'eps.id_eps',
            'ID_CONDUCTOR' => 'epsc.id_conductor',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        $mysqlQuery .= "epsc.id_eps_conductor , epss.nombre_eps, epsc.fecha_afiliacion_eps , 
        eeps.nombre_estado_eps, epsc.fecha_formulario  ";
        $mysqlQuery .= "FROM eps_conductor epsc ";
        $mysqlQuery .= "LEFT JOIN eps epss ON epss.id_eps = epsc.id_eps ";
        $mysqlQuery .= "LEFT JOIN estado_eps eeps ON eeps.id_estado_eps = epsc.id_estado_eps ";
        $mysqlQuery .= "WHERE  " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND epsc.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY epsc.id_eps_conductor DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";
 
        // var_dump($mysqlQuery);

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            if ($mysqlStmt->execute()) {
                $mysqlResult = $mysqlStmt->get_result();
                if (intval($mysqlResult->num_rows) > 0) {
                    while ($row = $mysqlResult->fetch_assoc()) {
                        array_push(
                            $mysqlArray,
                            array(
                                "id" => htmlspecialchars($row['id_eps_conductor']),
                                "nombre" => htmlspecialchars($row['nombre_eps']),
                                "fecha_afiliacion" => htmlspecialchars($row['fecha_afiliacion_eps']),
                                "estado" => htmlspecialchars($row['nombre_estado_eps']),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'eps' => $mysqlArray,
                    );
                } else {
                    $this->arrayResponse = array(
                        'status' => 'sin_resultados',
                        'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
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
            epsc.id_eps_conductor,
            eps.nombre_eps,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa,
            epsc.fecha_afiliacion_eps
        FROM
            eps_conductor epsc
                LEFT JOIN
            eps ON eps.id_eps = epsc.id_eps
                LEFT JOIN
            conductor cond ON epsc.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            epsc.is_visible = 1
        ORDER BY epsc.id_eps_conductor DESC;';
            
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
                                htmlspecialchars($row['nombre_eps']),
                                setSpecialDate($row['fecha_afiliacion_eps']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_eps_conductor']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'EPS',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "EPS",
                            "Fecha Afiliacion",
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
