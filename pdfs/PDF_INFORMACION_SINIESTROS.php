<?php

/*******************************************************************************
 * SINIESTROS VEHICULO                                                          *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2021-10-14                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

$pdf->SetTextColor(0, 0, 0);

$habeas_data_array = array();
$datos_siniestro_array = array();

$p_placa = "";
$p_nombre_conductor = "";
$p_fecha = "";
$p_firma = "/images/firma.png";
$p_tipo_siniestro = "";
$p_fecha_siniestro = "";
$p_hora_siniestro = "";
$p_departamento_siniestro = "";
$p_ciudad_siniestro = "";
$p_lugar_siniestro = "";
$p_heridos = "";
$p_muertos = "";
$p_vehiculos_implicados = "";
$p_nombre_agente_transito = "";
$p_telefono_agente_transito = "";
$p_correo_agente_transito = "";
$descripcion_siniestro ="";
$p_placa_implicado = "";
$p_marca_implicado = "";
$p_modelo_implicado = "";
$p_nombre_implicado = "";
$p_telefono_implicado = "";
$p_direccion_implicado = "";
$p_correo_implicado = "";
$p_aseguradora_implicado = "";
$p_telefono_aseguradora_implicado = "";
$p_tipo_poliza_implicado = "";
$p_aseguradora_implicado = "";
$p_fecha_expedicion_poliza_implicado = "";
$p_fecha_vencimiento_poliza_implicado = "";
$p_nombre_testigo_siniestro = "";
$p_telefono_testigo_siniestro = "";
$p_direccion_testigo_siniestro = "";
$p_correo_testigo_siniestro = "";
$p_foto_siniestro_1 = "/images/sin_imagen.png";
$p_foto_siniestro_2 = "/images/sin_imagen.png";
$p_foto_siniestro_3 = "/images/sin_imagen.png";
$p_foto_siniestro_4 = "/images/sin_imagen.png";
$p_firma_conductor = "/images/firma.png";




if (strcmp($database->status(), "bien") == 0) {

    $SiniestroVehiculo = new SiniestroVehiculo($database->myconn);
    $datos_siniestro_array = $SiniestroVehiculo->getSiniestroVehiculo(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            'LIMITE' => '5',

        ));

    foreach ($datos_siniestro_array as $key => $value) 
    {


        $pdf->AddPage('', '', '', array(20, 250, 'H O J A  D E  V I D A', 45,));
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

        $pdf->MultiCell(195, 4, $value['habeas_data'], 0, 'J', 0);


        $pdf->Ln(-2);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195, 20, "NOMBRE Y FIRMA DEL EMPLEADO", 0, 1, 'C');

        $pdf->Ln(-3);
        $image15 = (ROOT . $value['firma_habeas']);
        $pdf->Cell(60, 20, $pdf->Image($image15, $pdf->GetX() + 55, $pdf->GetY() - 3, 70, 25), 0, 0, 'L', false);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(195, 20, "___________________________________", 0, 1, 'C');
        $pdf->Ln(-10);
        $pdf->Cell(195, 20, $value['nombre_completo'] . " " . $value['fecha_hora_habeas'], 0, 1, 'C');


        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetXY($pdf->GetX() + 25, 1000);
        $pdf->MultiCell(150, 4, "NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S", 0, 'C', 0);



        $pdf->Ln(-5);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 20, "INFORMACIÓN DE SINIESTROS", 0, 1, 'C');

        $pdf->Ln(0);

        $image1 = (ROOT . "/images/qr_img.png");
        $pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
        $image2 = (ROOT . "/images/vector_previ.png");
        $pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

        $pdf->Ln(10);
        $pdf->SetFillColor(213, 213, 213);
        $pdf->SetFont('Arial', 'B', 50);
        $pdf->Cell(195, 4, $value['placa'], 0, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Tipo De Siniestro", 0, 0, 'C', true);
        $pdf->Cell(65, 4, "Fecha Del Siniestro", 0, 0, 'C', true);
        $pdf->Cell(65, 4, "Hora Aprox. Siniestro", 0, 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['tipo_siniestro'], 0, 0, 'C');
        $pdf->Cell(65, 4, $value['fecha'], 0, 0, 'C');
        $pdf->Cell(65, 4, $value['hora'], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Departamento Del Siniestro", 0, 0, 'C', true);
        $pdf->Cell(65, 4, "Ciudad Del Siniestro", 0, 0, 'C', true);
        $pdf->Cell(65, 4, "Lugar Del Siniestro", 0, 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['departamento'], 0, 0, 'C');
        $pdf->Cell(65, 4, $value['ciudad'], 0, 0, 'C');
        $pdf->Cell(65, 4, $value['lugar'], 0, 0, 'C');

        if( $value['heridos'] == 2)
        {
            $p_heridos = "NO";
        }
        else
        {
            $p_heridos = "SI";
        }

        if($p_muertos = $value['muertos'] == 2)
        {
            $p_muertos = "NO";
        }
        else
        {
            $p_muertos = "SI";
        }

        if( $p_vehiculos_implicados = $value['vehiculo_implicado'] == 2)
        {
            $p_vehiculos_implicados = "NO";
        }
        else
        {
            $p_vehiculos_implicados = "SI";
        }
        
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "HERIDOS SI/NO", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "MUERTOS SI/NO", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "VEHICULOS IMPLICADOS SI/NO", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $p_heridos, 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $p_muertos, 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $p_vehiculos_implicados, 'L,B,R', 0, 'C');

        $pdf->Ln(10);
        $pdf->Cell(195, 4, "DATOS DEL AGENTE DE TRANSITO", 0, 0, 'C', true);

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Nombre", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Telefono ", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Correo", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['nombre_agente'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['telefono_agente'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['correo_agente'], 'L,B,R', 0, 'C');

        $pdf->Ln(7);
        $pdf->Cell(195, 4, "DESCRIPCIÓN DEL SINIESTRO", 0, 0, 'C', true);
        $pdf->Ln(7);
        $pdf->MultiCell(195, 4, $value['descripcion'], 1, "L", false);

        $pdf->Ln(5);
        $pdf->Cell(195, 4, "DATOS DEL VEHICULO IMPLICADO", 0, 0, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Placa", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Marca", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Modelo", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['placa_implicado'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['marca'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['modelo'], 'L,B,R', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Nombre", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Telefono ", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Direccion", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['nombre'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['telefono'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['direccion'], 'L,B,R', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Correo", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Aseguradora", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Telefono Aseguradora", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['correo'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['aseguradora'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['telefono_aseguradora'], 'L,B,R', 0, 'C');


        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 4, "POLIZAS DEL VEHICULO IMPLICADO", 0, 0, 'C', true);

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(45, 4, "Tipo De Poliza", 'L,T,', 0, 'L', true);
        $pdf->Cell(45, 4, "Aseguradora", 'L,T,R', 0, 'L', true);
        $pdf->Cell(47, 4, "Fecha De Expedicion Poliza", 'L,T,R', 0, 'L', true);
        $pdf->Cell(58, 4, "Fecha De Vencimiento Poliza", 'L,T,R', 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(45, 4, $value['tipo_poliza'], 'L,R,B', 0, 'R');
        $pdf->Cell(45, 4, $value['aseguradora_poliza'], 'L,R,B', 0, 'R');
        $pdf->Cell(47, 4, $value['expedicion_poliza'], 'L,R,B', 0, 'R');
        $pdf->Cell(58, 4, $value['vencimiento_poliza'], 'L,R,B', 0, 'R');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 4, "TESTIGOS SINIESTRO", 0, 0, 'C', true);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, "Nombre", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Telefono ", 'L,T,R', 0, 'C', true);
        $pdf->Cell(65, 4, "Direccion", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(65, 4, $value['nombre_testigo'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['telefono_testigo'], 'L,B,R', 0, 'C');
        $pdf->Cell(65, 4, $value['direccion_testigo'], 'L,B,R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(195, 4, "Correo", 'L,T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(195, 4, $value['correo_testigo'], 'L,B,R', 0, 'C');

       
        $pdf->Ln(10);
        $pdf->Cell(195, 4, "FOTOS SINIESTRO", 0, 0, 'C', true);
        $pdf->Ln(10);
        $image0 = (ROOT . $value['foto_1']);
        $pdf->Cell(60, 20, $pdf->Image($image0, $pdf->GetX(), $pdf->GetY(), 95, 50), 0, 0, 'L', false);
        $image5 = (ROOT . $value['foto_2']);
        $pdf->Cell(60, 20, $pdf->Image($image5, $pdf->GetX() + 40, $pdf->GetY(), 95, 50), 0, 0, 'L', false);

        $pdf->Ln(53);
        $image0 = (ROOT . $value['foto_3']);
        $pdf->Cell(60, 20, $pdf->Image($image0, $pdf->GetX(), $pdf->GetY(), 95, 50), 0, 0, 'L', false);
        $image5 = (ROOT . $value['foto_4']);
        $pdf->Cell(60, 20, $pdf->Image($image5, $pdf->GetX() + 40, $pdf->GetY(), 95, 50), 0, 0, 'L', false);
        $pdf->Ln(60);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(195, 4, "FIRMA CONDUCTOR", 0, 0, 'C');

        $pdf->Ln(10);
        $image14 = (ROOT . $value['firma']);
        $pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX()+58, $pdf->GetY(), 80, 40), 0, 0, 'L', false);

        
    }

// var_dump($datos_siniestro_array);

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, " sin datos", 0, 'C', 0);
}







