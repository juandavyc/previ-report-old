<?php
class ReadArl
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getArl(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'arl.id_arl',
            'ID_CONDUCTOR' => 'arlc.id_conductor',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        $mysqlQuery .= "arlc.id_arl_conductor , arll.nombre_arl, arlc.fecha_afiliacion_arl , 
        earl.nombre_estado_arl, arlc.fecha_formulario  ";
        $mysqlQuery .= "FROM arl_conductor arlc ";
        $mysqlQuery .= "LEFT JOIN arl arll ON arll.id_arl = arlc.id_arl ";
        $mysqlQuery .= "LEFT JOIN estado_arl earl ON earl.id_estado_arl = arlc.id_estado_arl ";
        $mysqlQuery .= "WHERE  " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND arlc.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY arlc.id_arl_conductor DESC ";
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
                                "id" => htmlspecialchars($row['id_arl_conductor']),
                                "nombre" => htmlspecialchars($row['nombre_arl']),
                                "fecha_afiliacion" => htmlspecialchars($row['fecha_afiliacion_arl']),
                                "estado" => htmlspecialchars($row['nombre_estado_arl']),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'arl' => $mysqlArray,
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
        $arrayCondicional = array(
            'ID' => 'arl.id_arl',
            'ID_CONDUCTOR' => 'arlc.id_conductor',
        );
        $mysqlArray = array();

        $mysqlQuery = '
        SELECT 
            arlc.id_arl_conductor,
            arll.nombre_arl,
            arlc.fecha_afiliacion_arl,
            earl.nombre_estado_arl,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            arl_conductor arlc
                LEFT JOIN
            arl arll ON arll.id_arl = arlc.id_arl
                LEFT JOIN
            conductor cond ON arlc.id_conductor = cond.id_conductor
                LEFT JOIN
            estado_arl earl ON earl.id_estado_arl = arlc.id_estado_arl
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            arlc.is_visible = 1
        ORDER BY arlc.id_arl_conductor DESC';

       
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
                                setSpecialDate($row['fecha_afiliacion_arl']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_estado_arl']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_arl_conductor']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Arl',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Arl",
                            "Fecha Afiliacion",
                            "Documento",
                            "Nombre",
                            "Apellido",
                            "Estado",
                            "Empresa",
                            "Opciones",
                        )
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
}
