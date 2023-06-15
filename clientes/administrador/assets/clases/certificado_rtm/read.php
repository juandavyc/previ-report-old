<?php
class ReadCertificadoRTM
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getCertificadoRTM(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'cer.id_certificado_rtm',
            'ID_VEHICULO' => 'cer.id_vehiculo',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # CERTIFICADO
        $mysqlQuery .= "cer.id_certificado_rtm, ";
        $mysqlQuery .= "cer.numero_rtm,cer.foto_certificado_rtm, ";
        $mysqlQuery .= "cer.fecha_expedicion_rtm,cer.fecha_vencimiento_rtm, ";
        $mysqlQuery .= "cer.fecha_formulario, ";
        # VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        # CDA
        $mysqlQuery .= "cda.id_cda, cda.nombre_cda, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario ";

        $mysqlQuery .= "FROM certificado_rtm cer ";
        $mysqlQuery .= "LEFT JOIN cda ON cer.id_cda = cda.id_cda ";
        $mysqlQuery .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = cer.id_vehiculo ";
        $mysqlQuery .= "LEFT JOIN usuario usu ON usu.id_usuario = cer.id_usuario ";
        $mysqlQuery .= "WHERE " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND cer.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY cer.id_certificado_rtm DESC ";
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
                                "id" => htmlspecialchars($row['id_certificado_rtm']),
                                "numero" => htmlspecialchars($row['numero_rtm']),
                                "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_rtm']),
                                "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_rtm']),
                                "foto" => htmlspecialchars($row['foto_certificado_rtm']),
                                "cda" => array(
                                    "id" => htmlspecialchars($row['id_cda']),
                                    "nombre" => htmlspecialchars($row['nombre_cda']),
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
                        'certificado_rtm' => $mysqlArray,
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