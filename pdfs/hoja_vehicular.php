<?php
include $_SERVER["DOCUMENT_ROOT"] . "/hoja_config.php";
require DOCUMENT_ROOT . '/fpdf/fpdf.php';

include DOCUMENT_ROOT . '/assets/php/hdv_database.php';
include DOCUMENT_ROOT . '/assets/php/hdv_resources.php';
// CLASES PDF
require DOCUMENT_ROOT . '/modulos/assets/clases/pdf/pdf.php';


// CLASES SQL
require DOCUMENT_ROOT . '/modulos/assets/clases/poliza/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/habeas_data_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/datos_vehiculo/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/certificado/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/solicitudes/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/fotos_vehiculo/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/datos_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/datos_empresa_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/comparendo_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/documentos_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/certificado_empresa_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/vehiculo_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/examen_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/curso_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/capacitacion_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/incapacidad_conductor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/siniestro_vehiculo/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/mantenimiento/supervisor/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/foto_mantenimiento/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/repuesto_mantenimiento/read.php';
require DOCUMENT_ROOT . '/modulos/assets/clases/preoperacional_vehiculo/read.php';

$GLOBAL_ID_VEHICULO = 0;
// $ID_CONDUCTOR = 0;
// pregunta si existe el id
if (!isset($_GET['id_vehiculo']) || strlen($_GET['id_vehiculo']) <= 0 ) 
{
    // id no existe
  $php_status_pdf = 1;   

} 

else
{
  $php_status_pdf = 2;
  $GLOBAL_ID_VEHICULO = encrypt($_GET['id_vehiculo'],2);


}


$database = new dbconnection();



$pdf = new PDF("P", "mm", array(215.9, 330.2));
$pdf->AliasNbPages();
$pdf->AddPage();



if ($php_status_pdf == 1) 
{
 $pdf->Ln(30);
 $pdf->SetFont('Arial', 'B', 30);
 $pdf->Cell(195, 20, "SIN DATOS PARA ESTE ID", 0, 1, 'C');

 $pdf->Ln(10);
 $pdf->SetFont('Arial', 'B', 50);
 $pdf->Cell(195, 20, "SIN DATOS", 0, 1, 'C');


}

// fin el id es incorrecto
// inicio pdf con resultados
else if ($php_status_pdf == 2) 
{

 $database->connect();

 if (isset($_GET['port']) && $_GET['port'] == true || isset($_GET['all']) && $_GET['all'] == true)
 {
   include_once '../pdfs/PORTADA.php';

}


if (isset($_GET['info']) && $_GET['info'] == true || isset($_GET['all']) && $_GET['all'] == true)
{
   include_once '../pdfs/PDF_INFORMACION_VEHICULO.php'; 
   include_once '../pdfs/PDF_INFORMACION_CONDUCTOR.php'; 

}


if (isset($_GET['con']) && $_GET['con'] == true || isset($_GET['all']) && $_GET['all'] == true)
{
   include_once '../pdfs/PDF_INFORMACION_CONDUCTOR.php'; 

}

if (isset($_GET['sin']) && $_GET['sin'] == true || isset($_GET['all']) && $_GET['all'] == true)
{
   include_once '../pdfs/PDF_INFORMACION_VEHICULO.php'; 
   include_once '../pdfs/PDF_INFORMACION_SINIESTROS.php'; 
   include_once '../pdfs/PDF_INFORMACION_CONDUCTOR.php';

}

if (isset($_GET['mant']) && $_GET['mant'] == true || isset($_GET['all']) && $_GET['all'] == true)
{
   include_once '../pdfs/PDF_INFORMACION_MANTENIMIENTO.php'; 

}


if (isset($_GET['pre']) && $_GET['pre'] == true || isset($_GET['all']) && $_GET['all'] == true)
{
   include_once '../pdfs/PDF_INFORMACION_PREOPERATIVOS.php'; 
}

$database->close();

}
$pdf->Output();
?>









