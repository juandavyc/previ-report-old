<?php

/*******************************************************************************
 * INFORMACION DEL CONDUCTOR                                                    *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2020-12-21                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

$pdf->AddPage('', '', '', array(20, 250, 'H O J A  D E  V I D A', 45,));
$pdf->SetTextColor(0, 0, 0);

$habeas_data_array = array();
$datos_conductor_array = array();
$datos_empresa_conductor_array = array();
$comparendo_conductor_array = array();
$documentos_conductor_array = array();
$certificado_empresa_conductor_array = array();
$vehiculo_conductor_array = array();
$examen_conductor_array = array();
$curso_conductor_array = array();
$capacitacion_conductor_array = array();
$incapacidad_conductor_array = array();





$p_placa = "ABC123";

$p_fecha = "";
$p_firma = "/images/firma.png";

$p_nombre_conductor = "";

$p_nombre_conductor = "";
$p_documento_conductor = "";
$p_tipo_sangre = "";
$p_direccion = "";
$p_telefono = "";
$p_celular = "";
$p_whatsapp = "";
$p_correo_electronico = "";
$p_ciudad = "";
$p_departamento = "";
$p_caso_emergencia = "";
$p_telefono_caso_emergencia = "";
$p_parentesto_caso_emergencia = "";
$p_eps = "";
$p_fecha_afiliacion_eps = "";
$p_estado_eps = "";
$p_fondo_pension = "";
$p_fecha_afiliacion_pension = "";
$p_estado_pension = "";
$p_arl = "";
$p_fecha_afiliacion_arl = "";
$p_estado_arl = "";
$p_foto_perfil = "/images/sin_imagen.png";
$p_firma_conductor = "/images/firma.png";

$p_nombre_empresa  = "";
$p_documento_empresa  = "";
$p_direccion_empresa  = "";
$p_telefono_empresa  = "";
$p_correo_empresa  = "";
$p_ciudad_empresa  = "";
$p_departamento_empresa  = "";
$p_tiempo_compañia = "";
$p_fecha_ingreso_compañia = "";
$p_tipo_contrato  = "";
$p_fecha_vencimiento_contrato  = "";


$p_licencia_conduccion_numero = "";
$p_categoria_licencia = "";
$p_fecha_expedicion_licencia = "";
$p_fecha_vencimiento_licencia = "";
$p_restricciones_conductor = "";
$p_licencia_conduccion1 = "/images/sin_imagen.png";
$p_licencia_conduccion2 = "/images/sin_imagen.png";
$p_tipo_comparendo = "";
$p_fecha_comparendo = "";
$p_motivo_comparendo = "";



$p_nombre_certificado = "";
$p_fecha_certificado = "";
$p_fecha_vencimiento_certificado = "";
$p_numero_vehiculo = "";
$p_fecha_asignacion = "";
$p_nombre_entidad_examen = "";
$p_tipo_examen = "";
$p_recomendaciones_examen = "";
$p_fecha_examen = "";
$p_fecha_vencimiento_examen = "";
$p_nombre_entidad_curso = "";
$p_nombre_curso = "";
$p_logro_curso = "";
$p_fecha_expedicion_curso = "";
$p_fecha_vencimiento_curso = "";
$p_nombre_entidad_capacitacion = "";
$p_nombre_capacitacion = "";
$p_tipo_capacitacion = "";
$p_duracion_capacitacion = "";
$p_fecha_capacitacion = "";
$p_fecha_refuerzo_capacitacion = "";
$p_no_dias_incapacidad = "";
$p_comcepto_incapacidad = "";
$p_eps_incapacidad = "";
$p_arl_incapacidad = "";
$p_foto_incapacidad = "/images/sin_imagen.png";
$p_fecha_ingreso_compania ="";
$id ="";








$pdf->Ln(-10);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(195, 20, "AUTORIZACIÓN PARA EL TRATAMIENTO", 0, 1, 'C');
$pdf->Ln(-10);
$pdf->Cell(195, 20, "DE DATOS PERSONALES", 0, 1, 'C');

$image1 = (ROOT . "/images/qr_img.png");
$pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
$image2 = (ROOT . "/images/vector_previ.png");
$pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

// # Traer habeas data

if (strcmp($database->status(), "bien") == 0) {

    $HabeasDataConductor = new HabeasDataConductor($database->myconn);
    $habeas_data_array = $HabeasDataConductor->getHabeasDataConductor(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            'LIMITE'=> '1',
           

        ));

    foreach ($habeas_data_array as $key => $value) {
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);

        $pdf->MultiCell(195, 4, $value['habeas_data'], 0, 'J', 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);

        $pdf->Ln(-2);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195, 20, "NOMBRE Y FIRMA DEL EMPLEADO", 0, 1, 'C');

        $pdf->Ln(-3);
        $image15 = (ROOT . $value['firma_habeas']);
        $pdf->Cell(60, 20, $pdf->Image($image15, $pdf->GetX() + 62, $pdf->GetY() - 3, 70, 25), 0, 0, 'L', false);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(195, 20, "___________________________________", 0, 1, 'C');
        $pdf->Ln(-10);
        $pdf->Cell(195, 20, $value['nombre_habeas'] . "   " . $value['fecha_habeas'], 0, 1, 'C');

    }


} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(5);
$pdf->SetFont('Arial','',7);
$pdf-> SetTextColor( 255, 0, 0 );
$pdf->SetXY($pdf->GetX() +25 , 1000); 
$pdf->MultiCell(150,4,"NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S",0,'C',0); 

$pdf->Ln(-5);
$pdf-> SetTextColor(0,0,0);


if (strcmp($database->status(), "bien") == 0) {

    $DatosConductor = new DatosConductor($database->myconn);
    $datos_conductor_array = $DatosConductor->getDatosConductor(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,  
            'LIMITE'=> '1',         

        ));


    foreach ($datos_conductor_array as $key => $value) {
        $id = $value['id'];
        $p_nombre_conductor = $value['nombre'];
        $p_documento_conductor = $value['documento'];
        $p_tipo_sangre = $value['sangre'];
        $p_direccion = $value['direccion'];
        $p_telefono = $value['telefono'];
        $p_celular = $value['celular'];
        $p_whatsapp = $value['whatsapp'];
        $p_correo_electronico = $value['correo'];
        $p_ciudad = $value['ciudad'];
        $p_departamento = $value['departamento'];
        $p_caso_emergencia = $value['emergencia'];
        $p_telefono_caso_emergencia = $value['telefono_emergencia'];
        $p_parentesto_caso_emergencia = $value['parentesco'];
        $p_eps = $value['eps'];
        $p_fecha_afiliacion_eps = $value['fecha_eps'];
        $p_estado_eps = $value['estado_eps'];
        $p_fondo_pension = $value['fondo'];
        $p_fecha_afiliacion_pension = $value['fecha_fondo'];
        $p_estado_pension = $value['estado_fondo'];
        $p_arl = $value['arl'];
        $p_fecha_afiliacion_arl = $value['fecha_arl'];
        $p_estado_arl = $value['estado_arl'];
        $p_foto_perfil = $value['foto'];
        $p_firma_conductor = $value['firma'];
    }



} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}




$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 20, "INFORMACIÓN DEL CONDUCTOR", 0, 1, 'C');

$pdf->Ln(0);

$image1 = (ROOT . "/images/qr_img.png");
$pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
$image2 = (ROOT . "/images/vector_previ.png");
$pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(80, 6, "DATOS PERSONALES DEL CONDUCTOR", 0, 'L');

$pdf->Ln(6);
$pdf->SetFillColor(213, 213, 213);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(90, 4, "Nombre Completo", 'L,T,', 0, 'L', true);
$pdf->Cell(40, 4, "Documento de identidad", 'L,T,R', 0, 'L', true);
$pdf->Cell(30, 4, "Tipo De Sangre (RH)", 'L,T,R', 0, 'L', true);

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 4, $p_nombre_conductor, 'L,R, B', 0, 'R');
$pdf->Cell(40, 4, $p_documento_conductor, 'L,R,B', 0, 'L');
$pdf->Cell(30, 4, $p_tipo_sangre, 'L,R,B', 0, 'L');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(79, 4, "Dirección", 'L,T,', 0, 'L', true);
$pdf->Cell(27, 4, "Telèfono", 'L,T,', 0, 'L', true);
$pdf->Cell(27, 4, "Celular", 'L,T,', 0, 'L', true);
$pdf->Cell(27, 4, "Whatsapp", 'L,T,R', 0, 'L', true);
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(79, 4, $p_direccion, 'L,R,B', 0, 'R');
$pdf->Cell(27, 4, $p_telefono, 'L,R, B', 0, 'R');
$pdf->Cell(27, 4, $p_celular, 'L,R,B', 0, 'R');
$pdf->Cell(27, 4, $p_whatsapp, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(68, 4, "Correo Electronico", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Ciudad", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Departamento", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68, 4, $p_correo_electronico, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_ciudad, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_departamento, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(68, 4, "En Caso De Emergencia Llamar a (Nombre)", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Telefono", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Parentesco", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68, 4, $p_caso_emergencia, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_telefono_caso_emergencia, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_parentesto_caso_emergencia, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(68, 4, "EPS", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Fecha De Afiliacion", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Estado", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68, 4, $p_eps, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_fecha_afiliacion_eps, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_estado_eps, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(68, 4, "Fondo De Pension", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Fecha De Afiliacion", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Estado", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68, 4, $p_fondo_pension, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_fecha_afiliacion_pension, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_estado_pension, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(68, 4, "ARL", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Fecha De Afiliacion", 'T,L', 0, 'L', true);
$pdf->Cell(46, 4, "Estado", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(68, 4, $p_arl, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_fecha_afiliacion_arl, 'L,R,B', 0, 'R');
$pdf->Cell(46, 4, $p_estado_arl, 'L,R,B', 0, 'R');
$pdf->Ln();

//var_dump($p_foto_perfil);
$image3 = (ROOT . $p_foto_perfil);
$pdf->Cell(60, 20, $pdf->Image($image3, $pdf->GetX() + 162, $pdf->GetY() - 55, 35, 45), 0, 0, 'L', false);

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "DOCUMENTOS DEL CONDUCTOR", 0, 0, 'C');



    //licencias

if (strcmp($database->status(), "bien") == 0) {

    $DocumentosConductor = new DocumentosConductor($database->myconn);
    $documentos_conductor_array = $DocumentosConductor->getDocumentosConductor($id);

    foreach ($documentos_conductor_array as $key => $value) {

     $pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 8);
     $pdf->Cell(68, 4, "Licencia De Conduccion (Numero)", 'T,L', 0, 'L', true);
     $pdf->Cell(46, 4, "Categoria(as)", 'T,L', 0, 'L', true);
     $pdf->Cell(46, 4, "Fecha de expedicion ", 'T,L,R', 0, 'L', true);
     $pdf->Cell(35, 4, "Fecha de vencimiento ", 'T,L,R', 0, 'L', true);

     $pdf->Ln();
     $pdf->SetFont('Arial', '', 8);
     $pdf->Cell(68, 4, $value['numero'], 'L,R,B', 0, 'R');
     $pdf->Cell(46, 4, (puntos_smart($value['categorias'],23,23)),'L,R,B', 0, 'R');
     $pdf->Cell(46, 4, $value['expedicion'], 'L,R,B', 0, 'R');
     $pdf->Cell(35, 4, $value['vencimiento'], 'L,R,B', 0, 'R');
     $pdf->Ln();
     $pdf->SetFont('Arial', 'B', 8);
     $pdf->Cell(68, 4, "RESTRICCIONES DEL CONDUCTOR", 1, 0, 'L', true);
     $pdf->Cell(127, 4, $value['restricciones'], 1, 0, 'L');

     $pdf->Ln();
     $image4 = (ROOT . $value['delantera']);
     $pdf->Cell(60, 20, $pdf->Image($image4, $pdf->GetX() + 10, $pdf->GetY() + 5, 80, 50), 0, 0, 'L', false);

     $image5 = (ROOT . $value['trasera']);
     $pdf->Cell(60, 20, $pdf->Image($image5, $pdf->GetX() + 50, $pdf->GetY() + 5, 80, 50), 0, 0, 'L', false);
     $pdf->Ln(50);
 }



} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "COMPARENDOS, MULTAS Y/O SANCIONES DEL CONDUCTOR", 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, "Tipo", 1, 0, 'C', true);
$pdf->Cell(20, 4, "Fecha", 1, 0, 'C', true);
$pdf->Cell(145, 4, "Motivo", 1, 0, 'C', true);

     //comparendos

if (strcmp($database->status(), "bien") == 0) {

    $ComparendoConductor = new ComparendoConductor($database->myconn);
    $comparendo_conductor_array = $ComparendoConductor->getComparendoConductor($id);
    foreach ($comparendo_conductor_array as $key => $value) {

       $pdf->Ln();
       $pdf->SetFont('Arial', '', 8);
       $pdf->Cell(30, 4, $value['tipo'], 1, 0, 'C');
       $pdf->Cell(20, 4, $value['fecha'], 1, 0, 'C');
       $pdf->Cell(145, 4, $value['motivo'], 1, 0, 'L');
   }



} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}


$id_empresa ="";

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "DATOS DE LA EMPRESA DONDE SE ENCUENTRA VINCULADO", 0, 0, 'C');

 //datos empresa

if (strcmp($database->status(), "bien") == 0) {

    $DatosEmpresaConductor = new DatosEmpresaConductor($database->myconn);
    $datos_empresa_conductor_array = $DatosEmpresaConductor->getDatosEmpresaConductor($id);
    foreach ($datos_empresa_conductor_array as $key => $value) {

        $p_nombre_empresa =  $value['empresa'];
        $p_documento_empresa = $value['nit_empresa'];
        $p_direccion_empresa = $value['direccion_empresa'];
        $p_telefono_empresa = $value['telefono_empresa'];
        $p_correo_empresa = $value['correo_empresa'];
        $p_ciudad_empresa = $value['ciudad_empresa'];
        $p_departamento_empresa = $value['departamento_empresa'];
        $p_tiempo_compañia = $value['tiempo_en_empresa'];
        $p_fecha_ingreso_compania = $value['ingreso_empresa'];
        $p_tipo_contrato = (puntos_smart($value['tipo_contrato'],23,23));
        $p_fecha_vencimiento_contrato = $value['vencimiento_empresa'];
        $id_empresa = $value['empresa_id'];

    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(97.5, 4, "Nombre De La Empresa", 'T,L', 0, 'L', true);
$pdf->Cell(97.5, 4, "NIT", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(97.5, 4, $p_nombre_empresa, 'L,R,B', 0, 'R');
$pdf->Cell(97.5, 4, $p_documento_empresa, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, "Correo (Empresa)", 'T,L', 0, 'L', true);
$pdf->Cell(45, 4, "Telefono (Empresa)", 'T,L', 0, 'L', true);
$pdf->Cell(80, 4, "Direccion (Empresa)", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 4, $p_correo_empresa, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_telefono_empresa, 'L,R,B', 0, 'R');
$pdf->Cell(80, 4, $p_direccion_empresa, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, "Departamento (Empresa)", 'T,L', 0, 'L', true);
$pdf->Cell(45, 4, "Ciudad (Empresa)", 'T,L', 0, 'L', true);
$pdf->Cell(80, 4, "Tiempo En La Compañia", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 4, $p_departamento_empresa, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_ciudad_empresa, 'L,R,B', 0, 'R');
$pdf->Cell(80, 4, $p_tiempo_compañia, 'L,R,B', 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, "Fecha De Ingreso a La Compañia", 'T,L', 0, 'L', true);
$pdf->Cell(45, 4, "Tipo De Contrato", 'T,L', 0, 'L', true);
$pdf->Cell(80, 4, "Fecha De Vencimiento Contrato", 'T,L,R', 0, 'L', true);
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 4, $p_fecha_ingreso_compania, 'L,R,B', 0, 'R');
$pdf->Cell(45, 4, $p_tipo_contrato, 'L,R,B', 0, 'R');
$pdf->Cell(80, 4, $p_fecha_vencimiento_contrato, 'L,R,B', 0, 'R');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "CERTIFICADOS Y/O RESOLUCIONES DE LA EMPRESA DONDE SE ENCUENTRA VINCULADO", 0, 0, 'C');

$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 4, "Nombre Certificado y/o Resolucion", 1, 0, 'L', true);
$pdf->Cell(75, 4, "Fecha Certificado y/o Resolucion", 1, 0, 'L', true);
$pdf->Cell(50, 4, "Fecha De Vencimiento (SI APLICA)", 1, 0, 'L', true);


 //certificados empresa

if (strcmp($database->status(), "bien") == 0) {

    $CertificadoEmpresaConductor = new CertificadoEmpresaConductor($database->myconn);
    $certificado_empresa_conductor_array = $CertificadoEmpresaConductor->getCertificadoEmpresaConductor($id_empresa);

    foreach ($certificado_empresa_conductor_array as $key => $value) {


        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(70, 4, $value['nombre'], 1, 0, 'R');
        $pdf->Cell(75, 4, $value['fecha_expedicion'], 1, 0, 'R');
        $pdf->Cell(50, 4, $value['fecha_vencimiento'], 1, 0, 'R');

    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "VEHICULOS ASIGNADOS A ESTE CONDUCTOR", 0, 0, 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40.5, 4, "Placa", 1, 0, 'L', true);
$pdf->Cell(97.5, 4, "Numero De Vehiculo", 1, 0, 'L', true);
$pdf->Cell(57.5, 4, "Fecha de Asignacion", 1, 0, 'L', true);


 //vehiculos conductor

if (strcmp($database->status(), "bien") == 0) {

    $VehiculoConductor = new VehiculoConductor($database->myconn);
    $vehiculo_conductor_array = $VehiculoConductor->getVehiculoConductor($id);

    foreach ($vehiculo_conductor_array as $key => $value) {

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(40.5, 4, $value['placa'], 'L,R,B', 0, 'R');
        $pdf->Cell(97.5, 4, $value['numero'], 'L,R,B', 0, 'R');
        $pdf->Cell(57.5, 4, $value['fecha'], 'L,R,B', 0, 'R');
    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "EXAMENES OCUPACIONALES DEL CONDUCTOR", 0, 0, 'C');

 //examenes conductor

if (strcmp($database->status(), "bien") == 0) {

    $ExamenConductor = new ExamenConductor($database->myconn);
    $examen_conductor_array = $ExamenConductor->getExamenConductor($id);
    foreach ($examen_conductor_array as $key => $value) {

        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 4, "NOMBRE DE LA ENTIDAD QUE REALIZA EL EXAMEN", 'R,T,L', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(195, 4, $value['entidad'], 'L,R,B', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(46, 4, "Tipo De Examen", 'T,L', 0, 'L', true);
        $pdf->Cell(68, 4, "Recomendaciones", 'T,L', 0, 'L', true);
        $pdf->Cell(46, 4, "Fecha de expedicion ", 'T,L,R', 0, 'L', true);
        $pdf->Cell(35, 4, "Fecha de vencimiento ", 'T,L,R', 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46, 4, $value['tipo_examen'], 'L,R,B', 0, 'R');
        $pdf->Cell(68, 4, $value['recomendacion'], 'L,R,B', 0, 'R');
        $pdf->Cell(46, 4, $value['expedicion'], 'L,R,B', 0, 'R');
        $pdf->Cell(35, 4, $value['vencimiento'], 'L,R,B', 0, 'R');

    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}




$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "CURSOS REALIZADOS POR EL CONDUCTOR", 0, 0, 'C');

//cursos conductor

if (strcmp($database->status(), "bien") == 0) {

    $CursoConductor = new CursoConductor($database->myconn);
    $curso_conductor_array = $CursoConductor->getCursoConductor($id);
    foreach ($curso_conductor_array as $key => $value) {

       $pdf->Ln(7);
       $pdf->SetFont('Arial', 'B', 8);
       $pdf->Cell(195, 4, "NOMBRE DE LA ENTIDAD DONDE REALIZO EL CURSO", 'R,T,L', 0, 'C', true);
       $pdf->Ln();
       $pdf->Cell(195, 4, $value['entidad'], 'L,R,B', 0, 'C');
       $pdf->Ln();
       $pdf->SetFont('Arial', 'B', 8);
       $pdf->Cell(68, 4, "Nombre Del Curso", 'T,L', 0, 'L', true);
       $pdf->Cell(46, 4, "Logro Obtenido", 'T,L', 0, 'L', true);
       $pdf->Cell(46, 4, "Fecha de expedicion ", 'T,L,R', 0, 'L', true);
       $pdf->Cell(35, 4, "Fecha de vencimiento ", 'T,L,R', 0, 'L', true);
       $pdf->Ln();
       $pdf->SetFont('Arial', '', 8);
       $pdf->Cell(68, 4, $value['nombre_curso'], 'L,R,B', 0, 'R');
       $pdf->Cell(46, 4, $value['logro'], 'L,R,B', 0, 'R');
       $pdf->Cell(46, 4, $value['expedicion'], 'L,R,B', 0, 'R');
       $pdf->Cell(35, 4, $value['vencimiento'], 'L,R,B', 0, 'R');

   }



} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "CAPACITACIONES RECIBIDAS POR EL CONDUCTOR", 0, 0, 'C');


//capacitaciones conductor

if (strcmp($database->status(), "bien") == 0) {

    $CapacitacionConductor = new CapacitacionConductor($database->myconn);
    $capacitacion_conductor_array = $CapacitacionConductor->getCapacitacionConductor($id);

    foreach ($capacitacion_conductor_array as $key => $value) {


        $pdf->Ln(7);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 4, "NOMBRE DE LA ENTIDAD QUE REALIZA LA CAPACITACION", 'R,T,L', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(195, 4, $value['entidad'], 'L,R,B', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(68, 4, "Nombre De La Capacitacion", 'T,L', 0, 'L', true);
        $pdf->Cell(40, 4, "Tipo De Capacitacion", 'T,L', 0, 'L', true);
        $pdf->Cell(30, 4, "Duracion (HORAS)", 'T,L', 0, 'L', true);
        $pdf->Cell(30, 4, "Fecha de Realizacion ", 'T,L,R', 0, 'L', true);
        $pdf->Cell(27, 4, "Fecha de Refuerzo ", 'T,L,R', 0, 'L', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(68, 4, $value['nombre'], 'L,R,B', 0, 'R');
        $pdf->Cell(40, 4, $value['tipo'], 'L,R,B', 0, 'R');
        $pdf->Cell(30, 4, $value['duracion'], 'L,R,B', 0, 'R');
        $pdf->Cell(30, 4, $value['expedicion'], 'L,R,B', 0, 'R');
        $pdf->Cell(27, 4, $value['vencimiento'], 'L,R,B', 0, 'R');

    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}



$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 6, "INCAPACIDADES DEL CONDUCTOR", 0, 0, 'C');

//incapacidad conductor

if (strcmp($database->status(), "bien") == 0) {

    $IncapacidadConductor = new IncapacidadConductor($database->myconn);
    $incapacidad_conductor_array = $IncapacidadConductor->getIncapacidadConductor($id);
    foreach ($incapacidad_conductor_array as $key => $value) {


        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(17, 4, "Nº De Dias", 1, 0, 'L', true);
        $pdf->Cell(70, 4, "Concepto", 1, 0, 'L', true);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(17, 4, $value['dias'], 1, 0, 'R');
        $pdf->Cell(70, 4, $value['concepto'], 1, 0, 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43.5, 4, "Nombre EPS", 1, 0, 'L', true);
        $pdf->Cell(43.5, 4, "Nombre ARL", 1, 0, 'L', true);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(43.5, 4, $value['eps'], 1, 0, 'R');
        $pdf->Cell(43.5, 4, $value['arl'], 1, 0, 'R');

        $image0 = (ROOT . $value['foto']);
        $pdf->Cell(60, 20, $pdf->Image($image0, $pdf->GetX() + 3, $pdf->GetY() - 12.1, 108, 50), 0, 0, 'L', false);
        $pdf->Ln(40);
    }

    

} else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}


$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "FIRMA CONDUCTOR", 0, 0, 'C');

$pdf->Ln(10);
$image14 = (ROOT . $p_firma_conductor);
$pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() +58, $pdf->GetY(), 100, 60), 0, 0, 'L', false);







