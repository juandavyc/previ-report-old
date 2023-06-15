<?php
class ReadDatosVehiculo
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getDatosVehiculo(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'veh.id_vehiculo',
        );
        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        # CERTIFICADO
        $mysqlQuery .= "veh.id_vehiculo,veh.placa_vehiculo, ";
        $mysqlQuery .= "veh.capacidad_carga,veh.peso_bruto_vehicular, ";
        $mysqlQuery .= "veh.capacidad_pasajeros,veh.capacidad_pasajeros_sentados, ";
        $mysqlQuery .= "veh.numero_ejes,veh.fecha_formulario, ";
        # USUARIO
        $mysqlQuery .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario ";

        $mysqlQuery .= "FROM vehiculo veh ";
        $mysqlQuery .= "LEFT JOIN usuario usu ON usu.id_usuario = veh.id_usuario ";
        $mysqlQuery .= "WHERE " . $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "ORDER BY veh.id_vehiculo DESC ";
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
                                "id" => htmlspecialchars($row['id_vehiculo']),
                                "placa" => htmlspecialchars($row['placa_vehiculo']),
                                "capacidad_carga" => htmlspecialchars($row['capacidad_carga']),
                                "peso_bruto" => htmlspecialchars($row['peso_bruto_vehicular']),
                                "capacidad_pasajeros" => htmlspecialchars($row['capacidad_pasajeros']),
                                "capacidad_pasajeros_sentados" => htmlspecialchars($row['capacidad_pasajeros_sentados']),
                                "numero_ejes" => htmlspecialchars($row['numero_ejes']),
                                "usuario" => array(
                                    "id" => htmlspecialchars($row['id_usuario']),
                                    "placa" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                                ),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'datos_tecnicos' => $mysqlArray,
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