<?php
	session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
	include_once("../controladores/validar.php");
	include_once("../controladores/validarSuscripciones.php");
	$user=$_SESSION['usuario'];
	if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
		header("Location: ../index.php");
	}
	if(isset($_POST['eliminarSuscripcion'])){
		eliminarSuscripcion($_SESSION['usuario']);
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
			<a href="contacto.php" class="w3-bar-item w3-button">Contacto</a>
			<a href="index.php" class="w3-bar-item w3-button">Volver</a>
			
		</div>

		<!-- w3-content defines a container for fixed size centered content, 
		and is wrapped around the whole page content, except for the footer in this example -->
		<div class="w3-content" style="max-width:1600px">
					<!-- Registro -->
					<div class="w3-content w3-af" id="contenedorForm">
						<div class="w3-padding-32 w3-center w3-row">			
							<div class="w3-container  w3-padding w3-light-grey w3-margin-top ">
								<div class="w3-container w3-black">
									<h2 class="w3-lobster">Actualmente posee las siguientes suscripciones:</h2>
								</div><br>
                                <?php
                                $suscripciones = consultarSuscripciones($_SESSION['usuario']);
                                $suscripciones->data_seek(0);
                                echo "<table style='display: inline-block'>
                                      <tr style='text-align: left'>
                                            <td style='padding: 11px'><b>Nombre de publicación</b></td>
                                            <td style='padding: 11px'><b>Tipo de suscripción</b></td>
                                      </tr>
                                      <tr style='text-align: left'>
                                            <td style='padding: 11px'>Caras</td>
                                            <td style='padding: 11px'>Suscripción gratuita</td>
                                      </tr>
                                      <tr style='text-align: left'>
                                            <td style='padding: 11px'>El Grafico</td>
                                            <td style='padding: 11px'>Suscripción gratuita</td>
                                      </tr>";
                                while($fila = $suscripciones->fetch_assoc()){
                                echo "<tr style='text-align: left'>
                                            <td style='padding: 11px'>" . $fila['nombre'] . "</td>
                                            <td style='padding: 11px'>Suscripción paga</td>
                                            <td><a href=\"cancelarSuscripcion.php?publicacion=" . $fila['nombre'] . "\" class=\"w3-btn w3-black\">Cancelar suscripción</a></td>
                                      </tr>";
                                }
                                echo "</table><br/>";

                                $suscripciones->free();
                                ?>
							</div>
						</div> 
					</div>

			<!-- END w3-content -->
		</div>

		<?php mostrarFooter();?>
	</body>
</html>
