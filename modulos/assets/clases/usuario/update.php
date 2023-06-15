<?php

class UpdateUsuario
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }
    public function setRestablecer(
        $_razon = 1,
        $_usuario = 0
    ) {
        $mysqlQuery = "CALL proc_restablecer_contrasenia (?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('ii', $_usuario, $_razon);

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

    public function setEstado(
        $_estado = 1,
        $_usuario = 0
    ) {
        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "usuario ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "id_estado = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_usuario = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ii',
            $_estado,
            $_usuario,
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Estado del usuario actualizado',
            );
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }


    public function setContrasenia(
        $_antigua = 1,
        $_nueva = 1,
        $_usuario = 0
    ) {
        $mysqlQuery = "CALL proc_cambiar_contrasenia (?,?,?,@respuesta); ";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param('iss', $_usuario, $_antigua, $_nueva);

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





    public function setDatosInformacion(
        $_datos_ = array(
            'ID' => 0,
            'NOMBRE' => '',
            'APELLIDO' => '',
            'TELEFONO' => '',
            'CORREO' => 'sin_correo@sin_correo.com',
            'FECHA_NACIMIENTO' => '2999-01-01',
        )
    ) {

        $mysqlQuery = "UPDATE ";
        $mysqlQuery .= "usuario ";
        $mysqlQuery .= "SET ";
        $mysqlQuery .= "nombre_usuario = ?,apellido_usuario = ?, ";
        $mysqlQuery .= "telefono_usuario = ?,correo_usuario = ?,  ";
        $mysqlQuery .= "fecha_nacimiento_usuario = ? ";
        $mysqlQuery .= "WHERE ";
        $mysqlQuery .= "id_usuario = ?;";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'sssssi',
            $_datos_['NOMBRE'],
            $_datos_['APELLIDO'],
            $_datos_['TELEFONO'],
            $_datos_['CORREO'],
            $_datos_['FECHA_NACIMIENTO'],
            $_datos_['ID']
        );

        if ($mysqlStmt->execute()) {
            $mysqlStmt->close();
            $this->arrayResponse = array(
                'status' => 'bien',
                'message' => 'Información del usuario actualizada',
            );
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }

    public function setDatosUsuario(
        $_datos_ = array(
            'ID' => 0,
            'FOTO' => '/images/sin_imagen.png',
            'NOMBRE' => '',
            'APELLIDO' => '',
            'FIRMA' => '/images/sin_firma.png',
            'TELEFONO' => '',
            'CORREO' => 'sin_correo@sin_correo.com',
            'FECHA_NACIMIENTO' => '2999-01-01',
            'ID_EMPRESA' => 1,
            'ID_TALLER' => 1,
            'ID_RANGO' => 6,
            'ID_USUARIO' => 1,
        )
    ) { 
        
        $mysqlQuery = "CALL proc_usuario_crear_informacion (";
        $mysqlQuery .= "?,?,?,?,?,?,?,?,?,?,?,?,@respuesta);";

        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'ssssssisiiii',
            $_datos_['FOTO'],
            $_datos_['NOMBRE'],
            $_datos_['APELLIDO'],
            $_datos_['FIRMA'],
            $_datos_['TELEFONO'],
            $_datos_['CORREO'],
            $_datos_['ID_EMPRESA'],
            $_datos_['FECHA_NACIMIENTO'],
            $_datos_['ID_TALLER'],
            $_datos_['ID_RANGO'],
            $_datos_['ID_USUARIO'],
            $_datos_['ID']
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
                );
            } else {
                $this->arrayResponse = array(
                    'status' => 'error',
                    'message' => 'Error en la consulta #2 : ' . htmlspecialchars($mysqlStmt->error),
                );
            }
        }  else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta 1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;
    }
}