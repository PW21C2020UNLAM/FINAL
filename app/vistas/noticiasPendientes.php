<?php
	session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
	include_once("../controladores/validar.php");
	include_once("../controladores/cargarNoticias.php");
	
	$user=$_SESSION['usuario'];
	if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
		header("Location: ../index.php");
	}else{
		$rol=obtenerRolUsuario($_SESSION['usuario']);
		if($rol!="admin"){
			header(headerSegunRol($rol));
		}
	}
?>

<!DOCTYPE html>
<html>
	<title>Infonete S.A</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style>
		h1,h2,h3,h4,h5,h6 {font-family: "Oswald"}
		body {font-family: "Open Sans"}
	</style>

	<body class="w3-light-grey">
		<!-- Navigation bar with social media icons -->
		<div class="w3-bar w3-black w3-hide-small">
			<div class="w3-bar-item">Admin: <?php echo $user?></div>
			<a href="indexAdmin.php" class="w3-bar-item w3-button">Volver</a>
			<a href="verRechazadas.php" class="w3-bar-item w3-button">Ver rechazadas</a>
			<a href="logout.php" class="w3-bar-item w3-button">Salir</a>
		</div>

		<!-- w3-content defines a container for fixed size centered content, 
		and is wrapped around the whole page content, except for the footer in this example -->
		<div class="w3-content" style="max-width:1600px">

			<!-- Header -->
			<header class="w3-container w3-center w3-padding-48 w3-white">
				<h1 class="w3-xxxlarge"><b>Noticias pendientes</b></h1>
				<h6>Aquí figuran las noticias pendientes de aprobación de <span class="w3-tag">Infonete S.A.</span></h6>
			</header>

			<!-- Grid -->
			<div class="w3-row w3-padding w3-border">
				<div class="w3-col l8 s12">
					<?php mostrarNoticiaPendienteDeAprobacion("../noticiasPendientes/imagenes/"); ?>
				</div>
			</div>

			<!-- END w3-content -->
		</div>

		<?php mostrarFooter();?>
		
	</body>
</html>
