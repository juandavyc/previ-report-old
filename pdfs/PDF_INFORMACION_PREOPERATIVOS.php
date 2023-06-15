<?php

/*******************************************************************************
 * PREOPERATIVOS                                                                *
 *                                                                              *
 * VERSION:  1.0                                                                *
 * FECHA:    2021-10-20                                                         *
 * CREADOR:  YEFERSON DEVIA DIAZ                                                *
 *******************************************************************************/

$pdf->SetTextColor(0, 0, 0);
$datos_preoperacional_array= array();

$p_placa = " ";
$p_foto_perfil = "/images/sin_imagen.png";
$p_nombre_habeas = "";
$habeas_data = "";
$p_fecha_habeas = "";
$p_firma_habeas = "/images/firma.png";
$p_nombre_supervisor = "";
$p_documento_supervisor = "";
$p_nombre_empresa = "";
$p_documento_empresa = "";
$p_correo_empresa = "";
$p_telefono_empresa = "";
$p_direccion_empresa = "";
$p_departamento_empresa = "";
$p_ciudad_empresa = "";
$p_tiempo_compañia = "";
$p_fecha_ingreso_compania = "";
$p_tipo_contrato = "";
$p_fecha_vencimiento_contrato = "";
$p_nombre_certificao_empresa = "";
$p_fecha_certificao_empresa = "";
$p_fecha_vencimiento_certificado_empresa = "";
$p_nombre_conductor = "";
$p_documento_conductor = "";
$p_tipo_sangre = "";
$p_direccion = "";
$p_telefono = "";
$p_celular = "";
$p_whatsapp = "";
$p_correo = "";
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
$p_fecha_vencimiento_tarjeta_propiedad = "";
$p_entidad_expide_tarjeta_propiedad = "";
$p_fecha_vencimiento_rtm = "";
$p_entidad_expide_rtm = "";
$p_fecha_vencimiento_certificado_gases = "";
$p_entidad_expide_certificado_gases = "";
$p_fecha_vencimiento_fuec = "";
$p_entidad_expide_fuec = "";
$p_categoria_licencia = "";
$p_fecha_vencimiento_licencia = "";
$p_entidad_expide_licencia = "";
$p_tipo_poliza = "";
$p_fecha_vencimiento_poliza = "";
$p_entidad_expide_poliza = "";
$p_fecha_hora = "";
$p_foto_kilometraje = "/images/sin_imagen.png";
$p_foto_combustible = "/images/sin_imagen.png";
$p_observaciones_conductor = "";
$p_visto_supervisor = "";
$p_observaciones_supervisor = "";
$p_foto_vehiculo_salida = "/images/sin_imagen.png";
$p_foto_vehiculo_regreso = "/images/sin_imagen.png";
$firma_supervisor="/images/sin_imagen.png";





$datos=array();




if (strcmp($database->status(), "bien") == 0) {

    $PreoperacionalVehiculo = new PreoperacionalVehiculo($database->myconn);
    $datos_preoperacional_array = $PreoperacionalVehiculo->getPreoperacional(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            'LIMITE' => '5',         

        ));


    foreach ($datos_preoperacional_array as $key => $value) {


        $tarjeta_propiedad_vencimiento=$value['tarjeta_vencimiento'];
        $tarjeta_propiedad_entidad=$value['tarjeta_entidad'];
        $p_fecha_vencimiento_rtm =$value['vencimiento_rtm'];
        $p_entidad_expide_rtm =$value['entidad_rtm'];
        $p_fecha_vencimiento_certificado_gases = $value['vencimiento_gases'];
        $p_entidad_expide_certificado_gases = $value['entidad_gases'];
        $p_fecha_vencimiento_fuec = $value['vencimiento_fuec'];
        $p_entidad_expide_fuec = $value['vencimiento_fuec'];
        $p_fecha_vencimiento_licencia = $value['vencimiento_licencia'];
        $p_entidad_expide_licencia = $value['vencimiento_licencia'];
        $p_fecha_hora=$value['fecha_hora'];
        $p_foto_kilometraje=$value['foto_kilometraje'];
        $p_foto_combustible=$value['foto_combustible'];
        $firma_supervisor=$value['firma_supervisor'];
        $observaciones_supervisor =$value['observaciones_supervisor'];

        $datos = $value['listado'];      
        $data = json_decode($datos,true);

      

        



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
            $pdf->MultiCell(195, 4,$value['habeas'], 0, 'J', 0);

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
            $pdf->Cell(195, 20, $value['nombre_habeas'] . " " . $value['fecha_habeas'], 0, 1, 'C');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY($pdf->GetX() + 25, 1000);
            $pdf->MultiCell(150, 4, "NOTA: Todas las evidencias y/o certificados se encuentran para descargar en el software de PREVIAUTOS S.A.S", 0, 'C', 0);

            $pdf->Ln(-5);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 20, "REPORTE DE INSPECCION", 0, 1, 'C');

            $pdf->Ln(0);
            $image1 = (ROOT . "/images/qr_img.png");
            $pdf->Cell(60, 20, $pdf->Image($image1, $pdf->GetX() + 174, $pdf->GetY() - 25, 22), 0, 0, 'L', false);
            $image2 = (ROOT . "/images/vector_previ.png");
            $pdf->Cell(60, 20, $pdf->Image($image2, $pdf->GetX() - 60, $pdf->GetY() - 25, 35), 0, 0, 'L', false);

            $pdf->Ln(-10);
            $pdf->Cell(0, 20, "PREOPERACIONAL VEHICULAR ", 0, 1, 'C');

            $pdf->Ln(10);
            $pdf->SetFillColor(213, 213, 213);
            $pdf->SetDrawColor(255, 132, 0);
            $pdf->SetFont('Arial', 'B', 50);
            $pdf->Cell(195, 4, $value['placa'], 0, 0, 'C');

            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(55, 8, "SUPERVISOR DE PATIO", 'L,R,T', 0, 'L');
            $pdf->Cell(75, 4, "NOMBRE COMPLETO", 'L,R,T', 0, 'L', true);
            $pdf->Cell(65, 4, "DOCUMENTO", 'L,R,T', 0, 'L', true);
            $pdf->Ln();
            $pdf->Cell(55, 4, " ", 'L,R,B', 0, 'L');
            $pdf->Cell(75, 4, $value['nombre_supervisor'], 'L,R,B', 0, 'L');
            $pdf->Cell(65, 4, $value['documento_supervisor'], 'L,R,B', 0, 'L');

            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(195, 6, "DATOS DE LA EMPRESA DONDE SE ENCUENTRA VINCULADO", 0, 0, 'C');

         //datos empresa
            $id_empresa="";
            if (strcmp($database->status(), "bien") == 0) {

                $DatosEmpresaConductor = new DatosEmpresaConductor($database->myconn);
                $datos_empresa_conductor_array = $DatosEmpresaConductor->getDatosEmpresaConductor(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            
           

        ));
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
            $pdf->Cell(70, 4, "Nombre Certificado y/o Resolucion", 'T,L', 0, 'L', true);
            $pdf->Cell(75, 4, "Fecha Certificado y/o Resolucion", 'T,L', 0, 'L', true);
            $pdf->Cell(50, 4, "Fecha De Vencimiento (SI APLICA)", 'T,L,R', 0, 'L', true);
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

