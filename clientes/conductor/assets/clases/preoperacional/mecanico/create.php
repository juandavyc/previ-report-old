<?php

class CreatePreoperativo
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setPreoperativo($_json_datos = "", $_id_usuario = 1, $_id_preoperativo = 1,$_resultado = 2,
    $_observaciones_conductor ="",$_firma_supervisor = '/images/sin_firma.png',
    $_foto_1= '/images/sin_imagen.png', $_foto_2 = '/images/sin_imagen.png')
    {

        $mysqlQuery = "CALL proc_crear_preoperativo (?,?,?,?,?,?,?,?,@respuesta); ";
// var_dump($_resultado);
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('siiissss', $_json_datos, $_id_usuario, $_id_preoperativo,
        $_resultado, $_observaciones_conductor, $_firma_supervisor,
        $_foto_1, $_foto_2);

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
                    // 'id' => isset($mysqlDecode[2]) ? $mysqlDecode[2] : '',
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

    public function setFotoMantenimiento($_foto = 1, $_categoria_foto = 1, $descripcion = "", $_id_usuario = 1, $id_mantenimiento = 1)
    {
        $mysqlQuery = "CALL proc_mantenimiento_foto (?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('sisii', $_foto, $_categoria_foto, $descripcion, $_id_usuario, $id_mantenimiento);

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
                    // 'id' => isset($mysqlDecode[2]) ? $mysqlDecode[2] : '',
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


    public function setRepuestoMantenimiento($_nombre = "", $_cantidad = 1, $_valor = "", $_notas = "", $_id_usuario = 1, $id_mantenimiento = 1)
    {
        $mysqlQuery = "CALL proc_mantenimiento_repuesto (?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('sissii', $_nombre, $_cantidad, $_valor,  $_notas, $_id_usuario, $id_mantenimiento);

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
                    // 'id' => isset($mysqlDecode[2]) ? $mysqlDecode[2] : '',
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
