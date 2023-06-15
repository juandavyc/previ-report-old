<?php session_start();
header('Content-Type: application/json');
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/preoperacional/mecanico/create.php';
// var_dump($_POST);

$headers = apache_request_headers();

if (
    isset($_POST["form_1_index_0"]) &&
    isset($_POST["form_1_index_1"]) &&
    isset($_POST["form_1_index_2"]) &&
    isset($_POST["form_1_index_3"]) &&
    isset($_POST["form_1_index_4"]) &&
    isset($_POST["form_1_index_5"]) &&
    isset($_POST["form_1_index_6"]) &&
    isset($_POST["form_1_index_7"]) &&
    isset($_POST["form_1_index_8"]) &&
    isset($_POST["form_1_index_9"]) &&
    isset($_POST["form_1_index_10"]) &&
    isset($_POST["form_1_index_11"]) &&
    isset($_POST["form_1_index_12"]) &&
    isset($_POST["form_1_index_13"]) &&
    isset($_POST["form_1_index_14"]) &&
    isset($_POST["form_1_index_15"]) &&
    isset($_POST["form_1_index_16"]) &&
    isset($_POST["form_1_index_17"]) &&
    isset($_POST["form_1_index_18"]) &&
    isset($_POST["form_1_index_19"]) &&
    isset($_POST["id_preoperativo"]) &&
    isset($_SESSION["session_user"]) &&
    count($_SESSION["session_user"]) == 5 &&
    count($_POST) == 254
) {

    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_database.php';
    include DOCUMENT_ROOT . '/modulos/assets/php/hdv_resources.php';

    $json_status = "error";
    $json_message = "inicio";

    if (
        isset($headers['csrf-token']) &&
        hash_equals($headers['csrf-token'], $_SESSION['csrf_token'])
    ) {

        $database = new dbconnection();
        $database->connect();

        if (strcmp($database->status(), "bien") == 0) {

            $a = 0;
            $EstadoDePresentacion = array();
            $EstadoDeComodidad = array();
            $NivelesYPerdidasDeLiquidos = array();
            $TableroDeControl = array();
            $SeguridadPasiva = array();
            $SeguridadActiva = array();
            $EstadoLuces = array();
            $EstadoLlantas = array();
            $Frenos = array();
            $Otros = array();
            $EquipoDeCarretera = array();
            $Buses = array();
            $RemolqueDeTractocamiones = array();
            $Volquetas = array();
            $Camion = array();
            $VehiculosRecolectoresDeBasuras = array();
            $Ensenianza = array();
            $Ambulancia = array();
            $Montacargas = array();
            $Motos = array();
            $Resultados = array();

            foreach ($_POST as $key => $value) {
                $keyy = str_replace("form_1_", "", $key);
                $b = $_POST['form_1_index_' . $a];
                if ($b == 0) {
                    if ($keyy == "index_1") {
                        $a++;
                    } else {
                        $EstadoDePresentacion[$keyy] = $value;
                    }
                } else if ($b == 1) {
                    if ($keyy == "index_2") {
                        $a++;
                    } else {
                        $EstadoDeComodidad[$keyy] = $value;
                    }
                } else if ($b == 2) {
                    if ($keyy == "index_3") {
                        $a++;
                    } else {
                        $NivelesYPerdidasDeLiquidos[$keyy] = $value;
                    }
                } else if ($b == 3) {
                    if ($keyy == "index_4") {
                        $a++;
                    } else {
                        $TableroDeControl[$keyy] = $value;
                    }
                } else if ($b == 4) {
                    if ($keyy == "index_5") {
                        $a++;
                    } else {
                        $SeguridadPasiva[$keyy] = $value;
                    }
                } else if ($b == 5) {
                    if ($keyy == "index_6") {
                        $a++;
                    } else {
                        $SeguridadActiva[$keyy] = $value;
                    }
                } else if ($b == 6) {
                    if ($keyy == "index_7") {
                        $a++;
                    } else {
                        $EstadoLuces[$keyy] = $value;
                    }
                } else if ($b == 7) {
                    if ($keyy == "index_8") {
                        $a++;
                    } else {
                        $EstadoLlantas[$keyy] = $value;
                    }
                } else if ($b == 8) {
                    if ($keyy == "index_9") {
                        $a++;
                    } else {
                        $Frenos[$keyy] = $value;
                    }
                } else if ($b == 9) {
                    if ($keyy == "index_10") {
                        $a++;
                    } else {
                        $Otros[$keyy] = $value;
                    }
                } else if ($b == 10) {
                    if ($keyy == "index_11") {
                        $a++;
                    } else {
                        $EquipoDeCarretera[$keyy] = $value;
                    }
                } else if ($b == 11) {
                    if ($keyy == "index_12") {
                        $a++;
                    } else {
                        $Buses[$keyy] = $value;
                    }
                } else if ($b == 12) {
                    if ($keyy == "index_13") {
                        $a++;
                    } else {
                        $RemolqueDeTractocamiones[$keyy] = $value;
                    }
                } else if ($b == 13) {
                    if ($keyy == "index_14") {
                        $a++;
                    } else {
                        $Volquetas[$keyy] = $value;
                    }
                } else if ($b == 14) {
                    if ($keyy == "index_15") {
                        $a++;
                    } else {
                        $Camion[$keyy] = $value;
                    }
                } else if ($b == 15) {
                    if ($keyy == "index_16") {
                        $a++;
                    } else {
                        $VehiculosRecolectoresDeBasuras[$keyy] = $value;
                    }
                } else if ($b == 16) {
                    if ($keyy == "index_17") {
                        $a++;
                    } else {
                        $Ensenianza[$keyy] = $value;
                    }
                } else if ($b == 17) {
                    if ($keyy == "index_18") {
                        $a++;
                    } else {
                        $Ambulancia[$keyy] = $value;
                    }
                } else if ($b == 18) {
                    if ($keyy == "index_19") {
                        $a++;
                    } else {
                        $Montacargas[$keyy] = $value;
                    }
                } else if ($b == 19) {
                    if ($keyy == "index_20") {
                        $a++;
                    } else {
                        $Motos[$keyy] = $value;
                    }
                } else if ($b == 20) {
                    if ($keyy == "index_21") {
                        $a++;
                    } else {
                        $Resultados[$keyy] = $value;
                    }
                }
            }
            // JSON CON TODO EL PREOPERATIVO
            $json_datos_preoperativo = array(
                'status' => 'bien',
                'EstadoDePresentacion' => $EstadoDePresentacion,
                'EstadoDeComodidad' => $EstadoDeComodidad,
                'NivelesYPerdidasDeLiquidos' => $NivelesYPerdidasDeLiquidos,
                'TableroDeControl' => $TableroDeControl,
                'SeguridadPasiva' => $SeguridadPasiva,
                'SeguridadActiva' => $SeguridadActiva,
                'EstadoLuces' => $EstadoLuces,
                'EstadoLlantas' => $EstadoLlantas,
                'Frenos' => $Frenos,
                'Otros' => $Otros,
                'EquipoDeCarretera' => $EquipoDeCarretera,
                'Buses' => $Buses,
                'RemolqueDeTractocamiones' => $RemolqueDeTractocamiones,
                'Volquetas' => $Volquetas,
                'Camion' => $Camion,
                'VehiculosRecolectoresDeBasuras' => $VehiculosRecolectoresDeBasuras,
                'Ensenianza' => $Ensenianza,
                'Ambulancia' => $Ambulancia,
                'Montacargas' => $Montacargas,
                'Motos' => $Motos,
                'Resultados' => $Resultados,
            );


            $id_usuario = $_SESSION['session_user'][1];
            $json_preoperativo = json_encode($json_datos_preoperativo);
            $id_preoperativo = encrypt($_POST['id_preoperativo'], 2);
            $resultado_preoperativo = htmlspecialchars($_POST['form_1_resultado_preoperativo']);
            $observaciones_conductor = htmlspecialchars($_POST['form_1_observaciones_conductor']);
            // $observaciones_supervisor_patio = htmlspecialchars($_POST['form_1_observaciones_supervisor_patio']);

            $firma_supervisor = getSRCImage64($_POST['form_1_canvas'], 'preoperacional/firma', $id_usuario . '_' . time());
            // FOTOS
            $foto_1 = htmlspecialchars($_POST['form_1_foto_vehiculo_salida']);
            $foto_2 = htmlspecialchars($_POST['form_1_foto_vehiculo_regreso']);

            $mantenimiento = new CreatePreoperativo($database->myconn);
            $arrayResponse = $mantenimiento->setPreoperativo(
                $json_preoperativo,
                $id_usuario,
                $id_preoperativo,
                $resultado_preoperativo,
                $observaciones_conductor,
                $firma_supervisor,
                $foto_1,
                $foto_2
            );

            if ($arrayResponse['status'] == 'bien') {
                $json_status = $arrayResponse['status'];
                $json_message = $arrayResponse['message'];
            } else {
                $json_status = $arrayResponse['status'];
                $json_message = $arrayResponse['message'];
            }

            $database->close();
        } else {
            $json_status = "error";
            $json_message = "Imposible conectar a la base de datos";
        }
    } else {
        $json_status = "error";
        $json_message = htmlspecialchars("Wrong CSRF token.");
    }


    $json_array = array(
        'status' => $json_status,
        'message' => $json_message,
    );

    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
} else if (!isset($_SESSION["session_user"])) {
    $datos = array(
        'status' => "session",
        'message' => "La sesión fue cerrada, inicie sesión nuevamente.",
    );
    echo json_encode($datos, JSON_FORCE_OBJECT);
    exit;
} else {
    $json_array = array(
        'status' => "Error",
        'message' => "Formulario incompleto",
    );
    echo json_encode($json_array, JSON_FORCE_OBJECT);
    exit;
}
