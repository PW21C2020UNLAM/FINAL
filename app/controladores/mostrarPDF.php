<?php
	session_start();
	include_once("validar.php");
	include_once("cargarNoticias.php");
    include_once('../fpdf/fpdf.php');
	
	$campos=explode("|", utf8_decode($_POST['pdf']));
	
	$noticia = array(
		'titulo' => $campos[0],
		'tituloDesc' => $campos[1],
		'tituloDesc2' => $campos[2],
		'imagenEXT' => $campos[3],
		'articulo' => $campos[4],
	);
	
	class PDF extends FPDF{
		
		function Header(){
			$campos=explode("|", utf8_decode($_POST['pdf']));
	
			$noticia = array(
			'titulo' => $campos[0],
			'tituloDesc' => $campos[1],
			'tituloDesc2' => $campos[2],
			'imagenEXT' => $campos[3],
			'articulo' => $campos[4],
		);
			$this->SetFont('Arial','B',15);
			$this->Cell(-4);
			$this->Cell(200,10,$noticia['titulo'],1,0,'C');
			$this->Ln(20);	   
		}

		function Footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,0,'Page '.$this->PageNo(),0,0,'C');
		}

		function TituloArchivo($num,$label){
			$this->SetY(55);
			$this->SetFont('Arial','',12);
			$this->SetFillColor(200,220,255);
			$this->Cell(0,6,"Archivo $num : $label",0,1,'L',true);
			$this->Ln(4);
		}

		function CuerpoArchivo(){
			$campos=explode("|", utf8_decode($_POST['pdf']));
	
			$noticia = array(
			'titulo' => $campos[0],
			'tituloDesc' => $campos[1],
			'tituloDesc2' => $campos[2],
			'imagenEXT' => $campos[3],
			'articulo' => $campos[4],
		);
			$this->Image($noticia['imagenEXT'],null,null,190);
			$this->SetFont('Times','',14);
			$noticia['articulo']=strip_tags($noticia['articulo']);
			$this->MultiCell(0,8,$noticia['articulo']);
			$this->Ln();
		}

		function ImprimirArchivo($num,$title){
			$this->AddPage();
			$this->TituloArchivo($num,$title);
			$this->CuerpoArchivo();
		}
	}
	
	if(isset($_POST['pdf'])){
		contarDescargas($_POST['usuario'], $_POST['idNoticia']);
		$pdf=new PDF();
		$pdf->SetTitle($noticia['titulo']);
		$pdf->SetY(65);
		$pdf->ImprimirArchivo(1,$noticia['tituloDesc'].", ".$noticia['tituloDesc2']);
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
	
	function contarDescargas($usuario, $idNoticia){
		$rol=obtenerRolUsuario($usuario);
		if($rol=='admin'||$rol=='contenidista'){
			return;
		}else{
			$credenciales=obtenerCredencialesArchivoINI("../database.ini");
			$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');
			if($connection){
				$datab = "pw2";
				$db = mysqli_select_db($connection,$datab);
				if (!$db){
					mysqli_close($connection);
					return;
				}else{
					$consulta = "SELECT * FROM noticias WHERE idNoticia='$idNoticia'";
					$resultado = mysqli_query($connection, $consulta);
					if ($resultado) {
						$fila = mysqli_fetch_array($resultado);
						if(isset($fila['cantidadDescargas'])){
							$cantDescargas = $fila['cantidadDescargas'];
							$cantDescargas++;
							$consulta = "UPDATE noticias SET cantidadDescargas=$cantDescargas WHERE idNoticia='$idNoticia'";
							$resultado = mysqli_query($connection, $consulta);
						}
					}
				}
				mysqli_close($connection);
			}			
		}
	}
	
?>