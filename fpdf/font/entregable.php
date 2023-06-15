
<?php 


/*******************************************************************************
* PREVENTIVA                                                                  *
*                                                                             *
* Version: 1.0                                                                *
* Date:    2020-12-21                                                         *
* Author:  YEFERSON DEVIA DIAZ (DON COMEDIA)                                  *
*******************************************************************************/
include ("prev_config.php");
require('fpdf/fpdf.php');

class PDF_rotate extends FPDF 
{

var $angle=0;

function Rotate($angle,$x=-1,$y=-1)
{
    if($x==-1)
        $x=$this->x;
    if($y==-1)
        $y=$this->y;
    if($this->angle!=0)
        $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
    {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
}

function _endpage()
{
    if($this->angle!=0)
    {
        $this->angle=0;
        $this->_out('Q');
    }
    parent::_endpage();
}
}



class PDF extends PDF_rotate
{

function Header()
{
    /* Put the watermark */
    $this->SetFont('Arial','B',78);
    $this->SetTextColor(246, 246, 246);
    $this->RotatedText(35,200,'P R E V E N T I V A',45);

}

function RotatedText($x, $y, $txt, $angle)
{
    /* Text rotated around its origin */
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}





	function Footer()// pone la numeracion de las paginas NO BORRAR 
	{

		$this->SetY(-15);

		$this->SetTextColor(0, 0, 0);

		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,'Hoja '.$this->PageNo().'/{nb}',0,0,'C');
	}
	var $widths;




	
var $aligns;


}

	

// Creación del objeto de la clase heredada
$pdf = new PDF ("P","mm","A4"); 
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->Image(ROOT."/images/logo_cda.png",10,8,33);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,20,"FICHA TÈCNICA DE REVISIÒN PREVENTIVA",0,1,'L');
//logo cda primera linea
$pdf->Ln(0);

$image1 = (ROOT."/images/vector_previ.png");
$pdf->Cell( 60, 20, $pdf->Image($image1, $pdf->GetX() +165, $pdf->GetY() - 20, 30), 0, 0, 'L', false );
//$image1 = (ROOT."/images/Escudo_de_armas_republica_de_Colombia.jpg");
//$pdf->Cell( 60, 20, $pdf->Image($image1, $pdf->GetX() + 70, $pdf->GetY()- 20, 33), 0, 0, 'L', false );














