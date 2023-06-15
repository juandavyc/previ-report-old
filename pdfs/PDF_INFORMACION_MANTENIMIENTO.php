<?php

/*******************************************************************************
 * MANTENIMIENTO VEHICULAR                                                      *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2021-10-18                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

$pdf->SetTextColor(0, 0, 0);

$datos_mantenimiento_array = array();
$repuestos_array = array();

$habeas_data = "";
$p_placa = " ";
$p_foto_perfil = "/images/sin_imagen.png";
$p_nombre_conductor = "";
$p_fecha_habeas = "";
$p_firma_habeas = "/images/firma.png";
$p_periodo_mantenimiento = "";
$p_nombre_autoriza = "";
$p_documento_autoriza = "";
$p_telefono_autoriza = "";
$p_cargo_autoriza = "";
$p_orden_servicio = "";
$p_no_orden_servicio = "";
$p_firma_quien_autoriza = "/images/firma.png";
$p_clase_mantenimiento = "";
$p_fecha_manteniminto = "";
$p_lugar_mantenimiento = "";
$p_precio_mano_obra_total = "";
$p_precio_repuestos_total = "";
$p_cantidad_repuestos = "";
$p_nombre_mecanico = "";
$p_documento_mecanico = "";
$p_tarjeta_profesional_mecanico = "";
$p_telefono_mecanico = "";
$p_direccion_mecanico = "";
$p_correo_mecanico = "";
$p_nombre_taller = "";
$p_documento_taller = "";
$p_ciudad_taller = "";
$p_telefono_taller = "";
$p_direccion_taller = "";
$p_correo_taller = "";
$p_descripcion_danos_proceso_realizar = "";
$p_repuestos_utilizar = "";
$p_fecha_hora_inicio_reparacion = "";
$p_fecha_hora_final_reparacion = "";
$p_foto_antes_reparar_1 = "/images/sin_imagen.png";
$p_foto_antes_reparar_2 = "/images/sin_imagen.png";
$p_foto_antes_reparar_3 = "/images/sin_imagen.png";
$p_repuesto_danado_1 = "/images/sin_imagen.png";
$p_repuesto_danado_2 = "/images/sin_imagen.png";
$p_repuesto_danado_3 = "/images/sin_imagen.png";
$p_repuesto_nuevo_1 = "/images/sin_imagen.png";
$p_repuesto_nuevo_2 = "/images/sin_imagen.png";
$p_repuesto_nuevo_3 = "/images/sin_imagen.png";
$p_foto_despues_reparar_1 = "/images/sin_imagen.png";
$p_foto_despues_reparar_2 = "/images/sin_imagen.png";
$p_foto_despues_reparar_3 = "/images/sin_imagen.png";
$p_procedimiento_realizado = "";
$p_nombre_repuesto = "";
$p_cantidad_repuesto = "";
$p_precio_repuesto = "";
$p_foto_factura_1_repuestos = "/images/sin_imagen.png";
$p_foto_factura_2_repuestos = "/images/sin_imagen.png";
$p_foto_factura_3_repuestos = "/images/sin_imagen.png";
$p_foto_factura_1_mano_obra = "/images/sin_imagen.png";
$p_foto_factura_2_mano_obra = "/images/sin_imagen.png";
$p_foto_factura_3_mano_obra = "/images/sin_imagen.png";
$p_observaciones_recomendaciones = "";
$p_firma_conductor = "/images/firma.png";
$hora_mantenimiento_inicio = "";
$hora_mantenimiento_fin = "";

if (strcmp($database->status(), "bien") == 0) {

    $ReadMantenimientoSuper = new ReadMantenimientoSuper($database->myconn);
    $datos_mantenimiento_array = $ReadMantenimientoSuper->getMantenimientoSuper(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            'LIMITE' => '5',

        ));

    ## si tiene resultados
    if ($datos_mantenimiento_array['status'] == "bien") {

        foreach ($datos_mantenimiento_array as $key => $value) {

            # habeas data existe
            if (isset($datos_mantenimiento_array['mantenimiento'][0]["habeas"])) {
                $habeas_data = $datos_mantenimiento_array['mantenimiento'][0]["habeas"];
            }

            $p_placa = $datos_mantenimiento_array['mantenimiento'][0]["placa"];
            $p_foto_perfil = "/images/sin_imagen.png";
            $p_nombre_conductor = $datos_mantenimiento_array['mantenimiento'][0]["nombre_habeas"];
            $p_fecha_habeas = $datos_mantenimiento_array['mantenimiento'][0]["fecha_habeas"];
            // $p_firma_habeas = $datos_mantenimiento_array['mantenimiento'][0]["firma_habeas"];
            $p_periodo_mantenimiento = $datos_mantenimiento_array['mantenimiento'][0]["periodo"];
            $p_nombre_autoriza = $datos_mantenimiento_array['mantenimiento'][0]["nombre_autoriza"];
            $p_documento_autoriza = $datos_mantenimiento_array['mantenimiento'][0]["cedula_supervisor"];
            $p_telefono_autoriza = $datos_mantenimiento_array['mantenimiento'][0]["telefono_autoriza"];
            $p_cargo_autoriza = $datos_mantenimiento_array['mantenimiento'][0]["cargo"];

            if ($datos_mantenimiento_array['mantenimiento'][0]["orden"] == 2) {

                $p_orden_servicio = "NO";
            } else {
                $p_orden_servicio = "SI";
            }

            $p_no_orden_servicio = $datos_mantenimiento_array['mantenimiento'][0]["numero_orden"];
            $p_firma_quien_autoriza = $datos_mantenimiento_array['mantenimiento'][0]["firma_supervisor"];
            $p_clase_mantenimiento = $datos_mantenimiento_array['mantenimiento'][0]["nombre_tipo"];
            $p_fecha_manteniminto = $datos_mantenimiento_array['mantenimiento'][0]["fecha_mantenimiento"];
            $p_lugar_mantenimiento = $datos_mantenimiento_array['mantenimiento'][0]["nombre_taller"];
            $p_precio_mano_obra_total = "$ " . $datos_mantenimiento_array['mantenimiento'][0]["precio_mano_de_obra"];
            $p_precio_repuestos_total = "$ " . $datos_mantenimiento_array['mantenimiento'][0]["precio_repuestos"];
            $p_cantidad_repuestos = $datos_mantenimiento_array['mantenimiento'][0]["cantidad_respuestos"];
            $p_nombre_mecanico = $datos_mantenimiento_array['mantenimiento'][0]["nombre_mecanico"];
            $p_documento_mecanico = $datos_mantenimiento_array['mantenimiento'][0]["cedula_mecanico"];
            $p_tarjeta_profesional_mecanico = "SIN TARJETA PROFESIONAL";
            $p_telefono_mecanico = $datos_mantenimiento_array['mantenimiento'][0]["telefono_mecanico"];
            $p_direccion_mecanico = "SIN DIRECCION";
            $p_correo_mecanico = $datos_mantenimiento_array['mantenimiento'][0]["correo_mecanico"];
            $p_nombre_taller = $datos_mantenimiento_array['mantenimiento'][0]["nombre_taller"];
            $p_documento_taller = $datos_mantenimiento_array['mantenimiento'][0]["nit_taller"];
            $p_ciudad_taller = $datos_mantenimiento_array['mantenimiento'][0]["ciudad_taller"];
            $p_telefono_taller = $datos_mantenimiento_array['mantenimiento'][0]["telefono_taller"];
            $p_direccion_taller = $datos_mantenimiento_array['mantenimiento'][0]["direccion_taller"];
            $p_correo_taller = $datos_mantenimiento_array['mantenimiento'][0]["correo_taller"];
            $p_descripcion_danos_proceso_realizar = $datos_mantenimiento_array['mantenimiento'][0]["descripcion_danos"];
            $p_repuestos_utilizar = $datos_mantenimiento_array['mantenimiento'][0]["repuestos_utilizados"];
            $p_fecha_hora_inicio_reparacion = $datos_mantenimiento_array['mantenimiento'][0]["fecha_inicio"];
            $p_fecha_hora_final_reparacion = $datos_mantenimiento_array['mantenimiento'][0]["fecha_fin"];
            $hora_mantenimiento_inicio = $datos_mantenimiento_array['mantenimiento'][0]["hora_inicio"];
            $hora_mantenimiento_fin = $datos_mantenimiento_array['mantenimiento'][0]["hora_fin"];

            $p_procedimiento_realizado = $datos_mantenimiento_array['mantenimiento'][0]["procedimiento_realizado"];

            $p_observaciones_recomendaciones = $datos_mantenimiento_array['mantenimiento'][0]["observaciones"];
            $p_firma_conductor = $datos_mantenimiento_array['mantenimiento'][0]["firma_mecanico"];
        }

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

    $pdf->Ln(-2);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(195, 20, "NOMBRE Y firma DEL EMPLEADO", 0, 1, 'C');

    $pdf->Ln(-3);
    $image15 = (ROOT . $p_firma_habeas);
    $pdf->Cell(60, 20, $pdf->Image($image15, $pdf->GetX() + 62, $pdf->GetY() - 3, 70, 25), 0, 0, 'L', false);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(195, 20, "___________________________________", 0, 1, 'C');
    $pdf->Ln(-10);
    $pdf->Cell(195, 20, $p_nombre_conductor . " " . $p_fecha_habeas, 0, 1, 'C');

    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetXY($pdf->GetX() + 25, 1000);
    $pdf->MultiCell(150, 4, "NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S", 0, 'C', 0);

    $pdf->Ln(-5);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 20, "INFORMACIÓN DE MANTENIMIENTOS", 0, 1, 'C');

    $pdf->Ln(0);
    $image1 = (ROOT . "/images/qr_img.png");
    $pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
    $image2 = (ROOT . "/images/vector_previ.png");
    $pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

    $pdf->Ln(10);
    $pdf->SetFillColor(213, 213, 213);
    $pdf->SetFont('Arial', 'B', 50);
    $pdf->Cell(195, 4, $p_placa, 0, 0, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "PERIODO DE MANTENIMIENTO", 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Cell(195, 4, $p_periodo_mantenimiento, 0, 0, 'C');

    $pdf->Ln(10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "QUIEN AUTORIZA EL MANTENIMIENTO", 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(65, 4, "Nombre (Quien autoriza)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Documento (Quien autoriza)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Telefono (Quien autoriza)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_nombre_autoriza, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_documento_autoriza, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_telefono_autoriza, 'L,R,B', 0, 'L');
    $pdf->Ln();
    $pdf->Cell(65, 4, "Cargo en la empresa (Quien autoriza)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Orden de servicio (si aplica)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Numero de Orden de servicio", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_cargo_autoriza, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_orden_servicio, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_no_orden_servicio, 'L,R,B', 0, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "firma DE QUIEN AUTORIZA EL MANTENIMIENTO", 0, 0, 'C');

    $pdf->Ln(10);
    $image14 = (ROOT . $p_firma_quien_autoriza);
    $pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() + 80, $pdf->GetY() - 5, 40, 20), 0, 0, 'L', false);

    $pdf->Ln(20);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(65, 4, "Clase De Mantenimiento", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Fecha Del Mantenimiento", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Lugar (nombre Del Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_clase_mantenimiento, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_fecha_manteniminto, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_lugar_mantenimiento, 'L,R,B', 0, 'L');

    $pdf->Ln();
    $pdf->Cell(65, 4, "Precio De La Mano De Obra (Total)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Precio De Los Repuestos (Total)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Cantidad De Repuestos (Total)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_precio_mano_obra_total, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_precio_repuestos_total, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_cantidad_repuestos, 'L,R,B', 0, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "MECANICO RESPONSABLE", 0, 0, 'C');

    $pdf->Ln();
    $image0 = (ROOT . $p_foto_perfil);
    $pdf->Cell(60, 20, $pdf->Image($image0, $pdf->GetX() + 72, $pdf->GetY(), 50, 50), 0, 0, 'L', false);

    $pdf->Ln(55);
    $pdf->Cell(65, 4, "Nombre Completo (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Documento (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Tarjeta Profesional (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_nombre_mecanico, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_documento_mecanico, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_tarjeta_profesional_mecanico, 'L,R,B', 0, 'L');
    $pdf->Ln();
    $pdf->Cell(65, 4, "Telefono (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Direccion (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Correo (Mecanico)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_telefono_mecanico, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_direccion_mecanico, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_correo_mecanico, 'L,R,B', 0, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "DATOS DEL TALLER RESPONSABLE DEL MANTENIMIENTO", 0, 0, 'C');

    $pdf->Ln(5);
    $pdf->Cell(65, 4, "Nombre (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "NIT / CC (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Ciudad (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_nombre_taller, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_documento_taller, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_ciudad_taller, 'L,R,B', 0, 'L');
    $pdf->Ln();
    $pdf->Cell(65, 4, "Telefono (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Direccion (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Cell(65, 4, "Correo (Taller)", 'L,R,T', 0, 'L', true);
    $pdf->Ln();
    $pdf->Cell(65, 4, $p_telefono_taller, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_direccion_taller, 'L,R,B', 0, 'L');
    $pdf->Cell(65, 4, $p_correo_taller, 'L,R,B', 0, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "DESCRIPCION DE LOS DAÑOS Y TRABAJOS A REALIZAR", 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->MultiCell(195, 4, $p_descripcion_danos_proceso_realizar, 1, "L", false);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "REPUESTOS A UTILIZAR Y/O CONSUMIBLES", 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->MultiCell(195, 4, $p_repuestos_utilizar, 1, "L", false);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(97.5, 4, "FECHA Y HORA DE INICIO DE LA REPARACIÓN", 1, 0, 'C', true);
    $pdf->Cell(97.5, 4, "FECHA Y HORA DE TERMINACION DE LA REPARACIÓN", 1, 0, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(97.5, 4, $p_fecha_hora_inicio_reparacion . "  " . $hora_mantenimiento_inicio, 1, 0, 'C');
    $pdf->Cell(97.5, 4, $p_fecha_hora_final_reparacion . "  " . $hora_mantenimiento_fin, 1, 0, 'C');

    $pdf->Ln(40);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "FOTOS ANTES DE REPARAR", 0, 0, 'C', true);

    //fotos antes de reparar
    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 7) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "FOTOS REPUESTOS", 0, 0, 'C', true);

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "DAÑADOS", 0, 0, 'C');

    //repuestos dañados

    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));
        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 2) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "NUEVOS", 0, 0, 'C');

    //repuestos nuevos

    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 3) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "FOTOS DESPUES DE REPARAR", 0, 0, 'C', true);

    //despues de reparar

    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 4) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "PROCEDIMIENTO REALIZADO", 0, 0, 'C');
    $pdf->Ln(7);
    $pdf->MultiCell(195, 4, $p_procedimiento_realizado, 1, "L", false);

    $pdf->Ln(25);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "PRECIO Y UNIDADES DE LOS REPUESTOS", 0, 0, 'C', true);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(65, 4, "NOMBRE DEL REPUESTO", 1, 0, 'C', true);
    $pdf->Cell(65, 4, "CANTIDAD REPUESTO", 1, 0, 'C', true);
    $pdf->Cell(65, 4, "PRECIO", 1, 0, 'C', true);

//precio y cantidades de repuestos
    if (strcmp($database->status(), "bien") == 0) {

        $RepuestoMantenimiento = new RepuestoMantenimiento($database->myconn);
        $repuestos_array = $RepuestoMantenimiento->getRepuestoMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            $pdf->Ln();
            $pdf->Cell(65, 4, $value['nombre_repuesto'], 1, 0, 'C');
            $pdf->Cell(65, 4, $value['cantidad_repuesto'], 1, 0, 'C');
            $pdf->Cell(65, 4, "$ " . $value['precio_repuesto'], 1, 0, 'C');

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "FOTOS DE LAS FACTURAS Y/O RECIBOS DE LOS REPUESTOS", 0, 0, 'C');

    //facturas repuestos

    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 5) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "FOTOS DE LAS FACTURAS Y/O RECIBOS DE LA MANO DE OBRA", 0, 0, 'C');

    //factura mano de obra
    if (strcmp($database->status(), "bien") == 0) {

        $FotosMantenimiento = new FotosMantenimiento($database->myconn);
        $repuestos_array = $FotosMantenimiento->getFotosMantenimiento(
            array(
                'TYPE' => 'ID_VEHICULO',
                'VALUE' => $GLOBAL_ID_VEHICULO,

            ));

        foreach ($repuestos_array as $key => $value) {

            if ($value['id_categoria'] == 6) {
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell(100, 4, "DESCRIPCION", 1, 0, 'C', true);

                $pdf->Ln();
                $pdf->Cell(100, 4, (puntos_smart($value['descripcion'], 100, 63)), 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "USUARIO QUE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['usuario'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 4, "FECHA Y HORA EN QUE SE TOMO LA FOTO", 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->Cell(100, 4, $value['fecha'], 0, 0, 'C');
                $pdf->Ln();
                $pdf->Cell(100, 26, " ", 0, 0, 'C');
                $image5 = (ROOT . $value['fotos']);
                $pdf->Cell(90, 26, $pdf->Image($image5, $pdf->GetX(), $pdf->GetY() - 24, 95, 50), 0, 0, 'L', false);

                $pdf->Ln(30);
            }

        }
    } else {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 30);
        $pdf->Cell(0, 4, " ", 0, 1, 'C');
        $pdf->MultiCell(0, 5, "", 0, 'C', 0);
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "OBSERVACIONES Y/O RECOMENDACIÓNES", 0, 0, 'C');
    $pdf->Ln(7);
    $pdf->MultiCell(195, 4, $p_observaciones_recomendaciones, 1, "L", false);

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(195, 4, "firma DEL MECANICO RESPONSABLE", 0, 0, 'C');

    $pdf->Ln(10);
    $image14 = (ROOT . $p_firma_conductor);
    $pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() + 58, $pdf->GetY(), 80, 40), 0, 0, 'L', false);

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}