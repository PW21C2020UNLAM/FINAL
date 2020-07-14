<?php
	session_start();
    include_once("../controladores/validar.php");
    include_once("../controladores/cargarPublicaciones.php");
    include_once("../controladores/cargarNoticias.php");
	
	$user=$_SESSION['usuario'];
	if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
		header("Location: ../index.php");
	}else{
		$rol=obtenerRolUsuario($_SESSION['usuario']);
		if($rol!="contenidista"){
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
        <!-- Header -->
        <header class="w3-container w3-center w3-padding-48 w3-white">
            <a href="index.php" style="text-decoration-line:none"><h1 class="w3-xxxlarge"><b>Infonete S.A.</b></h1></a>
            <h6>Bienvenido al sitio de <span class="w3-tag">Infonete S.A.</span>
                <?php //echo obtenerFechaYHoraActual()?>
            </h6>
        </header>

		<!-- Navigation bar with social media icons -->
		<div class="w3-bar w3-black w3-hide-small">
			<div class="w3-bar-item">Contenidista: <?php echo $user?></div>
            <a href="miPerfil.php" class="w3-bar-item w3-button">Mi Perfil</a>
            <a href="cargarNuevaPublicacion.php" class="w3-bar-item w3-button">Nueva Publicación</a>
			<a href="cargarNuevaNoticia.php" class="w3-bar-item w3-button">Nueva Noticia</a>
            <a href="publicacionesRechazadas.php" class="w3-bar-item w3-button">Publicaciones Rechazadas</a>
			<a href="noticiasRechazadas.php" class="w3-bar-item w3-button">Noticias Rechazadas</a>
			<a href="logout.php" class="w3-bar-item w3-button">Cerrar Sesión</a>
		</div>

		<!-- w3-content defines a container for fixed size centered content, 
		and is wrapped around the whole page content, except for the footer in this example -->
		<div class="w3-content" style="max-width:1600px">

            <?php
            $resultado = obtenerPublicaciones("aprobada");
            if($resultado){
                $resultado->data_seek(0);

                echo "<div class=\"w3-bar w3-black w3-hide-small\">";
                while($fila = $resultado->fetch_assoc()){
                    echo "<a href=\"indexContenidista.php?publicacion=" . $fila['nombre'] . "\" class=\"w3-bar-item w3-button\">" . $fila['nombre'] . "</a>";
                }
                echo "</div>";

                $resultado->free();
            }
            ?>

            <!-- Image header -->
            <header class="w3-display-container w3-wide" id="home">
                <?php if(!isset($_GET['publicacion'])){
                    echo "<img class=\"w3-image\" src=\"../imagenes/noticias.jpg\" alt=\"Fashion Blog\" width=\"1600\" height=\"1060\" >";
                } else {
                    echo "<img class=\"w3-image\" src=\"../publicaciones/" . $_GET['publicacion'] . ".jpg\" width=\"1600\" height=\"1060\" >";
                } ?>
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

                <?php
                if(isset($_GET['publicacion'])){
                    mostrarNoticias(($_SESSION['usuario']), $_GET['publicacion']);
                } else {
                    echo "<div class=\"w3-center\"></div><hr>";
                }
                ?>

				<!-- END BLOG ENTRIES -->
				</div>

				<!-- About/Information menu -->
				<div class="w3-col l4">
					<!-- About Card -->
					<div class="w3-white w3-margin">
						<img src="../imagenes/avatar_girl2.jpg" alt="Jane" style="width:100%" class="w3-grayscale">
						<div class="w3-container w3-black">
							<h4>Infonete S.A.</h4>
							<p>Debido a la actual pandemia, la empresa “Infonete S.A.” está incursionando en el mundo de las noticias digitales, llevando sus diarios y revistas a la web.</p>
						</div>
					</div>
					<hr>

					<?php mostrarLoMasDescargado(); ?>

					<!-- Advertising -->
					<div class="w3-white w3-margin">
						<div class="w3-container w3-padding w3-black">
							<h4>Publicidad</h4>
						</div>
						<div class="w3-container w3-white">
							<div class="w3-container w3-display-container w3-light-grey w3-section" style="height:200px">
								<img src="../imagenes/x.jpg" style="width:90%">
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

		<?php mostrarFooter();?>
		
	</body>
</html>
