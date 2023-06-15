<?php
class ReadContactoEmergencia
{
    private $databaseConnection = null;
    private $arrayResponse = array();
    private $arrayContador = 0;

    public function __construct($_database)
    {
        $this->databaseConnection = $_database;
    }
    public function getContacto(
        $_condicional_ = array(
            'TYPE' => 'ID',
            'VALUE' => 1,
        ),
        $_limite_ = '0,1'
    ) {
        $arrayCondicional = array(
            'ID' => 'id_contacto_de_emergencia_conductor',
            'ID_CONDUCTOR' => 'id_conductor',
        );
        $mysqlArray = array();



        $mysqlQuery = "SELECT ";
        $mysqlQuery .= "id_contacto_de_emergencia_conductor , nombre_contacto_de_emergencia_conductor, telefono_contacto_de_emergencia_conductor , 
        parentesco_contacto_de_emergencia_conductor , fecha_formulario ";
        $mysqlQuery .= "FROM contacto_de_emergencia_conductor ";
        $mysqlQuery .= "WHERE  ". $arrayCondicional[$_condicional_['TYPE']] . " LIKE ? ";
        $mysqlQuery .= "AND is_visible = 1  ";
        $mysqlQuery .= "ORDER BY id_contacto_de_emergencia_conductor DESC ";
        $mysqlQuery .= "LIMIT " . $_limite_ . ";";

        // var_dump($mysqlQuery);

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
                                "id" => htmlspecialchars($row['id_contacto_de_emergencia_conductor']),
                                "nombre" => htmlspecialchars($row['nombre_contacto_de_emergencia_conductor']),
                                "telefono" => htmlspecialchars($row['telefono_contacto_de_emergencia_conductor']),
                                "parentesco" => htmlspecialchars($row['parentesco_contacto_de_emergencia_conductor']),
                                "fecha" => htmlspecialchars($row['fecha_formulario']),
                            )
                        );
                    }

                    $this->arrayResponse = array(
                        'status' => 'bien',
                        'message' => 'Resultados encontrados',
                        'contacto_emergencia' => $mysqlArray,
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