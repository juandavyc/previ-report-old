<?php
class ExamenConductor
{

    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getExamenConductor($id_conductor)
    {

        $mysqlArray = array();
        $mysql_query = "SELECT ";
        $mysql_query .= "tiex.nombre_tipo_examen, enex.nombre_entidad_examen, ex.recomendaciones, ex.fecha_expedicion_examen, ex.fecha_vencimiento_examen ";


        $mysql_query .= "FROM examen ex ";

        $mysql_query .= "LEFT JOIN conductor con ON ex.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN tipo_examen tiex ON ex.id_tipo_examen = tiex.id_tipo_examen ";
        $mysql_query .= "LEFT JOIN entidad_examen enex ON ex.id_entidad_examen = enex.id_entidad_examen ";


        #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? AND ex.is_visible = 1 ";


        $mysql_stmt = mysqli_prepare($this->databaseConnection, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($mysqlArray, array(

                    'entidad' => $row['nombre_entidad_examen'],
                    'tipo_examen' => $row['nombre_tipo_examen'],
                    'recomendacion' => $row['recomendaciones'],
                    'expedicion' => $row['fecha_expedicion_examen'],
                    'vencimiento' => $row['fecha_vencimiento_examen'],

                ));
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
            exam.id_examen,
            tipe.nombre_tipo_examen,
            exam.fecha_expedicion_examen,
            exam.fecha_vencimiento_examen,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            examen exam
                LEFT JOIN
            tipo_examen tipe ON tipe.id_tipo_examen = exam.id_tipo_examen
                LEFT JOIN
            conductor cond ON exam.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            exam.is_visible = 1
        ORDER BY exam.id_examen DESC;';
            
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
                                htmlspecialchars($row['nombre_tipo_examen']),
                                setSpecialDate($row['fecha_expedicion_examen']),
                                setSpecialDate($row['fecha_vencimiento_examen']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_examen']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Examenes',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Tipo",
                            "Fecha Afiliacion",
                            "Fecha Vencimiento",
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
