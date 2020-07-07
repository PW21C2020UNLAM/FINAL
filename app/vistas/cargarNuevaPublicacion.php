<?php
session_start(); // session_id() DEVUELVE ID DE SESIÓN ACTUAL O CADENA VACÍA "" SI NO HAY SESIÓN ACTUAL
include_once("../controladores/validar.php");
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
    <a href="./indexContenidista.php" class="w3-bar-item w3-button">Volver</a>

</div>

<h1 class="w3-xxlarge"><b>- Cargar publicación nueva -</b></h1>

<div class="container">
    <form action="validarSubidaDePublicacion.php" method="POST" enctype="multipart/form-data">
        <label for="fname">Nombre de la publicación:</label>
        <input type="text" id="fname" name="nombreForm" placeholder="Escribe el nombre de la publicacion...">

        <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        <label for="lname">Subir imagen para la portada:</label><br><br>
        <input type="file" name="imagenForm" accept="image/*"><br><br>

        <input type="submit" value="Enviar">
    </form>

</div>

</body>
</html>
