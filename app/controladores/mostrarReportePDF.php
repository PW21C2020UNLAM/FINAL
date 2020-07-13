<?php
session_start();
include_once("validar.php");
include_once("cargarNoticias.php");
include_once('../fpdf/fpdf.php');

class PDF extends FPDF
{

    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(-4);
        $this->Cell(200, 10, "Reportes de Infonete S.A.", 1, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 0, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function CuerpoArchivo()
    {
        $campos = explode("|", utf8_decode($_POST['pdf']));

        $reporte = array(
            'reporte1' => $campos[0],
            'reporte2' => $campos[1],
            'reporte3' => $campos[2],
            'reporte4' => $campos[3],
            'reporte5' => $campos[4],
            'reporte6' => $campos[5],
            'reporte7' => $campos[6],
            'reporte8' => $campos[7],
            'reporte9' => $campos[8],
            'fechaEmision' => $campos[9],
        );
        $this->SetFont('Arial', '', 14);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte1']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte2']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte3']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte4']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte5']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte6']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte7']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte8']);
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['reporte9']);
        $this->Ln();
        $this->Ln();
        $this->MultiCell(0, 8, $reporte['fechaEmision']);
    }

    function ImprimirArchivo($num, $title)
    {
        $this->AddPage();
        $this->CuerpoArchivo();
    }
}

if(isset($_POST['pdf'])){
    $pdf=new PDF();
    $pdf->SetTitle("Reportes de Infonete S.A.");
    $pdf->SetY(65);
    $pdf->ImprimirArchivo(1,"Reportes de Infonete S.A.");
    $pdf->Output();

    }else{
        if (isset($_SESSION['usuario'])) {
            $rol=obtenerRolUsuario($_SESSION['usuario']);
            header(headerSegunRol($rol));
        }else{
            $rol=obtenerRolUsuario($_SESSION['usuario']);
            header("Location: index".$rol.".php");
        }

}

?>