<?php
class ContratoConductor
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
        $mysqlArray = array();
        $mysqlArray = array();

        $mysqlQuery = '
        SELECT 
            conc.id_contrato_empresa_conductor,
            tcon.nombre_tipo_contrato,
            conc.fecha_ingreso_empresa_conductor,
            conc.fecha_vencimiento_contrato_empresa_conductor,
            cond.numero_documento,
            cond.nombre_conductor,
            cond.apellido_conductor,
            empr.nombre_empresa
        FROM
            contrato_empresa_conductor conc
                LEFT JOIN
            tipo_contrato tcon ON conc.id_tipo_contrato = tcon.id_tipo_contrato
                LEFT JOIN
            conductor cond ON conc.id_conductor = cond.id_conductor
                LEFT JOIN
            empresa empr ON cond.id_empresa = empr.id_empresa
        WHERE
            conc.is_visible = 1
        ORDER BY conc.id_contrato_empresa_conductor DESC;';
            
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
                                htmlspecialchars($row['nombre_tipo_contrato']),
                                setSpecialDate($row['fecha_ingreso_empresa_conductor']),
                                setSpecialDate($row['fecha_vencimiento_contrato_empresa_conductor']),
                                htmlspecialchars($row['numero_documento']),
                                htmlspecialchars($row['nombre_conductor']),
                                htmlspecialchars($row['apellido_conductor']),
                                htmlspecialchars($row['nombre_empresa']),
                                htmlspecialchars($row['id_contrato_empresa_conductor']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'contratos',
                        'results' => $mysqlArray,
                        'head' => array(
                            "Nro",
                            "Tipo",
                            "Fecha Ingreso",
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