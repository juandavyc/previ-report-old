<?php

class PDF extends FPDF
{





    public function RotatedText($x, $y, $txt, $angle)
    {
        /* Text rotated around its origin */
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
    public function Footer() // pone la numeracion de las paginas NO BORRAR

    {

        $this->SetY(-18);

        $this->SetTextColor(0, 0, 0);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, "Hoja " . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, "PREVENTIVAS DE AUTOS S.A.S NIT: 901004238-2 TEL: 9370804 DIR: AC 13 # 96A - 35 BOGOTÁ  
preventivasdeautos@gmail.com", 0, 0, 'C');
    }

    public $widths;
    public $aligns;

    public function SetWidths($w)
    {
//Establecer la matriz de anchos de columna
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
//Establecer la matriz de alineaciones de columnas
        $this->aligns = $a;
    }

    public function Row($data)
    {
//cacula el alto de la fila
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        $h = 5 * $nb;
        //Establecer la matriz de alineaciones de columnas
        $this->CheckPageBreak($h);
        //Dibuja las celdas de la fila
        for ($i = 0; $i < count($data); $i++) {$w = $this->widths[$i];
            $a = $this->aligns;
            //Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();
            //Dibuja el borde
            $this->Rect($x, $y, $w, $h);

            if ($i == 2 || $i == 3) {
                $this->MultiCell($w, 5, $data[$i], 0, "C");
            } else {
                $this->MultiCell($w, 5, $data[$i], 0, $a);
            }

            //Pon la posición a la derecha de la celda
            $this->SetXY($x + $w, $y);
        }
        //Ir a la siguiente línea
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //Si la altura mayor causaría un desbordamiento, agregue una nueva página inmediatamente
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }

    }

    public function NbLines($w, $txt)
    {
        //Calcula el número de líneas que tomará una MultiCell de ancho w
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {$c = $s[$i];if ($c == "\n") {$i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
            continue;}if ($c == ' ') {
            $sep = $i;}$l += $cw[$c];if ($l > $wmax) {
            if ($sep == -1) {
                if ($i == $j) {
                    $i++;
                }

            } else {
                $i = $sep + 1;
            }

            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
        } else {
            $i++;
        }

        }
        return $nl;
    }

    public $angle = 0;

    public function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->x;
        }

        if ($y == -1) {
            $y = $this->y;
        }

        if ($this->angle != 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }


    
}