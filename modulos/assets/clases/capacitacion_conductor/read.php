<?php
class CapacitacionConductor
{

    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getCapacitacionConductor($id_conductor)

    {

        $mysqlArray = array();
        $mysql_query = "SELECT ";
        $mysql_query .= "con.id_conductor,encap.nombre_entidad_capacitacion, ticap.nombre_tipo_capacitacion, cap.nombre_capacitacion, cap.duracion_capacitacion,cap.fecha_realizacion_capacitacion, cap.fecha_refuerzo_capacitacion ";
        $mysql_query .= "FROM capacitacion cap ";
        $mysql_query .= "LEFT JOIN conductor con ON cap.id_conductor = con.id_conductor ";
        $mysql_query .= "LEFT JOIN entidad_capacitacion encap ON cap.id_entidad_capacitacion = encap.id_entidad_capacitacion ";
        $mysql_query .= "LEFT JOIN tipo_capacitacion ticap ON cap.id_tipo_capacitacion = ticap.id_tipo_capacitacion ";
        #Condicion
        $mysql_query .= "WHERE con.id_conductor = ? AND cap.is_visible = 1 ";
        $mysql_stmt = mysqli_prepare($this->databaseConnection, $mysql_query);

        $mysql_stmt->bind_param('i', $id_conductor);
        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push(
                    $mysqlArray,
                    array(
                        'entidad' => $row['nombre_entidad_capacitacion'],
                        'nombre' => $row['nombre_capacitacion'],
                        'tipo' => $row['nombre_tipo_capacitacion'],
                        'duracion' => $row['duracion_capacitacion'],
                        'expedicion' => $row['fecha_realizacion_capacitacion'],
                        'vencimiento' => $row['fecha_refuerzo_capacitacion'],

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
            capt.id_capacitacion,
            capt.fecha_realizacion_capacitacion,
            capt.fecha_refuerzo_capacitacion,
            capt.nombre_capacitacion,
            tcap.nombre_tipo_capacitacion,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            capacitacion capt
                LEFT JOIN
            tipo_capacitacion tcap ON capt.id_tipo_capacitacion = tcap.id_tipo_capacitacion
                LEFT JOIN
            conductor cond ON capt.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            capt.is_visible = 1
        ORDER BY capt.id_capacitacion DESC;';
            
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
                                htmlspecialchars($row['nombre_capacitacion']),
                                setSpecialDate($row['fecha_realizacion_capacitacion']),
                                setSpecialDate($row['fecha_refuerzo_capacitacion']),                              
                                htmlspecialchars($row['nombre_tipo_capacitacion']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_capacitacion']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'capacitacion',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Capacitacion",
                            "Fecha Realizacion",
                            "Fecha Refuerzo",                            
                            "Tipo",
                            "Documento",
                            "Nombre",
                            "Apellido",
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
