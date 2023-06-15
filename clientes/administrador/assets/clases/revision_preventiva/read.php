<?php
class ReadRevisionPreventiva
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getRevisionPreventiva(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'previ.id_revision_preventiva',
            'ID_VEHICULO' => 'previ.id_vehiculo',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # CERTIFICADO
        $mysqlQuery .= "previ.id_revision_preventiva, ";
        $mysqlQuery .= "previ.numero_revision_preventiva,previ.foto_certificado_preventiva, ";
        $mysqlQuery .= "previ.fecha_expedicion_preventiva,previ.fecha_vencimiento_preventiva, ";
        $mysqlQuery .= "previ.fecha_formulario, ";
        # VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        # LUGAR
        $mysqlQuery .= "luga.id_lugar_preventiva, luga.nombre_lugar_preventiva, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario ";

        $mysqlQuery .= "FROM revision_preventiva previ ";
        $mysqlQuery .= "LEFT JOIN lugar_preventiva luga ON previ.id_lugar_preventiva = luga.id_lugar_preventiva ";
        $mysqlQuery .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = previ.id_vehiculo ";
        $mysqlQuery .= "LEFT JOIN usuario usu ON usu.id_usuario = previ.id_usuario ";
        $mysqlQuery .= "WHERE " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND previ.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY previ.id_revision_preventiva DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";

        // echo $mysqlQuery;

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
                                "id" => htmlspecialchars($row['id_revision_preventiva']),
                                "numero" => htmlspecialchars($row['numero_revision_preventiva']),
                                "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_preventiva']),
                                "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_preventiva']),
                                "foto" => htmlspecialchars($row['foto_certificado_preventiva']),
                                "lugar" => array(
                                    "id" => htmlspecialchars($row['id_lugar_preventiva']),
                                    "nombre" => htmlspecialchars($row['nombre_lugar_preventiva']),
                                ),
                                "usuario" => array(
                                    "id" => htmlspecialchars($row['id_usuario']),
                                    "nombre" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                                ),
                                "vehiculo" => array(
                                    "id" => htmlspecialchars($row['id_vehiculo']),
                                    "placa" => htmlspecialchars($row['placa_vehiculo']),
                                ),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'preventiva' => $mysqlArray,
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