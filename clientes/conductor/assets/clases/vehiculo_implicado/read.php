<?php
class ReadVehiculoImplicado
{
    private $databaseConnection = null;

    private $arrayResponse = array();
    private $arrayEmpresas = array();
    private $arrayContador = 0;

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function getVehiculoImplicado(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        )
    ) {

        $arrayCondicional = array(
            'ID' => 'vehi.id_implicado_siniestro',
            'ID_SINIESTRO' => 'vehi.id_siniestro',
        );

        $mysqlArray = array();

        $mysqlQuery = "SELECT ";
        #tabla vehiculo implicado
        $mysqlQuery .= "vehi.placa_vehiculo_implicado,vehi.marca_implicado,vehi.modelo_vehiculo_implicado, ";
        $mysqlQuery .= "vehi.conductor_implicado,vehi.telefono_implicado,vehi.correo_implicado, ";
        $mysqlQuery .= "vehi.direccion_implicado,vehi.aseguradora_implicado,vehi.telefono_aseguradora_implicado, ";
        $mysqlQuery .= "vehi.tipo_poliza_implicado,vehi.aseguradora_poliza_implicado, ";
        $mysqlQuery .= "vehi.fecha_expedicion_poliza_implicado,vehi.fecha_vencimiento_poliza_implicado,vehi.id_siniestro, ";
        $mysqlQuery .= "vehi.fecha_formulario,vehi.id_implicado_siniestro, ";
        #tabla usuario
        $mysqlQuery .= "usua.id_usuario, usua.nombre_usuario, usua.apellido_usuario  ";
        ## FROM ##
        $mysqlQuery .= "FROM ";
        $mysqlQuery .= "vehiculo_implicado_siniestro vehi ";
        $mysqlQuery .= "INNER JOIN usuario usua ON usua.id_usuario = vehi.id_usuario ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "ORDER BY vehi.id_implicado_siniestro DESC; ";

        //echo $mysqlQuery;
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);

        $mysqlStmt->bind_param('s', $_condicional_['VALUE']);
        if ($mysqlStmt->execute()) {
            $mysqlResult = $mysqlStmt->get_result();
            if (intval($mysqlResult->num_rows) > 0) {
                while ($row = $mysqlResult->fetch_assoc()) {
                    array_push($mysqlArray,
                        array(
                            "id" => htmlspecialchars($row['id_implicado_siniestro']),
                            "placa" => htmlspecialchars($row['placa_vehiculo_implicado']),
                            "marca" => htmlspecialchars($row['marca_implicado']),
                            "modelo" => htmlspecialchars($row['modelo_vehiculo_implicado']),
                            "conductor" => htmlspecialchars($row['conductor_implicado']),
                            "telefono" => htmlspecialchars($row['telefono_implicado']),
                            "correo" => htmlspecialchars($row['correo_implicado']),
                            "direccion" => htmlspecialchars($row['direccion_implicado']),
                            "aseguradora" => htmlspecialchars($row['aseguradora_implicado']),
                            "aseguradora_telefono" => htmlspecialchars($row['telefono_aseguradora_implicado']),
                            "poliza" => htmlspecialchars($row['tipo_poliza_implicado']),
                            "poliza_aseguradora" => htmlspecialchars($row['aseguradora_poliza_implicado']),
                            "fecha_expedicion" => htmlspecialchars($row['fecha_expedicion_poliza_implicado']),
                            "fecha_vencimiento" => htmlspecialchars($row['fecha_vencimiento_poliza_implicado']),
                            "fecha" => htmlspecialchars($row['fecha_formulario']),
                            "id_usuario" => htmlspecialchars($row['id_usuario']),
                            "usuario" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                            "id_siniestro" => htmlspecialchars($row['id_siniestro']),
                        )
                    );
                }
                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'vehiculo' => $mysqlArray,
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