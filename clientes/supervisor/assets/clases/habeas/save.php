<?php

class Habeas 
{

    private $databaseConnection = null;
    private $arrrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function saveHabeas(
        $_firma_habeas = '/images/sin_firma.png',
        $_id_usuario = 1,
        $_id_elemento = 1,
        $_id_task = 1,
        $_path = 'sin_url'

    ) {
        $mysqlQuery = "CALL proc_save_firma_habeas (?,?,?,?,?,@respuesta); ";
        $_id_elemento_de = 0;

        if ($_id_task >= 1 && $_id_task <= 5) {
            $_id_elemento_de = encrypt($_id_elemento, 2);
        } else {
            $_id_elemento_de = $_id_elemento;
        }

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('siiis', $_firma_habeas, $_id_usuario, $_id_elemento_de, $_id_task, $_path);

        if ($mysqlStmt->execute()) {

            $mysqlStmt->close();

            $mysqlQuery = "SELECT @respuesta As JSON_PROC; ";
            $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
            if ($mysqlStmt->execute()) {

                $mysqlResult = $mysqlStmt->get_result();
                $row = $mysqlResult->fetch_assoc();
                $mysqlDecode = json_decode($row['JSON_PROC']);

                $mysqlStmt->close();

                $this->arrayResponse = array(
                    'status' => $mysqlDecode[0],
                    'message' => $mysqlDecode[1],
                );

            } else {
                $this->arrayResponse = array(
                    'status' => 'error',
                    'message' => 'Error en la consulta #2 : ' . htmlspecialchars($mysqlStmt->error),
                );
            }
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta #1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }

}