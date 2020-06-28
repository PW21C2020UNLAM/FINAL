<?php
	session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
	include_once("validar.php");
	include_once("cargarNoticias.php");
	
	$user=$_SESSION['usuario'];
	if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
		header("Location: index.php");
	}else{
		$rol=obtenerRolUsuario($_SESSION['usuario']);
		if($rol!="contenidista"){
			header(headerSegunRol($rol));
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box;}

		input[type=text], select, textarea {
		width: 100%;
		padding: 12px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
		}

		input[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		}

		input[type=submit]:hover {
		background-color: #45a049;
		}

		.container {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
		}
		
		</style>
	</head>
	<body>
		<div class="w3-bar w3-black w3-hide-small">
			<a href="indexLector.php" class="w3-bar-item w3-button">Volver</a>
			
			</div>
			
			<h1 class="w3-xxlarge"><b>- Cargar noticia nueva -</b></h1>

			<div class="container">
				<form action="validarSubidaDeNoticia.php" method="POST" enctype="multipart/form-data">
					<label for="fname">Título de la noticia:</label>
					<input type="text" id="fname" name="tituloForm" placeholder="Escribe el título de la noticia..." required>

					<label for="lname">Subtítulo de la noticia:</label>
					<input type="text" id="lname" name="subtituloForm" placeholder="Escribe el subtítulo de la noticia..."required>

					<label for="lname">Fecha de la noticia (formato DD de MES de AAAA):</label>
					<input type="text" id="date" name="fechaForm" placeholder="Escribe la fecha de la noticia..."required>
					
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
					<label for="lname">Subir imagen:</label><br><br>
					<input type="file" name="imagenForm" accept="image/*" required><br><br>
					
					<label for="subject">Cuerpo de la noticia (usar formato HTML):</label>
					<textarea id="subject" name="cuerpoForm" placeholder="Escribe algo..." style="height:200px" required></textarea>

					<input type="submit" value="Enviar">
				</form>
		
		</div>

	</body>
</html>
