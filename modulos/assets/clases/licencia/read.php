<?php
class LicenciaConductor
{

    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
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
            licc.id_licencia_conduccion,
            licc.numero_licencia_conduccion,
            licc.fecha_expedicion_licencia_conduccion,
            licc.fecha_vencimiento_licencia_conduccion,
            cat1.nombre_categoria_licencia_conduccion AS licencia_1,
            cat2.nombre_categoria_licencia_conduccion AS licencia_2,
            cat3.nombre_categoria_licencia_conduccion AS licencia_3,
            cat4.nombre_categoria_licencia_conduccion AS licencia_4,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            licencia_conduccion licc
                LEFT JOIN
            categoria_licencia_conduccion cat1 ON cat1.id_categoria_licencia_conduccion = licc.id_categoria_1
                LEFT JOIN
            categoria_licencia_conduccion cat2 ON cat2.id_categoria_licencia_conduccion = licc.id_categoria_2
                LEFT JOIN
            categoria_licencia_conduccion cat3 ON cat3.id_categoria_licencia_conduccion = licc.id_categoria_3
                LEFT JOIN
            categoria_licencia_conduccion cat4 ON cat4.id_categoria_licencia_conduccion = licc.id_categoria_4
                LEFT JOIN
            conductor cond ON licc.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            licc.is_visible = 1
        ORDER BY licc.id_licencia_conduccion DESC;';

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
                                htmlspecialchars($row['numero_licencia_conduccion']),
                                setSpecialDate($row['fecha_expedicion_licencia_conduccion']),
                                setSpecialDate($row['fecha_vencimiento_licencia_conduccion']),
                                htmlspecialchars($row['licencia_1'] == "SIN CATEGORIA" ? '-' : $row['licencia_1']),
                                htmlspecialchars($row['licencia_2'] == "SIN CATEGORIA" ? '-' : $row['licencia_2']),
                                htmlspecialchars($row['licencia_3'] == "SIN CATEGORIA" ? '-' : $row['licencia_3']),
                                htmlspecialchars($row['licencia_4'] == "SIN CATEGORIA" ? '-' : $row['licencia_4']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_licencia_conduccion']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Licencia',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Numero",
                            "Fecha Expedición",
                            "Fecha Vencimiento",
                            "CAT 1",
                            "CAT 2",
                            "CAT 3",
                            "CAT 4",
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
