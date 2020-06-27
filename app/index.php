<?php
	session_start();
	include_once("validar.php");
	include_once("cargarNoticias.php");
	if (isset($_SESSION['usuario'])) {
		$rol=obtenerRolUsuario($_SESSION['usuario']);
		header(headerSegunRol($rol));
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
			<a href="iniciarSesion.php" class="w3-bar-item w3-button">Iniciar Sesión</a>
			<a href="registro.php" class="w3-bar-item w3-button">Registrarse</a>
			
		</div>

		<!-- w3-content defines a container for fixed size centered content, 
		and is wrapped around the whole page content, except for the footer in this example -->
		<div class="w3-content" style="max-width:1600px">

			<!-- Header -->
			<header class="w3-container w3-center w3-padding-48 w3-white">
				<h1 class="w3-xxxlarge"><b>Infonete S.A.</b></h1>
				<h6>Bienvenido al sitio de <span class="w3-tag">Infonete S.A.</span></h6>
			</header>

			<!-- Image header -->
			<header class="w3-display-container w3-wide" id="home">
				<img class="w3-image" src="./imagenes/noticias.jpg" alt="Fashion Blog" width="1600" height="1060">
				<div class="w3-display-left w3-padding-large">
					<h1 class="w3-text-white">Infonete S.A</h1>
					<h1 class="w3-jumbo w3-text-white w3-hide-small"><b>NOTICIAS DIGITALES</b></h1>
					<h6><button class="w3-button w3-white w3-padding-large w3-large w3-opacity w3-hover-opacity-off" onclick="document.getElementById('subscribe').style.display='block'">
					<a href="iniciarSesion.php" class="w3-bar-item">Iniciar Sesión</a>
					</button></h6>
				</div>
			</header>

            <!-- Footer -->
            <footer class="w3-container" style="padding:32px; background-color:black; color:white; display:inline-flex; width:100%">
                <div style="padding-left:10%;">
                    <b>Infonete S.A.</b><br>
                    <a href="index.php" style="text-decoration:none">Inicio</a><br>
                    <a href="contacto.php" style="text-decoration:none">Contacto</a><br>
                    <a href="mailto:redaccion@infonete.com" style="text-decoration:none">Redacción</a><br>
                    <a href="mailto:comercial@infonete.com" style="text-decoration:none">Comercial</a>
                </div>
                <div style="padding-left:26%;">
                    <b>Redes Sociales</b><br>
                    <a href="http://www.instagram.com" style="text-decoration:none">Instagram</a><br>
                    <a href="http://www.facebook.com" style="text-decoration:none">Facebook</a><br>
                    <a href="http://www.twitter.com" style="text-decoration:none">Twitter</a>
                </div>
                <div style="padding-left:26%;">
                    <b>Alumnos</b><br>
                    Pereyra, Maximiliano<br>
                    Rodriguez, Sebastian<br>
                    Ovejero, Emiliano
                </div>
            </footer>
	</body>
</html>
