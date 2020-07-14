<?php
session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
include_once("../controladores/validar.php");
include_once("../controladores/cargarPublicaciones.php");

$user=$_SESSION['usuario'];
if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
    header("Location: ../index.php");
}else{
    $rol=obtenerRolUsuario($_SESSION['usuario']);
    if($rol!="admin"&&$rol!="contenidista"){
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
    <a href="index.php" class="w3-bar-item w3-button">Volver</a>
</div>

<!-- w3-content defines a container for fixed size centered content,
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1600px">

    <!-- Header -->
    <header class="w3-container w3-center w3-padding-48 w3-white">
        <h1 class="w3-xxxlarge"><b>Publicaciones rechazadas</b></h1>
        <h6>Aquí figuran las publicaciones rechazadas por los administradores de <span class="w3-tag">Infonete S.A.</span></h6>
    </header>

    <!-- Grid -->
    <div class="w3-row w3-padding w3-border">
        <div class="w3-col l8 s12">
            <?php
            $resultado = obtenerPublicaciones("rechazada");
            if($resultado){
                $resultado->data_seek(0);

                while($fila = $resultado->fetch_assoc()){
                echo "<div class=\"w3-container w3-white w3-margin w3-padding-large\"><div class=\"w3-center\"><h3>" . $fila['nombre'] . "</h3><img src=\"../publicacionesRechazadas/"  . $fila['nombre'] . ".jpg\" style=\"width:100%\" class=\"w3-padding-16\"></div></div>";
                }

                $resultado->free();
            }
            ?>
        </div>
    </div>

    <!-- END w3-content -->
</div>

<?php mostrarFooter();?>

</body>
</html>