//NOMBRE CONDUCTOR ASIGNADO

            if (strcmp($database->status(), "bien") == 0) {

                $DatosConductor = new DatosConductor($database->myconn);
                $datos_conductor_array = $DatosConductor->getDatosConductor(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            
           

        ));

                foreach ($datos_conductor_array as $key => $value) {

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


            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(195, 4, "CONDUCTOR ASIGNADO Y/O SUPERVISOR", 0, 0, 'C');

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
            $pdf->Cell(68, 4, $p_correo, 'L,R,B', 0, 'R');
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
            $image3 = (ROOT . $p_foto_perfil);
            $pdf->Cell(60, 20, $pdf->Image($image3, $pdf->GetX() + 162, $pdf->GetY() - 55, 35, 45), 0, 0, 'L', false);


    //licencias

            if (strcmp($database->status(), "bien") == 0) {

                $DocumentosConductor = new DocumentosConductor($database->myconn);
                $documentos_conductor_array = $DocumentosConductor->getDocumentosConductor(
        array(
            'TYPE' => 'ID_VEHICULO',
            'VALUE' => $GLOBAL_ID_VEHICULO,
            
           

        ));

                foreach ($documentos_conductor_array as $key => $value) {

                 $p_categoria_licencia=(puntos_smart($value['categorias'],23,23));

             }

         } else {
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 30);
            $pdf->Cell(0, 4, " ", 0, 1, 'C');
            $pdf->MultiCell(0, 5, "", 0, 'C', 0);
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(195, 4, "VERIFICACIÓN DE VENCIMIENTOS DE DOCUMENTOS", 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(97.5, 4, "DOCUMENTACION", 'T,L', 0, 'C', true);
        $pdf->Cell(47.5, 4, "FECHA DE VENCIMIENTO", 'T', 0, 'C', true);
        $pdf->Cell(50, 4, "ENTIDAD QUE EXPIDE", 'T,R', 0, 'C', true);
        $pdf->Ln();
        $pdf->Cell(97.5, 4, "Tarjeta de propiedad", 'L', 0, 'L');
        $pdf->Cell(47.5, 4, $tarjeta_propiedad_vencimiento, 0, 0, 'C');
        $pdf->Cell(50, 4, $tarjeta_propiedad_entidad, 'R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(97.5, 4, "Revisión Tecnomecánica", 'L', 0, 'L');
        $pdf->Cell(47.5, 4, $p_fecha_vencimiento_rtm, 0, 0, 'C');
        $pdf->Cell(50, 4, $p_entidad_expide_rtm, 'R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(97.5, 4, "Certificación de Gases", 'L', 0, 'L');
        $pdf->Cell(47.5, 4, $p_fecha_vencimiento_certificado_gases, 0, 0, 'C');
        $pdf->Cell(50, 4, $p_entidad_expide_certificado_gases, 'R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(97.5, 4, "Planilla de viaje (FUEC)", 'L', 0, 'L');
        $pdf->Cell(47.5, 4, $p_fecha_vencimiento_fuec, 0, 0, 'C');
        $pdf->Cell(50, 4, $p_entidad_expide_fuec, 'R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(65.5, 4, "Licencia de Conducción del conductor", 'L,B', 0, 'L');
        $pdf->Cell(20.3, 4, "Categoria", 'B', 0, 'C');
        $pdf->Cell(19.3, 4, $p_categoria_licencia, 'B', 0, 'C');
        $pdf->Cell(49.9, 4, $p_fecha_vencimiento_licencia, 'B', 0, 'L');
        $pdf->Cell(40, 4, $p_entidad_expide_licencia, 'R,B', 0, 'L');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(195, 4, "POLIZAS Y SEGUROS DEL VEHICULO", 'T,L,R', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(97.5, 4, "TIPO POLIZA Y/O SEGURO", 'L', 0, 'L', true);
        $pdf->Cell(47.5, 4, "FECHA DE VENCIMIENTO", 0, 0, 'C', true);
        $pdf->Cell(50, 4, "ENTIDAD QUE EXPIDE", 'R', 0, 'C', true);

    # Traer las polizas

        if (strcmp($database->status(), "bien") == 0) {
            $Poliza = new Poliza($database->myconn);
            $poliza_vehiculo_array = $Poliza->getPolizaVehiculo($GLOBAL_ID_VEHICULO);

            foreach ($poliza_vehiculo_array as $key => $value) {

                $pdf->Ln();
                $pdf->Cell(97.5, 4, $value['nombre_poliza'], 1, 0, 'L');
                $pdf->Cell(47.5, 4, $value['vencimiento_polzia'], 1, 0, 'C');
                $pdf->Cell(50, 4, $value['aseguradora_poliza'], 1, 0, 'C');
            }


        } else {
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 30);
            $pdf->Cell(0, 4, " ", 0, 1, 'C');
            $pdf->MultiCell(0, 5, "Error al conectar a la base de datos", 0, 'C', 0);
        }



        $pdf->Ln(60);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(195, 4, "VERIFICACIÓN DE ELEMENTOS", 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(97.5, 4, "FECHA Y HORA", 'T,B,L', 0, 'L');
        $pdf->Cell(97.5, 4, $p_fecha_hora, 'T,B,R', 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(97.5, 4, "FOTO TACOMETRO KILOMETRAJE", 0, 0, 'C', true);
        $pdf->Cell(97.5, 4, "FOTO MEDIDOR DE COMBUSTIBLE", 0, 0, 'C', true);

        $pdf->Ln(10);
        $image5 = (ROOT . $p_foto_kilometraje);
        $pdf->Cell(60, 20, $pdf->Image($image5, $pdf->GetX() + 5, $pdf->GetY(), 80, 60), 0, 0, 'L', false);

        $image6 = (ROOT . $p_foto_combustible);
        $pdf->Cell(60, 20, $pdf->Image($image6, $pdf->GetX() + 53, $pdf->GetY(), 80, 60), 0, 0, 'L', false);

//ESTADO PRESENTACION - ESTADO COMODIDAD
        $pdf->Ln(70);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 4, "1", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Estado de Presentación", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
        $pdf->Cell(10, 4, "2", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Estado de Comodidad", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "1.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Aseo Interno", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDePresentacion"]["aseo_interno"], 0, 0, 'C');
        $pdf->Cell(10, 4, "2.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Aire Acondicionado", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDeComodidad"]["aire_acondicionado"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "1.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Aseo Externo", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDePresentacion"]["aseo_externo"], 0, 0, 'C');
        $pdf->Cell(10, 4, "2.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Silletería (Anclaje, estado)", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDeComodidad"]["silleteria_estado"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "1.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Latas", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDePresentacion"]["latas"], 0, 0, 'C');
        $pdf->Cell(10, 4, "2.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Encendedor", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDeComodidad"]["encendedor"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "1.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Pintura", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDePresentacion"]["pintura"], 0, 0, 'C');
        $pdf->Cell(10, 4, "2.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Luz Interior o de techo", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoDeComodidad"]["luz_interior_techo"], 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($pdf->GetX(), $pdf->GetY());
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["EstadoDePresentacion"]["notas_estado_presentacion"], 1, 'L', 0);
        $pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["EstadoDeComodidad"]["notas_estado_comodidad"], 1, 'L', 0);

//NIVELES LIQUIDOS - TABLERO CONTROL
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 4, "3", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Niveles y perdidas de líquidos", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
        $pdf->Cell(10, 4, "4", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Tablero de Control", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de Aceite de motor", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["nivel_aceite_motor"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Instrumentos", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["instrumentos"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de liquido de frenos ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["nivel_liquido_frenos"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Luces de Tablero ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["luces_tablero"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de agua del radiador", 0, 0, 'C');
        $pdf->Cell(32.5, 4,$data["NivelesYPerdidasDeLiquidos"]["nivel_agua_radiador"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de Combustible", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["nivel_combustible"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de agua de la batería", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["nivel_agua_bateria"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Odómetro", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["odometro"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Nivel de aceite hidráulico", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["nivel_aceite_hidraulico"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Pito", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["pito"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Fugas de Combustible", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["fuga_combustible"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Tacómetro", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["tacometro"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.7", 0, 0, 'C');
        $pdf->Cell(55, 4, "Fugas de Agua", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["fuga_agua"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.7", 0, 0, 'C');
        $pdf->Cell(55, 4, "Velocímetro", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["velocimetro"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.8", 0, 0, 'C');
        $pdf->Cell(55, 4, "Fugas de Aceite de transmisión", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["fuga_aceite_transmision"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.8", 0, 0, 'C');
        $pdf->Cell(55, 4, "Indicador de Aceite", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["indicador_aceite"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.9", 0, 0, 'C');
        $pdf->Cell(55, 4, "Fuga aceite de caja", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["fuga_aceite_caja"], 0, 0, 'C');
        $pdf->Cell(10, 4, "4.9", 0, 0, 'C');
        $pdf->Cell(55, 4, "Indicador de Temperatura", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["TableroDeControl"]["indicador_temperatura"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "3.10", 0, 0, 'C');
        $pdf->Cell(55, 4, "Fugas de líquidos de frenos", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["NivelesYPerdidasDeLiquidos"]["fuga_liquido_frenos"], 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($pdf->GetX(), $pdf->GetY());
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["NivelesYPerdidasDeLiquidos"]["notas_niveles_perdidas"], 1, 'L', 0);
        $pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["TableroDeControl"]["notas_tablero_control"], 1, 'L', 0);

//SEGURIDAD PASIVA - SEGURIDAD ACTIVA
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 4, "5", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Seguridad Pasiva", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
        $pdf->Cell(10, 4, "6", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Seguridad Activa", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Cinturones de Seguridad", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["cinturones_seguridad"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Barras de direccion", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["barras_direccion"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Airbags", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["airbags"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Terminales de direccion", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["terminales_direccion"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Chasis y carrocería", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["chasis_carroceria"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Guardapolvos caja de direccion ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["guardapolvos_direccion"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Cristales (Vidrios)", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["cristales_vidrios"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Brazo pitman y brazos auxiliares", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["brazos_pitman"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Apoyacabezas (Lo mas vertical posible)", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["apoyacabezas"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Amortiguadores", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["amortiguadores"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Posicion del asiento (Lo mas vertical posible)", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["posicion_asiento"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Tijeras ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["tijeras"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.7", 0, 0, 'C');
        $pdf->Cell(55, 4, "Espejo Lateral Derecho", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["espejo_lateral_derecho"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.7", 0, 0, 'C');
        $pdf->Cell(55, 4, "Ballestas o muelles", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["ballestas_muelles"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.8", 0, 0, 'C');
        $pdf->Cell(55, 4, "Espejo Lateral Izquierdo", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["espejo_lateral_izquierdo"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.8", 0, 0, 'C');
        $pdf->Cell(55, 4, "bombonas sistema neumatico de suspension", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["bombonas_suspension"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.9", 0, 0, 'C');
        $pdf->Cell(55, 4, "Espejo Retrovisor", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["espejo_retrovisor"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.9", 0, 0, 'C');
        $pdf->Cell(55, 4, "bujes", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["bujes"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "5.10", 0, 0, 'C');
        $pdf->Cell(55, 4, "Volante (Hacer prueba y verificar direccion)", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadPasiva"]["volante"], 0, 0, 'C');
        $pdf->Cell(10, 4, "6.10", 0, 0, 'C');
        $pdf->Cell(55, 4, "Cardan y Crucetas cardan", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["cardan_crucetas"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "", 0, 0, 'C');
        $pdf->Cell(55, 4, "", 0, 0, 'C');
        $pdf->Cell(32.5, 4, "", 0, 0, 'C');
        $pdf->Cell(10, 4, "6.11", 0, 0, 'C');
        $pdf->Cell(55, 4, "soportes de motor", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["soportes_motor"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "", 0, 0, 'C');
        $pdf->Cell(55, 4, "", 0, 0, 'C');
        $pdf->Cell(32.5, 4, "", 0, 0, 'C');
        $pdf->Cell(10, 4, "6.12", 0, 0, 'C');
        $pdf->Cell(55, 4, "Limpiabrisas Derecho", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["limpiabrisas_derecho"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "", 0, 0, 'C');
        $pdf->Cell(55, 4, "", 0, 0, 'C');
        $pdf->Cell(32.5, 4, "", 0, 0, 'C');
        $pdf->Cell(10, 4, "6.13", 0, 0, 'C');
        $pdf->Cell(55, 4, "Limpiabrisas Izquierdo", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["limpiabrisas_izquierdo"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "", 0, 0, 'C');
        $pdf->Cell(55, 4, "", 0, 0, 'C');
        $pdf->Cell(32.5, 4, "", 0, 0, 'C');
        $pdf->Cell(10, 4, "6.14", 0, 0, 'C');
        $pdf->Cell(55, 4, "cintas retro reflectivas", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["SeguridadActiva"]["cintas_reflectivas"], 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($pdf->GetX(), $pdf->GetY());
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["SeguridadPasiva"]["notas_seguridad_pasiva"], 1, 'L', 0);
        $pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["SeguridadActiva"]["notas_seguridad_activa"], 1, 'L', 0);

//ESTADO LUCES - Estado Llantas (Labrado 3mm, Presión de Aire, No Reencauchada)
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 4, "7", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Estado Luces", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
        $pdf->SetFont('Arial', 'B', 7.7);
        $pdf->Cell(10, 4, "8", 1, 0, 'C', true);
        $pdf->Cell(55, 4, "Estado Llantas (Labrado 3mm, Presión de Aire, No Reencauchada)", 'T,B', 0, 'L');
        $pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Luces Medias", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLuces"]["luces_medias"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.1", 0, 0, 'C');
        $pdf->Cell(55, 4, "Delantera Derecha ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_delantera_derecha"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Luces Altas", 0, 0, 'C');
        $pdf->Cell(32.5, 4,$data["EstadoLuces"]["luces_altas"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.2", 0, 0, 'C');
        $pdf->Cell(55, 4, "Delantera Izquierda ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_delantera_izquierda"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Luces Bajas", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLuces"]["luces_Bajas"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.3", 0, 0, 'C');
        $pdf->Cell(55, 4, "Trasera Derecha ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_trasera_derecha"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Direccional Izquie. Delant.", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLuces"]["direccional_izquierda_derecha"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.4", 0, 0, 'C');
        $pdf->Cell(55, 4, "Trasera Izquierda ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_trasera_izquierda"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Direccional Derec. Delant.", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLuces"]["direccional_derecha_delantera"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.5", 0, 0, 'C');
        $pdf->Cell(55, 4, "Repuesto", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_repuesto"], 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 4, "7.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Direccional Izquie. Trasera", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLuces"]["direccional_izquierda_trasera"], 0, 0, 'C');
        $pdf->Cell(10, 4, "8.6", 0, 0, 'C');
        $pdf->Cell(55, 4, "Rines ", 0, 0, 'C');
        $pdf->Cell(32.5, 4, $data["EstadoLlantas"]["llantas_rines"], 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY());
        $pdf->MultiCell(97.5, 4, "NOTA:  ".$data["EstadoLlantas"]["notas_estado_llantas"], 1, 'L', 0);

$pdf->Ln(); //FRENOS
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Direccional Derec. Trasera", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["direccional_derecha_trasera"], 0, 0, 'C');
$pdf->Cell(10, 4, "9", 1, 0, 'C', true);
$pdf->Cell(55, 4, "FRENOS", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Luces de Parqueo", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["luces_parqueo"], 0, 0, 'C');
$pdf->Cell(10, 4, "9.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado de los Frenos ", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Frenos"]["estado_frenos"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Luz Freno", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["luz_freno"], 0, 0, 'C');
$pdf->Cell(10, 4, "9.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Freno de Mano", 0, 0, 'C');
$pdf->Cell(32.5, 4,  $data["Frenos"]["freno_mano"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.10", 0, 0, 'C');
$pdf->Cell(55, 4, "Luz Reverso", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["luz_reverso"], 0, 0, 'C');
$pdf->Cell(10, 4, "9.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Pastillas", 0, 0, 'C');
$pdf->Cell(32.5, 4,  $data["Frenos"]["pastillas"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.11", 0, 0, 'C');
$pdf->Cell(55, 4, "L. Antiniebla Exploradoras", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["luz_exploradoras"], 0, 0, 'C');
$pdf->Cell(10, 4, "9.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Bandas", 0, 0, 'C');
$pdf->Cell(32.5, 4,  $data["Frenos"]["bandas"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "7.12", 0, 0, 'C');
$pdf->Cell(55, 4, "Luces Internas", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["EstadoLuces"]["luces_internas"], 0, 0, 'C');
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($pdf->GetX(), $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["EstadoLuces"]["notas_estado_luces"], 1, 'L', 0);
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Frenos"]["notas_frenos"], 1, 'L', 0);

//ESTADO LUCES - Estado Llantas (Labrado 3mm, Presión de Aire, No Reencauchada)
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "10", 1, 0, 'C', true);
$pdf->Cell(55, 4, "Otros", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
$pdf->Cell(10, 4, "11", 1, 0, 'C', true);
$pdf->Cell(55, 4, "Equipo de Carretera", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "10.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Instalaciones eléctricas", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["instalaciones_electricas"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.1", 0, 0, 'C');
$pdf->Cell(55, 4, "1 gato  con capacidad ", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["gato_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "10.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Clutch", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["clutch"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, "para elevar el vehículo", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "10.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Exosto", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["exosto"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.2", 0, 0, 'C');
$pdf->Cell(55, 8, "1 chaleco reflectivo ", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["chaleco_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "10.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Alarma Sonora de Reversa", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["alarma_reversa"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "10.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Salto de cambios", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["salto_cambios"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.3", 0, 0, 'C');
$pdf->Cell(55, 8, "2 tacos para bloquear el vehículo", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["tacos_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "10.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Cambios suaves", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["cambios_suaves"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "10.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Guaya del acelerador", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["guaya_acelerador"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.4", 0, 0, 'C');
$pdf->Cell(55, 8, "2 señales de carretera triangulares", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["señales_triangulares_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "10.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Sistema de embrague", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["sistema_embrague"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "10.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Encendido", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["encendido"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.5", 0, 0, 'C');
$pdf->Cell(55, 8, "1 par de guantes  de trabajo en lona", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["guantes_lona_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "10.10", 0, 0, 'C');
$pdf->Cell(55, 4, "Placas", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Otros"]["placas"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($pdf->GetX(), $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Otros"]["notas_otros"], 1, 'L', 0);
//BUSES
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12", 1, 0, 'C', true);
$pdf->Cell(55, 4, " BUSES", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');
$pdf->Cell(10, 8, "11.6", 0, 0, 'C');
$pdf->Cell(55, 8, "1 cruceta", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["cruceta_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Salidas De Emergencia", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["salidas_emergencia"], 0, 0, 'C');
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Martillo De Fragmentacion", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["martillo_fragmentacion"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.7", 0, 0, 'C');
$pdf->Cell(55, 8, "1 cable de iniciar", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["cable_iniciar_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Escaleras De Acceso", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["escaleras_acceso"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Señalizacion De Salidas De Emergencia", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["senalizacion_salidas_emergencia"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.8", 0, 0, 'C');
$pdf->Cell(55, 4, "1 extinguidor de fuego( capacidad mín.", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["extintor_fuego"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Pasamanos Del Techo", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["pasamanos_techo"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " 10 lb), Tipo BC preferiblemente CO2", 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(32.5,6, "VENC. ".$data["EquipoDeCarretera"]["fecha_vencimiento_extintor_fuego"], 0, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Dispositivo De Velocidad", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["dispositivos_velocidad"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.9", 0, 0, 'C');
$pdf->Cell(55, 4, "2 conos plásticos reflectivos", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["conos_plasticos_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Antideslizante Para Escaleras", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["antideslizante_escaleras"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " de 50 cm de alto", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Cinturones De Seguridad", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["cinturones_seguridad_buses"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.10", 0, 0, 'C');
$pdf->Cell(55, 4, "1 linterna auto recargable con adaptador", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["linterna_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Del Piso Sin Obtaculos", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["estado_piso"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, "al encendedor de cigarrillos", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.10", 0, 0, 'C');
$pdf->Cell(55, 4, "Dispositivos De Expulsion", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["dispositivos_expulsion"], 0, 0, 'C');
$pdf->Cell(10, 8, "11.11", 0, 0, 'C');
$pdf->Cell(55, 4, "1 caja de herramientas (alicates, ", 0, 0, 'C');
$pdf->Cell(32.5, 8, $data["EquipoDeCarretera"]["caja_herramientas_vehiculo"], 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(10, 4, "12.11", 0, 0, 'C');
$pdf->Cell(55, 4, "Silleteria", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["silleteria"], 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, "destornilladores de pala y estrella, ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "12.12", 0, 0, 'C');
$pdf->Cell(55, 4, "Ventanas De Emergencia", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Buses"]["ventanas_emergencia"], 0, 0, 'C');
$pdf->Cell(10, 8, " ", 0, 0, 'C');
$pdf->Cell(55, 4, "llave de expansión y fijas)", 0, 0, 'C');
$pdf->Cell(32.5, 8, "", 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Cell(10, 4, " ", 0, 0, 'C');
$pdf->Cell(55, 4, " ", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');

$pdf->Ln(-1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Cell(10, 4, "11.12", 0, 0, 'C');
$pdf->Cell(55, 4, "                                     Botiquin"."        VENC." .$data["EquipoDeCarretera"]["fecha_vencimiento_botiquin"], 0, 0, 'C');
$pdf->Cell(32.5, 4,  $data["EquipoDeCarretera"]["botiquin_vehiculo"], 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($pdf->GetX(), $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Buses"]["notas_bus"], 1, 'L', 0);
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["EquipoDeCarretera"]["notas_equipo_carretera"], 1, 'L', 0);

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "13", 1, 0, 'C', true);
$pdf->Cell(55, 4, "REMOLQUE DE TRACTOCAMIONES", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "14", 1, 0, 'C', true);
$pdf->Cell(55, 4, "VOLQUETAS", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "13.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Estructurta De La Mesa", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["estructura_mesa"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Palanca De Mano De Maniobra Del Platon", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Volquetas"]["palanca_maniobra_platon"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Carroceria Del Trailer", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["carroceria_trailer"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Palanca De Seguridad Del Descargue Del Platon", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Volquetas"]["palanca_descargue_platon"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Mangueras Neumaticas y Acoples Del Trailer", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["mangueras_acoples"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Gatos Del Levante Del Platon", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["gatos_levante_platon"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Torres De Soporte Del Trailer", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["torres_soporte"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado General Del Platon", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["estado_platon"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Manpara Metalica", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["manpara_metalica"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Espigos De La Puerta Del Platon", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["espigos_puerta_platon"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Aparejos De Amarre", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["aparejo_amarre"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Anclajes", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["anclajes"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Quinta Rueda", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["quinta_rueda"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Ganchos De Amare De La Carpa", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["ganchos_amarre_carpa"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "13.8", 0, 0, 'C');
$pdf->Cell(55, 4, "King Ping", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["RemolqueDeTractocamiones"]["king_ping"], 0, 0, 'C');
$pdf->Cell(10, 4, "14.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado De La Carpa", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Volquetas"]["estado_carpa"], 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Cell(10, 4, "14.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Conos De Señalizacion Trabajo En Carretera", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Volquetas"]["cono_senalizacion_trabajo_carretera"], 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($pdf->GetX(), $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["RemolqueDeTractocamiones"]["notas_remolque_tractocamiones"], 1, 'L', 0);
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Volquetas"]["notas_volquetas"], 1, 'L', 0);
// CAMION - VEHICULOS DE BASURAS
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "15", 1, 0, 'C', true);
$pdf->Cell(55, 4, "CAMION", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B', 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "16", 1, 0, 'C', true);
$pdf->Cell(55, 4, "VEHICULOS RECOLECTORES DE BASURAS", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, "", 'T,B,R', 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 1", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_1"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Controles Hidráulicos Trasero", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["control_hidraulico_trasero"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 2", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_2"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Revice Torniquete De La Compuerta De Cola", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["revice_torniquete_compuerta_cola"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 3", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_3"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Revice Reguladores De La Presión ", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["revice_reguladores_presion"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 4", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_4"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Revice Palanca De Barrido   ", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["revice_palanca_barrido"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 5", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_5"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Revice Palanca Volcador ", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["revice_palanca_volcador"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 6", 0, 0, 'C');
$pdf->Cell(32.5, 4,$data["Camion"]["estado_llanta_6"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Inspe. Desgaste, Pernos, Tolva Posterior", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["inspeccionar_desgaste_pernos_tolva_posterior"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 7", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_7"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.7", 0, 0, 'C');
$pdf->Cell(55, 4, "Inspe. Desgaste Sujetadores, Tolva Posterior", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["inspeccionar_desgaste_sugetadores_tolva_posterior"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 8", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_8"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.8", 0, 0, 'C');
$pdf->Cell(55, 4, "Inspe. Desgaste, Pasadores Tolva Posterior", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["inspeccionar_desgaste_pasadores_tolva_posterior"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 9", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_9"], 0, 0, 'C');
$pdf->Cell(10, 4, "16.9", 0, 0, 'C');
$pdf->Cell(55, 4, "Revisar Cuchilla Tolva Posterior", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["VehiculosRecolectoresDeBasuras"]["revisar_cuchilla_tolva_posterior"], 0, 0, 'C');

$pdf->Ln();
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["VehiculosRecolectoresDeBasuras"]["notas_recolector_basura"], 1, 'L', 0);
//ENZEÑANZA
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.10", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 10", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_10"], 0, 0, 'C');
$pdf->Cell(10, 4, "17", 1, 0, 'C', true);
$pdf->Cell(55, 4, "ENSEÑANZA", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, " ", 'T,B,R', 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.11", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 11", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_11"], 0, 0, 'C');
$pdf->Cell(10, 4, "17.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Doble Mando De Freno", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Ensenianza"]["doble_mando_freno"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.12", 0, 0, 'C');
$pdf->Cell(55, 4, "Estado Llanta 12", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["estado_llanta_12"], 0, 0, 'C');
$pdf->Cell(10, 4, "17.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Doble Juego De Espejos Retovisores interiores", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ensenianza"]["doble_espejos_retrovisores_interiores"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.13", 0, 0, 'C');
$pdf->Cell(55, 4, "Sistema Frenos Neumaticos", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["sistema_frenos_neumaticos"], 0, 0, 'C');
$pdf->Cell(10, 4, "17.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Letreros De Enseñanza", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Ensenianza"]["letreros_ensenanza"], 0, 0, 'C');

$pdf->Ln();
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Ensenianza"]["notas_ensenanza"], 1, 'L', 0);
//AMBULANCIA
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.14", 0, 0, 'C');
$pdf->Cell(55, 4, "Freno De Emergencia", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["freno_emergencia"], 0, 0, 'C');
$pdf->Cell(10, 4, "18", 1, 0, 'C', true);
$pdf->Cell(55, 4, "AMBULANCIA", 'T,B', 0, 'L');
$pdf->Cell(32.5, 4, " ", 'T,B,R', 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.15", 0, 0, 'C');
$pdf->Cell(55, 4, "Fuga Sistema Neumatico De Frenos", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["fuga_sistema_neumatico_frenos"], 0, 0, 'C');
$pdf->Cell(10, 4, "18.1", 0, 0, 'C');
$pdf->Cell(55, 4, "Malacates (winches)", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["malacates"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.16", 0, 0, 'C');
$pdf->Cell(55, 4, "Grapas Y Anclaje De Chasis", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["grapas_anclajes_chasis"], 0, 0, 'C');
$pdf->Cell(10, 4, "18.2", 0, 0, 'C');
$pdf->Cell(55, 4, "Barra Pasamanos (Asidero)", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["barra_pasamanos"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.17", 0, 0, 'C');
$pdf->Cell(55, 4, "Tanque Combustible Abrasaderas Y Soporte", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Camion"]["tanque_combustible_abrasadera_soporte"], 0, 0, 'C');
$pdf->Cell(10, 4, "18.3", 0, 0, 'C');
$pdf->Cell(55, 4, "Reflectivos", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["reflectivos"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "15.18", 0, 0, 'C');
$pdf->Cell(55, 4, "Kit Ambiental Antiderrames", 0, 0, 'C');
$pdf->Cell(32.5, 4, $data["Camion"]["kit_antiderrame"], 0, 0, 'C');
$pdf->Cell(10, 4, "18.4", 0, 0, 'C');
$pdf->Cell(55, 4, "Claraboyas", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["claraboyas"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Cell(10, 4, "18.5", 0, 0, 'C');
$pdf->Cell(55, 4, "Número De Identificación", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["numero_identificacion"], 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "", 0, 0, 'C');
$pdf->Cell(55, 4, "", 0, 0, 'C');
$pdf->Cell(32.5, 4, "", 0, 0, 'C');
$pdf->Cell(10, 4, "18.6", 0, 0, 'C');
$pdf->Cell(55, 4, "Cruz De La Vida", 0, 0, 'L');
$pdf->Cell(32.5, 4, $data["Ambulancia"]["cruz_vida"], 0, 0, 'C');

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($pdf->GetX(), $pdf->GetY());
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Camion"]["notas_camion"], 1, 'L', 0);
$pdf->SetXY($pdf->GetX() + 97.5, $pdf->GetY() - 4);
$pdf->MultiCell(97.5, 4, "NOTA:  ".$data["Ambulancia"]["notas_ambulancia"], 1, 'L', 0);

$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "19", 1, 0, 'C', true);
$pdf->Cell(185, 4, "MONTACARGAS", 'T,B,R', 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195, 4, "HORQUILLAS Y MASTIL", 0, 0, 'C', true);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "19.1", 0, 0, 'C');
$pdf->Cell(145, 4, "Se Identifican Señales De Fuga De Aceite Hidraulico", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["fuga_aceite_hidrahulico_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.2", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Llantas Tienen La Goma De Cubrimiento Sin Desgaste", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["llantas_desgaste_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.3", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Horquillas De Levantamiento De Carga Estan En Su Lugar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["horquillas_levantamiento_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.4", 0, 0, 'C');
$pdf->Cell(145, 4, "Los Pasadores De Fijacion De Las Horquillas Estan En Su Lugar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["pasadores_fijacion_horquillas_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.5", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Horquillas Y El Mastil Se Encuentran En Buenas Condiciones", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["horquillas_mastil_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.6", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Cadenas, Cables y Mangueras Estan En Su Lugar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["cables_cadenas_mangueras_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.7", 0, 0, 'C');
$pdf->Cell(145, 4, "El Horometro Se Encuentra Trabajando", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["horometro_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "BATERIA", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.8", 0, 0, 'C');
$pdf->Cell(145, 4, "Se Identifican Señales De Fuga De Agua De Bateria y/o Electrolito", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["fuga_agua_bateria_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.9", 0, 0, 'C');
$pdf->Cell(145, 4, "Los Bornes De Conexion De La Bateria Estan En Su Lugar ", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["bornes_bateria_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.10", 0, 0, 'C');
$pdf->Cell(145, 4, "El Conector De La Bateria Encaja Correctamente y Esta Sin Quemaduras, Agrietamientos", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["conector_bateria_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "PROTECTORES", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.11", 0, 0, 'C');
$pdf->Cell(145, 4, "La Guardia De Proteccion Superior Esta En Su Lugar ", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["guardia_proteccion_superior_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.12", 0, 0, 'C');
$pdf->Cell(145, 4, "El Respaldo De Carga Esta En Su Lugar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["respaldo_carga_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.13", 0, 0, 'C');
$pdf->Cell(145, 4, "El Retenedor De Bateria Esta Instalado En Su Lugar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["retenedor_bateria_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "DISPOSITIVOS DE SEGURIDAD", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.14", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Luces Delanteras, Traseras y De Advertencia Funcionan y Estan Apuntadas Correctamente", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["luces_delanteras_advertencia_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.15", 0, 0, 'C');
$pdf->Cell(145, 4, "La Bocina Suena", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["bocina_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.16", 0, 0, 'C');
$pdf->Cell(145, 4, "La Alarma De Retroceso Funciona", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["alarma_retroceso_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.17", 0, 0, 'C');
$pdf->Cell(145, 4, "Las Etiquetas De Peligro Se Ven y Leen Con Facilidad", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["etiquetas_peligro_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.18", 0, 0, 'C');
$pdf->Cell(145, 4, "La Direccion No Presenta Atascamientos o Juegos Excesivos", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["direccion_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "CONTROL DE TRACCION", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.19", 0, 0, 'C');
$pdf->Cell(145, 4, "Todos Los Rangos De Velocidad", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["rangos_velocidad_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.20", 0, 0, 'C');
$pdf->Cell(145, 4, "Marcha Hacia Adelante y Hacia Atras", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["marcha_delante_detras_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.21", 0, 0, 'C');
$pdf->Cell(145, 4, "Sin Ruidos Inusuales", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["ruidos_inusuales_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "CONTROLES HIDRAULICOS", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.22", 0, 0, 'C');
$pdf->Cell(145, 4, "Levantar y Bajar", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["levantar_bajar_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.23", 0, 0, 'C');
$pdf->Cell(145, 4, "Inclinacion Hacia Adelante y Hacia Atras", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["inclinacion_delante_atras_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.24", 0, 0, 'C');
$pdf->Cell(145, 4, "Extension Hacia Adentro y Afuera", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["extension_adentro_fuera_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.25", 0, 0, 'C');
$pdf->Cell(145, 4, "Desplazamiento Derecho e Izquierdo", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["desplazamiento_derecho_izquierdo_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.26", 0, 0, 'C');
$pdf->Cell(145, 4, "Sin Ruidos Inusuales", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["ruidos_inusuales_controles_hidraulicos_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "FRENOS", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "19.27", 0, 0, 'C');
$pdf->Cell(145, 4, "Paran La Unidad Dentro De La Distancia requerida", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["distancia_requerida_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.28", 0, 0, 'C');
$pdf->Cell(145, 4, "Trabajan Suavemente", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["trabajan_suavemente_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.29", 0, 0, 'C');
$pdf->Cell(145, 4, "Boton De Parada De Emergencia Funciona Correctamente", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["boton_emergencia_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.30", 0, 0, 'C');
$pdf->Cell(145, 4, "Medidor De Descarga En Verde Lleno o 75% De La Carga Despues De Levantar Las Horquillas ", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["medidor_descarga_horquillas_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.31", 0, 0, 'C');
$pdf->Cell(145, 4, "Al Desconectar Los Cables De La Bateria, Se Corta Toda Fuente De Poder", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["desconectar_cables_bateria_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.32", 0, 0, 'C');
$pdf->Cell(145, 4, "El Motor Trabaja Suave y Silenciosamente, Sin Ruidos, Fugas o Chispas", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["motor_sin_ruidos_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "19.33", 0, 0, 'C');
$pdf->Cell(145, 4, "Lleva Un Extintor Para El Tipo De Fuego Que Representa y El Operador Sabe Como Utilizarlo", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Montacargas"]["extintor_montacargas"]."     "."VENC.".$data["Montacargas"]["fecha_vencimiento_extintor_montacargas"], 0, 0, 'L');
$pdf->Ln();
$pdf->MultiCell(195, 4, "NOTA:  ".$data["Montacargas"]["notas_montacargas"], 1, "L", false);

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, "20", 1, 0, 'C', true);
$pdf->Cell(185, 4, "MOTOS", 'T,B,R', 0, 'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 4, "20.1", 0, 0, 'C');
$pdf->Cell(145, 4, "Estado Del Casco Del Piloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["estado_casco_piloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.2", 0, 0, 'C');
$pdf->Cell(145, 4, "Estado Del Casco Del Copiloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["estado_casco_copiloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.3", 0, 0, 'C');
$pdf->Cell(145, 4, "Cumplimiento Normativo Del Casco Del Piloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["normativa_casco_piloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.4", 0, 0, 'C');
$pdf->Cell(145, 4, "Cumplimiento Normativo Del Copiloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["normativa_casco_copiloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.5", 0, 0, 'C');
$pdf->Cell(145, 4, "Debidamente Identificado Casco Piloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["identificado_casco_piloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.6", 0, 0, 'C');
$pdf->Cell(145, 4, "Debidamente Identificado Casco Copiloto", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["identificado_casco_copiloto"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(195, 4, "ELEMENTOS DE PROTECCION", 0, 0, 'C', true);
$pdf->Ln();
$pdf->Cell(10, 4, "20.7", 0, 0, 'C');
$pdf->Cell(120, 4, "Guantes", 0, 0, 'L');
$pdf->Cell(25, 4, "SI", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["guantes"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.8", 0, 0, 'C');
$pdf->Cell(120, 4, "Rodilleras", 0, 0, 'L');
$pdf->Cell(25, 4, "SI", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["rodilleras"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.9", 0, 0, 'C');
$pdf->Cell(120, 4, "Chaleco De Proteccion Mas Reflectivo", 0, 0, 'L');
$pdf->Cell(25, 4, "SI", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["chaleco"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.10", 0, 0, 'C');
$pdf->Cell(120, 4, "Coderas", 0, 0, 'L');
$pdf->Cell(25, 4, "SI", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["coderas"], 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 4, "20.11", 0, 0, 'C');
$pdf->Cell(120, 4, "Calzado De Cuero y Antideslizante", 0, 0, 'L');
$pdf->Cell(25, 4, "SI", 0, 0, 'L');
$pdf->Cell(40, 4, $data["Motos"]["calzado"], 0, 0, 'L');
$pdf->Ln();
$pdf->MultiCell(195, 4, "NOTA:  ".$data["Motos"]["notas_motos"], 1, "L", false);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "OBSERVACIONES CONDUCTOR", 0, 0, 'C');
$pdf->Ln(7);
$pdf->MultiCell(195, 4, $data["Resultados"]["observaciones_conductor"], 1, "L", false);

$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, " VISTO POR PARTE DEL SUPERVISOR DE PATIO", 0, 0, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(97.5, 4, "¿Se ecuentra el vehículo en optimas condiciones para salir?", 'T,B,L', 0, 'L');

if ($data["Resultados"]["resultado_preoperativo"] == 2) {
    $resultado_preoperacion = "SI";
}
else{
    $resultado_preoperacion = "NO";
}

$pdf->Cell(97.5, 4, $resultado_preoperacion , 'T,B,R', 0, 'C');

$pdf->Ln(5);
$image14 = (ROOT .  $firma_supervisor);
$pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() + 55, $pdf->GetY(), 70, 30), 0, 0, 'L', false);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "FIRMA SUPERVISOR PATIO", 0, 0, 'L');

$pdf->Ln(25);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "OBSERVACIONES SUPERVISOR PATIO", 0, 0, 'C');
$pdf->Ln(7);
$pdf->MultiCell(195, 4, $observaciones_supervisor, 1, "L", false);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "FOTOGRAFIA DEL VEHICULO DE SALIDA", 0, 0, 'C');

$pdf->Ln(10);
$image14 = (ROOT . $data["Resultados"]["foto_vehiculo_salida"]);
$pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() + 35, $pdf->GetY(), 130, 100), 0, 0, 'L', false);

$pdf->Ln(110);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195, 4, "FOTOGRAFIA DEL VEHICULO DE REGRESO", 0, 0, 'C');

$pdf->Ln(10);
$image14 = (ROOT . $data["Resultados"]["foto_vehiculo_regreso"]);
$pdf->Cell(60, 20, $pdf->Image($image14, $pdf->GetX() + 35, $pdf->GetY(), 130, 100), 0, 0, 'L', false);

    } 

} 

else {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 30);
    $pdf->Cell(0, 4, " ", 0, 1, 'C');
    $pdf->MultiCell(0, 5, "", 0, 'C', 0);
}