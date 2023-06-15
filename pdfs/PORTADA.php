<?php

/*
$('body').delegate('#form_3_dialog_input', 'click', function() {
input_autocomplete_no_save("#form_3_dialog_input","#form_3_dialog_select","marcas/modelo/buscar_marcas.php");
});*/
/*******************************************************************************
 *PORTADA                                                                       *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2021-10-13                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

// CLASES SQL






$datos_vehiculo_array = array();

$p_placa = "";
$p_nombre_empresa =  "";
$p_documento_empresa =  "";


// # Traer datos vehiculo

if (strcmp($database->status(), "bien") == 0) {

    $Datos_Vehiculo = new DatosVehiculo($database->myconn);
    $datos_vehiculo_array = $Datos_Vehiculo->getDatosVehiculo($GLOBAL_ID_VEHICULO);

    foreach ($datos_vehiculo_array as $key => $value) {


        $p_placa = $value['placa'];
        $p_nombre_empresa = $value['empresa_tarjeta_operacion'];
        $p_documento_empresa = $value['nit'];

    }


} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}


$pdf = new PDF("P", "mm", array(215.9, 330.2));

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 20, " ", 0, 1, 'C');

$pdf->Ln(0);

$image1 = (ROOT . "/images/qr_img.png");
$pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
$image2 = (ROOT . "/images/vector_previ.png");
$pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 40);
$pdf->Cell(195, 6, "HOJA DE VIDA", 0, 0, 'C');

$pdf->Ln(30);
$pdf->Cell(195, 6, "VEHICULAR", 0, 0, 'C');

$pdf->Ln(70);
$pdf->SetFont('Arial', 'B', 60);
$pdf->Cell(195, 6, $p_placa, 0, 0, 'C');

$pdf->Ln(60);
$pdf->SetFont('Arial', 'B', 30);
$pdf->Cell(195, 6, $p_nombre_empresa, 0, 0, 'C');

$pdf->Ln(30);
$pdf->Cell(195, 6, $p_documento_empresa, 0, 0, 'C');

$pdf->Ln(50);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(195, 6, "NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S", 0, 0, 'C');


// $pdf->Output('I', 'pdfs/PORTADA HOJA DE VIDA' . ' ' . $p_placa . '.pdf');