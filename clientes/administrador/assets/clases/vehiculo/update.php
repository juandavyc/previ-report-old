<?php

class UpdateVehiculo
{
    private $databaseConnection = null;
    private $arrayResponse = array();

    public function __construct($_database_)
    {
        $this->databaseConnection = $_database_;
    }

    public function setInformacionBasica(
        $_licencia_vehiculo = '',
        $_estado_vehiculo = 1,
        $_servicio_vehiculo = 1,
        $_clase_vehiculo = 1,
        $_id_empresa = 1,
        $_marca_vehiculo = 0,
        $_linea_vehiculo = 0,
        $_modelo_vehiculo = 1,
        $_color_vehiculo = 1,
        $_serie_vehiculo = '',
        $_motor_vehiculo = '',
        $_vin_vehiculo = '',
        $_carroceria_vehiculo = 1,
        $_cilindraje = 1,
        $_combustible_vehiculo = 1,
        $_fecha_matricula_vehiculo = '2999-01-01',
        $_autoridad_de_transito_vehiculo = 1,
        $_gravamenes_a_la_propiedad = 1,
        $_clasico_o_antiguo = 1,
        $_repotenciado_vehiculo = 1,
        $_vehiculo_ensenianza = 1,
        $_regrabacion_motor_vehiculo = 1,
        $_numero_regrabacion_motor_vehiculo = '',
        $_regrabacion_chasis_vehiculo = 1,
        $_numero_regrabacion_chasis_vehiculo = '',
        $_regrabacion_serie_vehiculo = 1,
        $_numero_regrabacion_serie_vehiculo = '',
        $_regrabacion_vin_vehiculo = 1,
        $_numero_regrabacion_vin_vehiculo = '',
        $_id_vehiculo = 0
    ) {

        $mysqlQuery = "CALL proc_vehiculo_informacion_detallada (";
        $mysqlQuery .= "?,?,?,?,?,?,?,?,?,?,";
        $mysqlQuery .= "?,?,?,?,?,?,?,?,?,?,";
        $mysqlQuery .= "?,?,?,?,?,?,?,?,?,?,@respuesta);";
        $mysqlStmt = mysqli_prepare($this->databaseConnection, $mysqlQuery);
        $mysqlStmt->bind_param(
            'siiiiiisisssiisiiiiiisisisissi',
            $_licencia_vehiculo,
            $_estado_vehiculo,
            $_servicio_vehiculo,
            $_clase_vehiculo,
            $_id_empresa,
            $_marca_vehiculo,
            $_linea_vehiculo,
            $_modelo_vehiculo,
            $_color_vehiculo,
            $_serie_vehiculo,
            $_motor_vehiculo,
            $_vin_vehiculo,
            $_carroceria_vehiculo,
            $_combustible_vehiculo,
            $_fecha_matricula_vehiculo,
            $_autoridad_de_transito_vehiculo,
            $_gravamenes_a_la_propiedad,
            $_clasico_o_antiguo,
            $_repotenciado_vehiculo,
            $_vehiculo_ensenianza,
            $_regrabacion_motor_vehiculo,
            $_numero_regrabacion_motor_vehiculo,
            $_regrabacion_chasis_vehiculo,
            $_numero_regrabacion_chasis_vehiculo,
            $_regrabacion_serie_vehiculo,
            $_numero_regrabacion_serie_vehiculo,
            $_regrabacion_vin_vehiculo,
            $_numero_regrabacion_vin_vehiculo,
            $_cilindraje,
            $_id_vehiculo
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
        } else {
            $this->arrayResponse = array(
                'status' => 'error',
                'message' => 'Error en la consulta #1 : ' . htmlspecialchars($mysqlStmt->error),
            );
        }
        return $this->arrayResponse;

    }

}