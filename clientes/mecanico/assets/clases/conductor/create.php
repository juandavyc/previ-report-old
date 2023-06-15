<?php

class CreateConductor
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setConductor($_datos_ = array(
        "NOMBRE" => '',
        "APELLIDO" => '',
        "TIPO_DOCUMENTO" => 3,
        "TIPO_SANGRE" => 1,
        "DIRECCION" => '',
        "TELEFONO" => '',
        "CELULAR" => '',
        "WHATSAPP" => '',
        "CORREO" => '',
        "CIUDAD" => 0,
        "DEPARTAMENTO" => 0,
        "FIRMA" => '/images/sin_firma.png',
        "FOTO" => '/images/sin_imagen.png',
        "EMPRESA" => 1,
        "USUARIO" => 1,
        "ID" => 1,
    )) {

        $mysqlQuery = "CALL proc_conductor_informacion_basica (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ssiisssssiisssi',
            $_datos_["NOMBRE"],
            $_datos_["APELLIDO"],
            $_datos_["TIPO_DOCUMENTO"],
            $_datos_["TIPO_SANGRE"],
            $_datos_["DIRECCION"],
            $_datos_["TELEFONO"],
            $_datos_["CELULAR"],
            $_datos_["WHATSAPP"],
            $_datos_["CORREO"],
            $_datos_["CIUDAD"],
            $_datos_["DEPARTAMENTO"],
            $_datos_["ID"],
            $_datos_["FIRMA"],
            $_datos_["FOTO"],
            $_datos_["EMPRESA"],
        );

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
                    'id' => isset($mysqlDecode[2]) ? $mysqlDecode[2] : '',
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