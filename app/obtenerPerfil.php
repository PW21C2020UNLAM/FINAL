<?php

function obtenerDatosPerfil($usuario){
	$credenciales=obtenerCredencialesArchivoINI("database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

    if(!$connection){
        echo "Error del servidor, intente nuevamente más tarde...";
    }
    $consulta = "SELECT usuario, email FROM usuario WHERE usuario='$usuario'";
    $resultado = mysqli_query($connection, $consulta);
    $datos=mysqli_fetch_array($resultado);
    if($datos['usuario']==false){
        mysqli_close($connection);
        echo "Usuario NO suscripto...";
    }else{
        return $datos;
    }
}