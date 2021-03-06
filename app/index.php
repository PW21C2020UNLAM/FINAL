<?php
session_start();
if (isset($_SESSION['usuario'])) {
    // $rol=obtenerRolUsuario($_SESSION['usuario']);
    // header(headerSegunRol($rol));
    header("Location: vistas/indexLector.php");
}
include_once("controladores/validar.php");
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

<!-- w3-content defines a container for fixed size centered content,
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1600px">

    <!-- Header -->
    <header class="w3-container w3-center w3-padding-48 w3-white">
        <h1 class="w3-xxxlarge"><b>Infonete S.A.</b></h1>
        <h6>Bienvenido al sitio de <span class="w3-tag">Infonete S.A.</span></h6>
    </header>

    <!-- Navigation bar with social media icons -->
    <div class="w3-bar w3-black w3-hide-small">
        <a href="vistas/iniciarSesion.php" class="w3-bar-item w3-button">Iniciar Sesión</a>
        <a href="vistas/registro.php" class="w3-bar-item w3-button">Registrarse</a>

    </div>

    <!-- Image header -->
    <header class="w3-display-container w3-wide" id="home">
        <img class="w3-image" src="./imagenes/noticias.jpg" alt="Fashion Blog" width="1600" height="1060">
        <div class="w3-display-left w3-padding-large">
            <h1 class="w3-text-white">Infonete S.A</h1>
            <h1 class="w3-jumbo w3-text-white w3-hide-small"><b>NOTICIAS DIGITALES</b></h1>
            <h6><button class="w3-button w3-white w3-padding-large w3-large w3-opacity w3-hover-opacity-off" onclick="document.getElementById('subscribe').style.display='block'">
                    <a href="vistas/iniciarSesion.php" class="w3-bar-item">Iniciar Sesión</a>
                </button></h6>
        </div>
    </header>

    <?php mostrarFooter();?>
</body>
</html>

