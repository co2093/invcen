<?php 
namespace sig\pdf;
use Date;

class ClassPdf extends \TCPDF {

    public function Header(){

        $style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,64,128));
        $style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,64,128));

        $date = new Date();
        $fecha = $date->format('l, j \d\e F \d\e Y');
        
        $nombre = 'equipos_'.$date->format('Y-m-d').'.pdf';
       
        $data['fecha'] = $fecha;
        
        $this->Ln(3);
        $this->SetFont('Times', '', 12);
        $this->Cell(0,3,'CENSALUD, Universidad de El Salvador',0,1,'L');
        $this->Line(10, 10, 200, 10, $style);
        $this->Ln(5);
        $this->SetFont('Times', 'B', 14);
        $this->Cell(0,5,'REPORTE DE EQUIPOS',0,1,'C');       
        $this->Cell(0,5,$fecha,0,1,'C');
        $this->SetFont('Times', '', 10);
        $this->Cell(0,5,'Página '.$this->PageNo().' de '.$this->getAliasNbPages(),0,0,'C');       
        // Logo
        $image_file1 = 'dist/img/minerva.jpg';
        $this->Image($image_file1, 10, 15, 20, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $image_file2 ='dist/img/logocensalud.png';
        $this->Image($image_file2, 150, 15, 50, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Line(10, 35, 200, 35, $style2);
    }
   
             
}