<?php
	session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
	include_once("../controladores/validar.php");
	include_once("../controladores/cargarNoticias.php");
	
	if(isset($_SESSION['usuario'])){
		if(esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
			$rol=obtenerRolUsuario($_SESSION['usuario']);
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
    <script src="https://apis.google.com/js/platform.js" async defer>
        function onSignIn(googleUser) {
            profile = $googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        }
    </script>
    <meta name="google-signin-client_id" content="415665678281-de2napkbfkl6ea2pl7jrg1gl1mlqh49s.apps.googleusercontent.com">
	<style>
		h1,h2,h3,h4,h5,h6 {font-family: "Oswald"}
		body {font-family: "Open Sans"}
	</style>

	<body class="w3-light-grey">

		<!-- Navigation bar with social media icons -->
		<div class="w3-bar w3-black w3-hide-small">
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
									<h2 class="w3-lobster">Iniciar Sesión</h2>
								</div>   
								<form action="validarLogin.php" method="post" enctype="application/x-www-form-urlencoded"><br><br>
									<label class="w3-text-brown">Usuario:</label> <input class="w3-input w3-border w3-sand " type="text" name="usuario" required><br><br>
									<label class="w3-text-brown">Clave:</label> <input class="w3-input w3-border w3-sand" type="password" name="clave" required><br><br>
									<input class="w3-btn w3-black" type="submit" value="Ingresar"><br><br>
                                    <div class="g-signin2" style="display:inline-block; text-align:center" data-onsuccess="onSignIn"></div><br><br>
									<a href="registro.php">¿No estás registrado?</a>
								</form>
							</div>
						</div> 
					</div>

			<!-- END w3-content -->
		</div>

		<?php mostrarFooter();?>
	</body>
</html>
