<?php
	session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
	include_once("validar.php");
	include_once("cargarNoticias.php");
	insertarAdmin("su","su");
	$user=$_SESSION['usuario'];
	if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
		header("Location: index.php");
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
			<a href="noticiasPendientes.php" class="w3-bar-item w3-button">Gestionar noticias</a>
			<a href="registroContenidista.php" class="w3-bar-item w3-button">Registrar Contenidista</a>
			<a href="cambiarClave.php" class="w3-bar-item w3-button">Cambiar clave</a>
			<a href="eliminarCuenta.php" class="w3-bar-item w3-button">Eliminar cuenta</a>
			<a href="gestionarUsuarios.php" class="w3-bar-item w3-button">Gestionar usuarios</a>
			<a href="logout.php" class="w3-bar-item w3-button">Salir</a>
		</div>

		<!-- w3-content defines a container for fixed size centered content, 
		and is wrapped around the whole page content, except for the footer in this example -->
		<div class="w3-content" style="max-width:1600px">

			<!-- Header -->
			<header class="w3-container w3-center w3-padding-48 w3-white">
				<h1 class="w3-xxxlarge"><b>Infonete S.A.</b></h1>
				<h6>Bienvenido al sitio de <span class="w3-tag">Infonete S.A.</span>
					<?php //echo obtenerFechaYHoraActual()?>
				</h6>
			</header>

			<!-- Image header -->
			<header class="w3-display-container w3-wide" id="home">
				<img class="w3-image" src="./imagenes/noticias.jpg" alt="Fashion Blog" width="1600" height="1060">
				<div class="w3-display-left w3-padding-large">
					<h1 class="w3-text-white">Infonete S.A</h1>
					<h1 class="w3-jumbo w3-text-white w3-hide-small"><b>NOTICIAS DIGITALES</b></h1>
					<h1 class="w3-text-white">Usuario: <?php echo $_SESSION['usuario'];?></h1>
				</div>
			</header>

			<!-- Grid -->
			<div class="w3-row w3-padding w3-border">

				<!-- Blog entries -->
				<div class="w3-col l8 s12">

				<?php mostrarNoticias("./noticias/imagenes/",($_SESSION['usuario'])); ?>

				<!-- END BLOG ENTRIES -->
				</div>

				<!-- About/Information menu -->
				<div class="w3-col l4">
					<!-- About Card -->
					<div class="w3-white w3-margin">
						<img src="./imagenes/avatar_girl2.jpg" alt="Jane" style="width:100%" class="w3-grayscale">
						<div class="w3-container w3-black">
							<h4>Infonete S.A.</h4>
							<p>Debido a la actual pandemia, la empresa “Infonete S.A.” está incursionando en el mundo de las noticias digitales, llevando sus diarios y revistas a la web.</p>
						</div>
					</div>
					<hr>

					<!-- Posts -->
					<div class="w3-white w3-margin">
						<div class="w3-container w3-padding w3-black">
							<h4>Popular Posts</h4>
						</div>
						
						<ul class="w3-ul w3-hoverable w3-white">
							<li class="w3-padding-16">
								<img src="./imagenes/avatar_smoke.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
								<span class="w3-large">Denim</span>
								<br>
								<span>Sed mattis nunc</span>
							</li>
							
							<li class="w3-padding-16">
								<img src="./imagenes/bandmember.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
								<span class="w3-large">Sweaters</span>
								<br>
								<span>Praes tinci sed</span>
							</li>
							
							<li class="w3-padding-16">
								<img src="./imagenes/workshop.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
								<span class="w3-large">Workshop</span>
								<br>
								<span>Ultricies congue</span>
							</li>
							
							<li class="w3-padding-16">
								<img src="./imagenes/avatar_smoke.jpg" alt="Image" class="w3-left w3-margin-right w3-sepia" style="width:50px">
								<span class="w3-large">Trends</span>
								<br>
								<span>Lorem ipsum dipsum</span>
							</li>
						</ul>
					</div>
					<hr>

					<!-- Advertising -->
					<div class="w3-white w3-margin">
						<div class="w3-container w3-padding w3-black">
							<h4>Publicidad</h4>
						</div>
						<div class="w3-container w3-white">
							<div class="w3-container w3-display-container w3-light-grey w3-section" style="height:200px">
								<img src="./imagenes/x.jpg" style="width:90%">
								<b><p>La felicidad tiene un color</p></b>
								<!--
									<span class="w3-display-middle">Your AD Here</span>
								-->
							</div>
						</div>
					</div>
					<hr>

					<!-- END About/Intro Menu -->
				</div>

				<!-- END GRID -->
			</div>

			<!-- END w3-content -->
		</div>

		<!-- Footer -->
		<footer class="w3-container w3-dark-grey" style="padding:32px"><p>Pereyra, Maximiliano Gastón</p><p>DNI: 39.756.173</p><p>Programación Móvil II</p></footer>
		
	</body>
</html>
