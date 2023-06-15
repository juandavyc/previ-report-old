<?php
class Poliza
{

    public $array_poliza = array();
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->conn = $_database;
    }
    public function getPolizaVehiculo($id_vehiculo = 1, $_condicional = 1, $_limite_ = '0,1')
    {
        $arrayCondicional = array(
            0 => 'polz.id_poliza',
            1 => 'polz.id_vehiculo',
        );

        $mysqlArray = array();

        $mysql_query = "SELECT ";

        $mysql_query .= "polz.id_poliza,polz.fecha_formulario,polz.numero_poliza, ";
        $mysql_query .= "polz.fecha_expedicion_poliza, polz.fecha_vencimiento_polzia, polz.id_tipo_poliza, ";
        $mysql_query .= "polz.foto_poliza, ";
        # USUARIO
        $mysql_query .= "usu.id_usuario, usu.nombre_usuario, usu.apellido_usuario, ";
        # ASEGURADORA
        $mysql_query .= "asepolz.id_aseguradora_poliza, asepolz.nombre_aseguradora_poliza, ";
        # TIPO
        $mysql_query .= "tipolz.id_tipo_poliza, tipolz.nombre_tipo_poliza, ";
        # VEHICULO
        $mysql_query .= "veh.id_vehiculo,veh.placa_vehiculo ";

        $mysql_query .= "FROM poliza polz ";

        $mysql_query .= "LEFT JOIN vehiculo veh ON polz.id_vehiculo = veh.id_vehiculo ";
        $mysql_query .= "LEFT JOIN tipo_poliza tipolz ON polz.id_tipo_poliza = tipolz.id_tipo_poliza ";
        $mysql_query .= "LEFT JOIN aseguradora_poliza asepolz ON polz.id_aseguradora_poliza = asepolz.id_aseguradora_poliza ";
        $mysql_query .= "LEFT JOIN usuario usu ON usu.id_usuario = polz.id_usuario ";
        $mysql_query .= "WHERE " . $arrayCondicional[$_condicional] . " LIKE ? ";
        $mysql_query .= "AND polz.is_visible = 1 ";
        $mysql_query .= "ORDER BY polz.id_poliza DESC ";
        $mysql_query .= "LIMIT " . $_limite_ . ";";

        // echo $mysql_query;
        $mysql_stmt = mysqli_prepare($this->conn, $mysql_query);

        $mysql_stmt->bind_param('i', $id_vehiculo);

        if ($mysql_stmt->execute()) {
            $result = $mysql_stmt->get_result();
            if (intval($result->num_rows) > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($mysqlArray, array(
                        'id' => htmlspecialchars($row['id_poliza']),
                        'numero' => htmlspecialchars($row['numero_poliza']),
                        'expedicion_poliza' => htmlspecialchars($row['fecha_expedicion_poliza']),
                        'vencimiento_polzia' => htmlspecialchars($row['fecha_vencimiento_polzia']),
                        'foto' => htmlspecialchars($row['foto_poliza']),
                        "tipo" => array(
                            "id" => htmlspecialchars($row['id_tipo_poliza']),
                            "nombre" => htmlspecialchars($row['nombre_tipo_poliza']),
                        ),
                        "aseguradora" => array(
                            "id" => htmlspecialchars($row['id_aseguradora_poliza']),
                            "nombre" => htmlspecialchars($row['nombre_aseguradora_poliza']),
                        ),
                        "usuario" => array(
                            "id" => htmlspecialchars($row['id_usuario']),
                            "nombre" => htmlspecialchars($row['nombre_usuario'] . " " . $row['apellido_usuario']),
                        ),
                        "vehiculo" => array(
                            "id" => htmlspecialchars($row['id_vehiculo']),
                            "placa" => htmlspecialchars($row['placa_vehiculo']),
                        ),
                        'fecha' => $row['fecha_formulario'],
                    ));
                }

                $this->arrayResponse = array(
                    'status' => 'bien',
                    'message' => 'Resultados encontrados',
                    'poliza' => $mysqlArray,
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