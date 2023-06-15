<?php
class ReadPolizaSoat
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getPolizaSoat(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'soat.id_poliza_soat',
            'ID_VEHICULO' => 'soat.id_vehiculo',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # SOAT
        $mysqlQuery .= "soat.id_poliza_soat,soat.numero_poliza_soat, ";
        $mysqlQuery .= "soat.fecha_expedicion_soat,soat.fecha_vencimiento_soat, ";
        $mysqlQuery .= "soat.foto_poliza_soat,soat.fecha_formulario, ";
        # VEHICULO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        # ASEGURADORA
        $mysqlQuery .= "ase.id_aseguradora_soat, ase.nombre_aseguradora_soat, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario ";

        $mysqlQuery .= "FROM poliza_soat soat ";
        $mysqlQuery .= "LEFT JOIN aseguradora_soat ase ON ase.id_aseguradora_soat = soat.id_aseguradora_soat ";
        $mysqlQuery .= "LEFT JOIN vehiculo veh ON veh.id_vehiculo = soat.id_vehiculo ";
        $mysqlQuery .= "LEFT JOIN usuario usu ON usu.id_usuario = soat.id_usuario ";
        $mysqlQuery .= "WHERE " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND soat.is_visible = 1  ";
        $mysqlQuery .= "ORDER BY soat.id_poliza_soat DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";

        // echo $mysqlQuery;

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {

            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push(
                        $mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_poliza_soat']),
                            "numero" => htmlspecialchars($row['numero_poliza_soat']),
                            "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_soat']),
                            "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_soat']),
                            "foto" => htmlspecialchars($row['foto_poliza_soat']),
                            "aseguradora" => array(
                                "id" => htmlspecialchars($row['id_aseguradora_soat']),
                                "nombre" => htmlspecialchars($row['nombre_aseguradora_soat']),
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
                    'poliza_soat' => $mysqlArray,
                );
            } else {
                $this->arrayResponse = array(
                    'status' => 'sin_resultados',
                    'message' => 'La búsqueda no arrojo ningún resultado, por favor inténtelo de nuevo más tarde',
                );
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