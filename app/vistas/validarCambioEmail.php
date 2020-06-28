<?php
session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
include_once("../controladores/validar.php");
$user=$_SESSION['usuario'];
if(!esUsuarioValido($_SESSION['usuario'],$_SESSION['clave'])){
    header("Location: ../index.php");
}
$resultadoCambioEmail=false;
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

    <!--
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-facebook-official"></i></a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-instagram"></i></a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-snapchat"></i></a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-flickr"></i></a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-twitter"></i></a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-linkedin"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-search"></i></a>
    -->

</div>

<!-- w3-content defines a container for fixed size centered content,
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1600px">

    <!-- Registro -->
    <div class="w3-content w3-af" id="contenedorForm">
        <div class="w3-padding-32 w3-center w3-row">
            <div class="w3-container  w3-padding w3-light-grey w3-margin-top ">
                <div class="w3-container w3-black">
                    <h2 class="w3-lobster">
                        <?php
                        $nuevoEmail = $_POST['nuevoEmail'];
                        $user = $_SESSION['usuario'];
                        $resultadoCambioEmail=cambiarEmail($nuevoEmail,$user);
                        if($resultadoCambioEmail){
                            echo "¡Email cambiado exitosamente!";
                        }else{
                            echo "Email ya existente. Inténtelo de nuevo.";
                        }
                        ?>
                </div>
            </div>
            <?php
            if(!$resultadoCambioEmail){
                echo '<br><br></h2><a href="cambiarEmail.php"><input class="w3-btn w3-black" type="submit" value="Reintentar"></a>&nbsp;&nbsp;&nbsp;<a href="miPerfil.php" class="w3-btn w3-black">Cancelar</a><br><br>';
            }else{
                echo '<br><br></h2><a href="miPerfil.php"><input class="w3-btn w3-black" type="submit" value="Aceptar"></a>';
            }
            ?>
        </div>
    </div>

    <!-- END w3-content -->
</div>
</body>
</html>
