<?php

/*******************************************************************************
 *INFORMACION VEHICULO                                                          *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2021-10-13                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

$pdf->SetTextColor(0, 0, 0);
$poliza_vehiculo_array = array();
$datos_vehiculo_array = array();
$certificado_vehiculo_array = array();
$solicitudes_vehiculo_array = array();
$fotos_array = array();

$p_placa = "";
$p_pais = "";
$p_servicio = "";
$p_clase = "";
$p_marca = "";
$p_linea = "";
$p_modelo = "";
$p_cilindraje = "";
$p_tipo_motor = "";
$p_nacionalidad = "";
$p_tipo_vehiculo = "";
$p_combustible = "";
$p_potencia = "";
$p_numero_exostos = "";
$p_diametro_exostos = "";
$p_tipo_carroceria = "";
$p_color = "";
$p_vehiculo_blindado = "";
$p_numero_puertas = "";
$p_tipo_caja = "";
$p_no_serie = "";
$p_no_motor = "";
$p_repotenciado = "";
$p_no_vin = "";
$p_no_certificado_gas = "";
$p_fecha_certificado_gas = "";
$p_clasico = "";
$p_regrabacion_chasis = "";
$p_no_regrabacion_chasis = "";
$p_regrabacion_vin = "";
$p_no_regrabacion_vin = "";
$p_regrabacion_serie = "";
$p_no_regrabacion_serie = "";
$p_regrabacion_motor = "";
$p_no_regrabacion_motor = "";
$p_fecha_matricula = "";
$p_aseguradora_soat = "";
$p_numero_soat = "";
$p_fecha_expedicion_soat = "";
$p_fecha_vencimiento_soat = "";
$p_nombre_cda = "";
$p_no_rtm = "";
$p_fecha_expedicion_rtm = "";
$p_fecha_vencimiento_rtm = "";
$p_lugar_preventiva = "";
$p_numero_revision_preventiva = "";
$p_fecha_revision_preventiva = "";
$p_fecha_vencimiento_revision_preventiva = "";
$p_capacidad_carga = "";
$p_peso_bruto_vehiculo = "";
$p_capacidad_pasajeros = "";
$p_capacidad_pasajeros_sentados = "";
$p_no_ejes = "";
$p_empresa_afiliadora = "";
$p_modalidad_transporte = "";
$p_modalidad_servicio = "";
$p_radio_accion = "";
$p_no_tarjeta_operacion = "";
$p_estado_tarjeta_operacion = "";
$p_fecha_expedicion_tarjeta_operacion = "";
$p_fecha_vencimiento_tarjeta_operacion = "";
$p_fecha_habeas = "";
$p_firma = "";
$p_nombre_conductor = "";
$p_nombre_empresa = "";
$p_documento_empresa = "";
$p_direccion = "";
$p_telefono = "";
$p_celular = "";
$p_whatsapp = "";
$p_correo = "";
$p_ciudad = "";
$p_departamento = "";
$p_foto1 = "/images/sin_imagen.png";
$p_foto2 = "/images/sin_imagen.png";
$p_foto3 = "/images/sin_imagen.png";
$p_foto4 = "/images/sin_imagen.png";

$p_impronta_chasis = "/images/sin_imagen.png";
$p_impronta_serial = "/images/sin_imagen.png";
$p_impronta_motor = "/images/sin_imagen.png";

$impronta_opcional_1 = "/images/sin_imagen.png";
$impronta_opcional_2 = "/images/sin_imagen.png";
$impronta_opcional_3 = "/images/sin_imagen.png";

$p_licencia_delantera = "/images/sin_imagen.png";
$p_licencia_trasera = "/images/sin_imagen.png";
$habeas_data = "";
$p_firma_habeas = "/images/sin_imagen.png";

// # Traer datos vehiculo

if (strcmp($database->status(), "bien") == 0) {

    $DatosVehiculo = new DatosVehiculo($database->myconn);
    $datos_vehiculo_array = $DatosVehiculo->getDatosVehiculo($GLOBAL_ID_VEHICULO);

    foreach ($datos_vehiculo_array as $key => $value) {

        $p_placa = $value['placa'];

        $p_pais = $value['pais'];
        $p_servicio = $value['servicio'];
        $p_clase = $value['clase'];
        $p_marca = $value['marca'];
        $p_linea = $value['linea'];
        $p_modelo = $value['modelo'];
        $p_cilindraje = $value['cilindraje'];
        $p_tipo_motor = $value['tipo_motor'];
        $p_nacionalidad = $value['nacionalidad'];
        $p_tipo_vehiculo = $value['tipo_vehiculo'];
        $p_combustible = $value['combustible'];
        $p_potencia = $value['potencia'];
        $p_numero_exostos = $value['numero_exostos'];
        $p_diametro_exostos = $value['diametro_exostos'];
        $p_tipo_carroceria = $value['tipo_carroceria'];
        $p_color = $value['color'];

        if ($p_vehiculo_blindado = $value['vehiculo_blindado'] == 1) {
            $p_vehiculo_blindado = "NO";
        } else {
            $p_vehiculo_blindado = "SI";
        }

        $p_numero_puertas = $value['puertas'];
        $p_tipo_caja = $value['caja'];
        $p_no_serie = $value['numero_serie'];
        $p_no_motor = $value['numero_motor'];

        if ($p_repotenciado = $value['repotenciado'] == 2) {
            $p_repotenciado = "NO";
        } else {
            $p_repotenciado = "SI";
        }

        $p_no_vin = $value['numero_vin'];
        $p_no_certificado_gas = $value['certificado_gas'];
        $p_fecha_certificado_gas = $value['fecha_certificado_gas'];

        if ($p_clasico = $value['clasico'] == 2) {
            $p_clasico = "NO";
        } else {
            $p_clasico = "SI";
        }

        if ($p_regrabacion_chasis = $value['regrabacion_chasis'] == 2) {
            $p_regrabacion_chasis = "NO";
        } else {
            $p_regrabacion_chasis = "SI";
        }

        $p_no_regrabacion_chasis = $value['numero_regrabacion_chasis'];

        if ($p_regrabacion_vin = $value['regrabacion_vin'] == 2) {
            $p_regrabacion_vin = "NO";
        } else {
            $p_regrabacion_vin = "SI";
        }

        $p_no_regrabacion_vin = $value['numero_regrabacion_vin'];

        if ($p_regrabacion_serie = $value['regrabacion_serie'] == 2) {
            $p_regrabacion_serie = "NO";
        } else {
            $p_regrabacion_serie = "SI";
        }

        $p_no_regrabacion_serie = $value['numero_regrabacion_serie'];

        if ($p_regrabacion_motor = $value['regrabacion_motor'] == 2) {
            $p_regrabacion_motor = "NO";
        } else {
            $p_regrabacion_motor = "SI";
        }

        $p_no_regrabacion_motor = $value['numero_regrabacion_motor'];

        $p_fecha_matricula = $value['fecha_matricula'];
        $p_aseguradora_soat = (puntos_smart($value['nombre_soat'], 20, 19));
        $p_numero_soat = $value['numero_soat'];
        $p_fecha_expedicion_soat = $value['expedicion_soat'];
        $p_fecha_vencimiento_soat = $value['vencimiento_soat'];
        $p_nombre_cda = $value['cda'];
        $p_no_rtm = $value['numero_rtm'];
        $p_fecha_expedicion_rtm = $value['expedicion_rtm'];
        $p_fecha_vencimiento_rtm = $value['vencimiento_rtm'];
        $p_lugar_preventiva = $value['preventiva'];
        $p_numero_revision_preventiva = $value['numero_preventiva'];
        $p_fecha_revision_preventiva = $value['fecha_preventiva'];
        $p_fecha_vencimiento_revision_preventiva = $value['vencimiento_preventiva'];
        $p_capacidad_carga = $value['capacidad_carga'];
        $p_peso_bruto_vehiculo = $value['peso_vehiculo'];
        $p_capacidad_pasajeros = $value['pasajeros'];
        $p_capacidad_pasajeros_sentados = $value['pasajeros_sentados'];
        $p_no_ejes = $value['numero_ejes'];
        $p_empresa_afiliadora = $value['empresa_tarjeta_operacion'];
        $p_modalidad_transporte = (puntos_smart($value['modalidad_transporte'], 22, 22));
        $p_modalidad_servicio = $value['modalidad_servicio'];
        $p_radio_accion = $value['radio_accion'];
        $p_no_tarjeta_operacion = $value['numero_tarjeta_operacion'];
        $p_estado_tarjeta_operacion = $value['estado_tarjeta_operacion'];
        $p_fecha_expedicion_tarjeta_operacion = $value['expedicion_tarjeta_operacion'];
        $p_fecha_vencimiento_tarjeta_operacion = $value['vencimiento_tarjeta_operacion'];

        $habeas_data = $value['habeas_data'];
        $p_fecha_habeas = $value['fecha_hora_habeas'];
        $p_firma_habeas = $value['firma_habeas'];
        $p_nombre_conductor = $value['nombre_completo_habeas'];

        $p_nombre_empresa = $value['empresa_tarjeta_operacion'];
        $p_documento_empresa = $value['nit'];
        $p_direccion = $value['direccion'];
        $p_telefono = $value['telefono'];
        $p_celular = $value['telefono'];
        $p_whatsapp = $value['telefono'];
        $p_correo = $value['correo'];
        $p_ciudad = $value['ciudad'];
        $p_departamento = $value['departamento'];
    }

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}

# Traer fotos

if (strcmp($database->status(), "bien") == 0) {
    $FotosVehiculo = new FotosVehiculo($database->myconn);
    $fotos_array = $FotosVehiculo->getFotosVehiculo($GLOBAL_ID_VEHICULO);
    foreach ($fotos_array as $key => $value) {

        $p_foto1 = $value['costado_derecho'];
        $p_foto2 = $value['delantera'];
        $p_foto3 = $value['costado_izquierdo'];
        $p_foto4 = $value['trasera'];

        $p_impronta_chasis = $value['chasis'];
        $p_impronta_serial = $value['serial'];
        $p_impronta_motor = $value['motor'];

        $impronta_opcional_1 = $value['impronta_opcional_1'];
        $impronta_opcional_2 = $value['impronta_opcional_2'];
        $impronta_opcional_3 = $value['impronta_opcional_3'];

        $p_licencia_delantera = $value['licencia_delantera'];
        $p_licencia_trasera = $value['licencia_trasera'];

    }

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "Error al conectar a la base de datos", 0, 'C', 0);
}

$pdf->AddPage('', '', '', array(20, 250, 'H O J A  D E  V I D A', 45));
$pdf->Ln(-10);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(195, 20, "AUTORIZACIÓN PARA EL TRATAMIENTO", 0, 1, 'C');
$pdf->Ln(-10);
$pdf->Cell(195, 20, "DE DATOS PERSONALES", 0, 1, 'C');

$image1 = (ROOT . "/images/qr_img.png");
$pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
$image2 = (ROOT . "/images/vector_previ.png");
$pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(195, 4, $habeas_data, 0, 'J', 0);

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(-2);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(195, 20, "NOMBRE Y FIRMA DEL EMPLEADO", 0, 1, 'C');

$pdf->Ln(-3);

 $image15 = (ROOT . $p_firma_habeas);



 $pdf->Cell(60, 20, $pdf->Image($image15, $pdf->GetX() + 62, $pdf->GetY() - 3, 70, 25), 0, 0, 'L', false);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195, 20, "___________________________________", 0, 1, 'C');
$pdf->Ln(-10);
$pdf->Cell(195, 20, $p_nombre_conductor . "   " . $p_fecha_habeas, 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY($pdf->GetX() + 25, 1000);
$pdf->MultiCell(150, 4, "NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S", 0, 'C', 0);

$pdf->Ln(-5);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 20, "INFORMACIÓN DEL VEHICULO ", 0, 1, 'C');

$pdf->Ln(0);

$image1 = (ROOT . "/images/qr_img.png");
$pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
$image2 = (ROOT . "/images/vector_previ.png");
$pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(80, 6, "DATOS DEL PROPIETARIO O EMPRESA RESPONSABLE DEL VEHÌCULO", 0, 'L');

$pdf->Ln(6);
$pdf->SetFillColor(213, 213, 213);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(120, 4, "Nombre o Razòn Social", 'L,T,', 0, 'L', true);
$pdf->Cell(75, 4, "Documento de identidad / NIT", 'L,T,R', 0, 'L', true);

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(120, 4, $p_nombre_empresa, 'L,R, B', 0, 'R');
$pdf->Cell(75, 4, $p_documento_empresa, 'L,R,B', 0, 'L');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(84, 4, "Dirección", 'L,T,', 0, 'L', true);
$pdf->Cell(37, 4, "Telèfono", 'L,T,', 0, 'L', true);
$pdf->Cell(37, 4, "Celular", 'L,T,', 0, 'L', true);
$pdf->Cell(37, 4, "Whatsapp", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(84, 4, $p_direccion, 'L,R,B', 0, 'R');
$pdf->Cell(37, 4, $p_telefono, 'L,R, B', 0, 'R');
$pdf->Cell(37, 4, $p_celular, 'L,R,B', 0, 'R');
$pdf->Cell(37, 4, $p_whatsapp, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(103, 4, "Correo Electronico", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Ciudad", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Departamento", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(103, 4, $p_correo, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_ciudad, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_departamento, 'L,R,B', 0, 'R');

$pdf->Ln(6); // salto de linea 6 linea
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "FOTOS DEL VEHÌCULO", 0, 0, 'C');

$pdf->Image(ROOT . $p_foto1, 160, 78, 45, 55);

$pdf->Image(ROOT . $p_foto2, 110, 78, 45, 55);

$pdf->Image(ROOT . $p_foto3, 60, 78, 45, 55);

$pdf->Image(ROOT . $p_foto4, 10, 78, 45, 55);

$pdf->Ln(70); // salto de linea 6 linea
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "DATOS DEL VEHÌCULO", 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, "Placa", 'L,T,', 0, 'L', true);
$pdf->Cell(27, 4, "Paìs", 'L,T,', 0, 'L', true);
$pdf->Cell(28, 4, "Servicio", 'L,T,', 0, 'L', true);
$pdf->Cell(28, 4, "Clase", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Marca", 'L,T,R', 0, 'L', true);
$pdf->Cell(57, 4, "Lìnea", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 4, $p_placa, 'L,R,B', 0, 'R');
$pdf->Cell(27, 4, $p_pais, 'L,R, B', 0, 'R');
$pdf->Cell(28, 4, $p_servicio, 'L,R,B', 0, 'R');
$pdf->Cell(28, 4, $p_clase, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_marca, 'L,R,B', 0, 'R');
$pdf->Cell(57, 4, $p_linea, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 4, "Modelo", 'L,T,', 0, 'L', true);
$pdf->Cell(27, 4, "Cilindraje", 'L,T,', 0, 'L', true);
$pdf->Cell(28, 4, "Tipo Motor", 'L,T,', 0, 'L', true);
$pdf->Cell(28, 4, "Nacionalidad", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Tipo De Vehiculo", 'L,T,R', 0, 'L', true);
$pdf->Cell(57, 4, "Combustible", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(17, 4, $p_modelo, 'L,R,B', 0, 'R');
$pdf->Cell(27, 4, $p_cilindraje, 'L,R, B', 0, 'R');
$pdf->Cell(28, 4, $p_tipo_motor, 'L,R,B', 0, 'R');
$pdf->Cell(28, 4, $p_nacionalidad, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_tipo_vehiculo, 'L,R,B', 0, 'R');
$pdf->Cell(57, 4, $p_combustible, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 4, "Potencia", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Numero De Exostos", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Diametro De Exostos", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Tipo De Carroceria", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Color", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 4, $p_potencia, 'L,R, B', 0, 'R');
$pdf->Cell(36, 4, $p_numero_exostos, 'L,R,B', 0, 'R');
$pdf->Cell(36, 4, $p_diametro_exostos, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_tipo_carroceria, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_color, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 4, "Vehiculo Blindado", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Numero De Puertas", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Tipo De Caja", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Numero De Serie", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Numero De Motor", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 4, $p_vehiculo_blindado, 'L,R, B', 0, 'R');
$pdf->Cell(36, 4, $p_numero_puertas, 'L,R,B', 0, 'R');
$pdf->Cell(36, 4, $p_tipo_caja, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_no_serie, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_no_motor, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 4, "Repontenciado", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Numero De Numero VIN", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "No Certificado GNV", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Fecha Certificado GNV", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Clasico o Antiguo", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 4, $p_repotenciado, 'L,R, B', 0, 'R');
$pdf->Cell(36, 4, $p_no_vin, 'L,R,B', 0, 'R');
$pdf->Cell(36, 4, $p_no_certificado_gas, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_fecha_certificado_gas, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_clasico, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Regrabacion Chasis", 'L,T,', 0, 'L', true);
$pdf->Cell(45, 4, "Numero Regrabacion Chasis", 'L,T,R', 0, 'L', true);
$pdf->Cell(47, 4, "Regrabacion VIN", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Numero Regrabacion VIN", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 4, $p_regrabacion_chasis, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_no_regrabacion_chasis, 'L,R,B', 0, 'R');
$pdf->Cell(47, 4, $p_regrabacion_vin, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_no_regrabacion_vin, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Regrabacion Serie", 'L,T,', 0, 'L', true);
$pdf->Cell(45, 4, "Numero Regrabacion Serie", 'L,T,R', 0, 'L', true);
$pdf->Cell(47, 4, "Regrabacion Motor", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Numero Regrabacion Motor", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 4, $p_regrabacion_serie, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_no_regrabacion_serie, 'L,R,B', 0, 'R');
$pdf->Cell(47, 4, $p_regrabacion_motor, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_no_regrabacion_motor, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(27, 4, "Fecha De Matricula", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Aseguradora SOAT", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Numero De SOAT", 'L,T,R', 0, 'L', true);
$pdf->Cell(38, 4, "Fecha De Expedicion SOAT", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Fecha De Vencimiento SOAT", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(27, 4, $p_fecha_matricula, 'L,R, B', 0, 'R');
$pdf->Cell(36, 4, $p_aseguradora_soat, 'L,R,B', 0, 'R');
$pdf->Cell(36, 4, $p_numero_soat, 'L,R,B', 0, 'R');
$pdf->Cell(38, 4, $p_fecha_expedicion_soat, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_fecha_vencimiento_soat, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(45, 4, "Nombre CDA", 'L,T,', 0, 'L', true);
$pdf->Cell(45, 4, "Numero de RTM", 'L,T,R', 0, 'L', true);
$pdf->Cell(47, 4, "Fecha De Expedicion RTM", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Fecha De Vencimiento RTM", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(45, 4, $p_nombre_cda, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_no_rtm, 'L,R,B', 0, 'R');
$pdf->Cell(47, 4, $p_fecha_expedicion_rtm, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_fecha_vencimiento_rtm, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(45, 4, "Lugar Revision Preventiva", 'L,T,', 0, 'L', true);
$pdf->Cell(45, 4, "Numero de Revision Preventiva", 'L,T,R', 0, 'L', true);
$pdf->Cell(47, 4, "Fecha De Revision Preventiva", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Fecha Vencimiento Revision Preventiva", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(45, 4, $p_lugar_preventiva, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_numero_revision_preventiva, 'L,R,B', 0, 'R');
$pdf->Cell(47, 4, $p_fecha_revision_preventiva, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_fecha_vencimiento_revision_preventiva, 'L,R,B', 0, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "DATOS TÉCNICOS DEL VEHÌCULO", 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(33, 4, "Capacidad De Carga", 'L,T,', 0, 'L', true);
$pdf->Cell(36, 4, "Peso Bruto Del Vehiculo", 'L,T,', 0, 'L', true);
$pdf->Cell(33, 4, "Capacidad Pasajeros", 'L,T,R', 0, 'L', true);
$pdf->Cell(45, 4, "Capacidad Pasajeros Sentados", 'L,T,R', 0, 'L', true);
$pdf->Cell(48, 4, "Numero De ejes", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 4, $p_capacidad_carga, 'L,R, B', 0, 'R');
$pdf->Cell(36, 4, $p_peso_bruto_vehiculo, 'L,R,B', 0, 'R');
$pdf->Cell(33, 4, $p_capacidad_pasajeros, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_capacidad_pasajeros_sentados, 'L,R,B', 0, 'R');
$pdf->Cell(48, 4, $p_no_ejes, 'L,R,B', 0, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "TARJETA DE OPERACIÓN", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Empresa Afiliadora", 'L,T,', 0, 'L', true);
$pdf->Cell(42, 4, "Modalidad Transporte", 'L,T,R', 0, 'L', true);
$pdf->Cell(50, 4, "Modalidad Servicio", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Radio De Accion", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 4, $p_empresa_afiliadora, 'L,R,B', 0, 'R');
$pdf->Cell(42, 4, $p_modalidad_transporte, 'L,R,B', 0, 'R');
$pdf->Cell(50, 4, $p_modalidad_servicio, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_radio_accion, 'L,R,B', 0, 'R');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Numero Tarjeta Operacion", 'L,T,', 0, 'L', true);
$pdf->Cell(42, 4, "Estado Tarjeta Operacion", 'L,T,R', 0, 'L', true);
$pdf->Cell(50, 4, "Fecha Expedicion Tarjeta Operacion", 'L,T,R', 0, 'L', true);
$pdf->Cell(58, 4, "Fecha Vencimiento Tarjeta Operacion", 'L,T,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(45, 4, $p_no_tarjeta_operacion, 'L,R,B', 0, 'R');
$pdf->Cell(42, 4, $p_estado_tarjeta_operacion, 'L,R,B', 0, 'R');
$pdf->Cell(50, 4, $p_fecha_expedicion_tarjeta_operacion, 'L,R,B', 0, 'R');
$pdf->Cell(58, 4, $p_fecha_vencimiento_tarjeta_operacion, 'L,R,B', 0, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "POLIZAS", 0, 0, 'C');

//polizas

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Tipo De Poliza", 1, 0, 'L', true);
$pdf->Cell(45, 4, "Aseguradora", 1, 0, 'L', true);
$pdf->Cell(47, 4, "Fecha De Expedicion Poliza", 1, 0, 'L', true);
$pdf->Cell(58, 4, "Fecha De Vencimiento Poliza", 1, 0, 'L', true);
$pdf->Ln();
# Traer las polizas

if (strcmp($database->status(), "bien") == 0) {
    $Poliza = new Poliza($database->myconn);
    $poliza_vehiculo_array = $Poliza->getPolizaVehiculo($GLOBAL_ID_VEHICULO);
    foreach ($poliza_vehiculo_array as $key => $value) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(45, 4, $value['nombre_poliza'], 1, 0, 'R');
        $pdf->Cell(45, 4, $value['aseguradora_poliza'], 1, 0, 'R');
        $pdf->Cell(47, 4, $value['expedicion_poliza'], 1, 0, 'R');
        $pdf->Cell(58, 4, $value['vencimiento_polzia'], 1, 0, 'R');
        $pdf->Ln();
    }

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "Error al conectar a la base de datos", 0, 'C', 0);
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "CERTIFICADOS", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Tipo De Certificado", 1, 0, 'L', true);
$pdf->Cell(45, 4, "Ente Que Otorga Certificado", 1, 0, 'L', true);
$pdf->Cell(47, 4, "Fecha De Expedicion Certificado", 1, 0, 'L', true);
$pdf->Cell(58, 4, "Fecha De Vencimiento Certificado", 1, 0, 'L', true);

# Traer certificados

if (strcmp($database->status(), "bien") == 0) {
    $CertificadoVehiculo = new CertificadoVehiculo($database->myconn);
    $certificado_vehiculo_array = $CertificadoVehiculo->getCertificadoVehiculo($GLOBAL_ID_VEHICULO);
    foreach ($certificado_vehiculo_array as $key => $value) {

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(45, 4, $value['tipo_certificado'], 1, 0, 'R');
        $pdf->Cell(45, 4, $value['ente_otorga'], 1, 0, 'R');
        $pdf->Cell(47, 4, $value['fecha_expedicion_certificado'], 1, 0, 'R');
        $pdf->Cell(58, 4, $value['fecha_vencimiento_certificado'], 1, 0, 'R');

    }

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "Error al conectar a la base de datos", 0, 'C', 0);
}

$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "SOLICITUDES", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(45, 4, "Tipo De Solicitud", 1, 0, 'L', true);
$pdf->Cell(29, 4, "Fecha De Solicitud", 1, 0, 'L', true);
$pdf->Cell(30, 4, "Numero De Solicidud", 1, 0, 'L', true);
$pdf->Cell(58, 4, "Entidad De Transito", 1, 0, 'L', true);
$pdf->Cell(33, 4, "Estado De La Solicitud", 1, 0, 'L', true);
$pdf->Ln();

# Traer certificados

if (strcmp($database->status(), "bien") == 0) {
    $SolicitudVehiculo = new SolicitudVehiculo($database->myconn);
    $solicitudes_vehiculo_array = $SolicitudVehiculo->getSolicitudVehiculo($GLOBAL_ID_VEHICULO);
    foreach ($solicitudes_vehiculo_array as $key => $value) {

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(45, 4, $value['tipo_solicitud'], 1, 0, 'R');
        $pdf->Cell(29, 4, $value['fecha_solicitud'], 1, 0, 'R');
        $pdf->Cell(30, 4, $value['numero_solicitud'], 1, 0, 'R');
        $pdf->Cell(58, 4, $value['entidad_transito_solicitud'], 1, 0, 'R');
        $pdf->Cell(33, 4, $value['estado'], 1, 0, 'R');
        $pdf->Ln();
    }

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "Error al conectar a la base de datos", 0, 'C', 0);
}


$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "LICENCIA DE TRANSITO", 0, 0, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(97.5, 4, "PARTE DELANTERA", 0, 0, 'C');
$pdf->Cell(97.5, 4, "PARTE TRASERA", 0, 0, 'C');

$pdf->Ln(10);
$image8 = (ROOT . $p_licencia_delantera);
$pdf->Cell(60, 20, $pdf->Image($image8, $pdf->GetX(), $pdf->GetY(), 95, 55), 0, 0, 'L', false);

$image9 = (ROOT . $p_licencia_trasera);
$pdf->Cell(60, 20, $pdf->Image($image9, $pdf->GetX() + 40, $pdf->GetY(), 95, 55), 0, 0, 'L', false);

$pdf->Ln(160);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "IMPRONTAS DEL VEHICULO", 0, 0, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(97.5, 4, "CHASIS", 0, 0, 'L');
$pdf->Cell(97.5, 4, "SERIAL", 0, 0, 'L');

$pdf->Ln(10);
$image5 = (ROOT . $p_impronta_chasis);
$pdf->Cell(60, 20, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY(), 95, 70), 0, 0, 'L', false);

$image6 = (ROOT . $p_impronta_serial);
$pdf->Cell(60, 20, $pdf->Image($image6, $pdf->GetX() + 40, $pdf->GetY(), 95, 70), 0, 0, 'L', false);

$pdf->Ln(80);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(97.5, 4, "MOTOR", 0, 0, 'L');
$pdf->Cell(97.5, 4, "IMPRONTA OPCIONAL 1", 0, 0, 'L');

$pdf->Ln(10);
$image7 = (ROOT . $p_impronta_motor);
$pdf->Cell(60, 20, $pdf->Image($image7, $pdf->GetX() , $pdf->GetY(), 95, 70), 0, 0, 'L', false);
$image8 = (ROOT . $impronta_opcional_1);
$pdf->Cell(60, 20, $pdf->Image($image8, $pdf->GetX() + 40, $pdf->GetY(), 95, 70), 0, 0, 'L', false);

$pdf->Ln(100);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(97.5, 4, "IMPRONTA OPCIONAL 2", 0, 0, 'L');
$pdf->Cell(97.5, 4, "IMPRONTA OPCIONAL 3", 0, 0, 'L');

$pdf->Ln(10);
$image9 = (ROOT . $impronta_opcional_2);
$pdf->Cell(60, 20, $pdf->Image($image9, $pdf->GetX() , $pdf->GetY(), 95, 70), 0, 0, 'L', false);
$image10 = (ROOT . $impronta_opcional_3);
$pdf->Cell(60, 20, $pdf->Image($image8, $pdf->GetX() + 40, $pdf->GetY(), 95, 70), 0, 0, 'L', false);





$p_placa = "";

// $pdf->Output('I', 'pdfs/INFORMACION DEL VEHICULO' . ' ' . $p_placa . '.pdf');