$pdf->Ln(0); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"CLASE",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"COMBUSTIBLE",'L,T,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"EMPRESA SOLICITANTE",'L,T,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"MARCA",'L,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"SERVICIO",'L,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"CIUDAD",'L,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"TIPO",'L,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"AÑO MODELO",'L,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"INSPECTOR",'L,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"No DE PUERTAS",'L,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"KILOMETRAJE",'L,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"CODIGO FASECOLDA",'L,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"NACIONALIDAD",'L,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"No CHASIS",'L,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"VALOR FASECOLDA",'L,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"TIPO DE CAJA",'L,',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"No MOTOR",'L,R',0,'L');
$pdf->Cell(26,4," ",'L,T,',0,'L');
$pdf->Cell(30,4,"PLACA",'L,',0,'L');
$pdf->Cell(45,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->Cell(35,4,"CILINDRAJE",'L,B',0,'L');
$pdf->Cell(30,4," ",'L,T,B',0,'L');
$pdf->Cell(30,4,"FECHA INSPECCIÒN",'L,R,B',0,'L');
$pdf->Cell(26,4," ",'L,T,B',0,'L');
$pdf->Cell(30,4," ",'L,B',0,'L');
$pdf->Cell(45,4," ",'L,R,B',0,'L');
$pdf->Ln(6); 
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(220,50,50);
$pdf->Cell(35,4,"ETAPA EVALUADA",0,0,'C');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(26,4,"ETAPA EVALUADA",0,0,'C');
$pdf->Cell(30,4,"           ESTE DOCUMENTO NO ES VALIDO COMO AVALUO COMERCIAL",0,0,'L');
$pdf->Cell(45,4," ",0,0,'L');

$pdf->Ln(); 
$pdf->SetFont('Arial','B',6);
$pdf->SetTextColor(0,0,0);
$pdf->SetDrawColor(0,80,180);
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(35,4,"EJE DELANTERO",'L,T,R',0,'L');
$pdf->Cell(26,4," ",'T',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(45,4,"EJE DELANTERO",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"EFICACIA DE FRENADO",'L',0,'C');
$pdf->Cell(35,4,"EJE TRASERO 1",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"EFICACIA DE FRENADO",0,0,'C');
$pdf->Cell(45,4,"EJE TRASERO 1",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"FRENO DE SERVICIO",'L',0,'C');
$pdf->Cell(35,4,"EJE TRASERO 2",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"FRENO DE EMERGENCIA",0,0,'C');
$pdf->Cell(45,4,"EJE TRASERO 2",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"EJE TRASERO 3",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"EJE TRASERO 3",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,T',0,'L');
$pdf->Cell(35,4,"Nivel de aceite motor",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",'T',0,'L');
$pdf->Cell(45,4,"Cinturon de seguridad conductor",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Refrigerante motor",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Cinturon de seguridad pasajero",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"NIVELES DE FLUIDOS",'L',0,'C');
$pdf->Cell(35,4,"Liquido de frenos",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"SEGURIDAD PASIVA",0,0,'C');
$pdf->Cell(45,4,"Apoya cabezas conductor",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Direcciòn hidràulica",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Apoya cabezas pasajero",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,B',0,'L');
$pdf->Cell(35,4,"Lavaparabrisas",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Airbag conductor",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,T',0,'L');
$pdf->Cell(35,4,"Panoràmico delantero",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Airbag pasajero",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Panoràmico superior",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(45,4,"Botiquin",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Farola derecha",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Alicate",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Farola izquierda",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Destornillador de estrella",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"CARROCERIA EXTERIOR",'L',0,'C');
$pdf->Cell(35,4,"Espejo derecho",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Llaves fijas",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Espejo izquierdo",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Llaves de expanciòn",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Vidrios laterales derechos",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"EQUIPO DE CARRETERA",0,0,'L');
$pdf->Cell(45,4,"Gato",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Vidrios laterales izquierdos",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Cruceta",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Panoràmico trasero",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Triangulos",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Stop derecho",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Tacos",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Stop izquierdo",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Linterna",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Imagen corporativa",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Extintor vigente",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,T',0,'L');
$pdf->Cell(35,4,"Altas",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(45,4,"Aire acondicionado",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Bajas",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Calefacciòn",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Cocuyos",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Espejos electricos",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Exploradoras",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Master de corriente",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Direccionales delanteras",'L,T',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Pito",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"LUCES",'L',0,'C');
$pdf->Cell(35,4,"Direccionales traseras",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"SEGURIDAD OPERACIONAL",0,0,'L');
$pdf->Cell(45,4,"Bornes de bateria",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Estacionamiento",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Desempañador",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz freno",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Limpiaparabrisas delantero",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz reverso",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Limpiaparabrisas trasero",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz placa",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Asiento ajustable conductor",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz cabina",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Timòn ajustable",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz pasillo",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",'L,T,',0,'L');
$pdf->Cell(45,4,"Amortiguador delantero derecho",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Luz pasillo superior",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Amortiguador delantero izquierdo",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,T',0,'L');
$pdf->Cell(35,4,"Llanta delantera derecha",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Amortiguador trasero derecho",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Llanta delantera izquierda",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Amortiguador trasero izquierdo",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4,"ESTADO DE LAS LLANTAS",'L',0,'C');
$pdf->Cell(35,4,"Llanta trasera derecha",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4,"SEGURIDAD ACTIVA",0,0,'C');
$pdf->Cell(45,4,"Ejes delanteros",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Lanta trasera izquierda",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4," ",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Llanta de repuesto",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Ejes traseros",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,T',0,'L');
$pdf->Cell(35,4,"SOAT Vigente",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Cardan",'L,T,',0,'L');
$pdf->Cell(30,4," ",'L,T,R',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'C');
$pdf->Cell(35,4,"RTM Vigente",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R,B',0,'L');
$pdf->Cell(30,4," ",0,0,'L');
$pdf->Cell(45,4,"Columna de direcciòn",'L,T,B',0,'L');
$pdf->Cell(30,4," ",'L,T,R,B',0,'L');
$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Pòliza RCE Vigente ",'L,T,',0,'L');
$pdf->Cell(26,4,"Muelles traseros",'L,T,R',0,'L');
$pdf->Cell(30,4," ",'T',0,'C');

$pdf->Ln(); 
$pdf->Cell(30,4,"DOCUMENTOS",'L',0,'C');
$pdf->Cell(35,4,"Pòliza RCC Vigente",'L,T,',0,'L');
$pdf->Cell(26,4," ",'L,T,R,B',0,'L');
$pdf->Cell(30,4,"OBSERVACIONES: ",0,0,'C');

$pdf->Ln(); 
$pdf->Cell(30,4," ",'L',0,'L');
$pdf->Cell(35,4,"Calcomania de tarifas vigentes",'L,T,B',0,'L');
$pdf->Cell(26,4," ",'L,T,R,B',0,'L');

$pdf->Ln(); 
$pdf->Cell(30,4," ",'L,B',0,'L');
$pdf->Cell(35,4,"Pòliza todo riesgo",'L,T,B',0,'L');
$pdf->Cell(26,4," ",'L,T,R,B',0,'L');
$current_y = $pdf->GetY();
$current_x = $pdf->GetX();
$pdf->MultiCell(105,5,"De los 190 items calificados de acuerdo con la NTC 5375, NTC 4983, NTC 4231 y la resolución 6184, se ha corroborado que se encuentra en estado SATIFACTORIO.",1,"L", false,"T");
$pdf->SetXY($current_x - 220, $current_y - 100); 

$pdf->Output();
?>