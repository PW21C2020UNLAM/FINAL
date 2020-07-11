<?php
	// renombrar archivo como "mostrarSuscripciones()" -> hacer consulta a la base de datos y que muestre, de haber alguna, las suscripciones disponibles
function consultarSuscripciones($usuario){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

	if(!$connection){
		echo "Error del servidor, intente nuevamente más tarde...";
	}
	$consulta = "SELECT nombre FROM publicacion INNER JOIN suscripcion ON publicacion.idPublicacion = 
                    suscripcion.idPublicacion WHERE usuario LIKE '$usuario';";
	$resultado = mysqli_query($connection, $consulta);
	if($resultado){
	    return $resultado;
    }
}

function eliminarSuscripcion($usuario){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

	if(!$connection){
		return;
	}
	$consulta = "SELECT suscriptor FROM usuario WHERE usuario='$usuario'";
	$resultado = mysqli_query($connection, $consulta);
	$columna=mysqli_fetch_array($resultado);
	if(  $columna['suscriptor']==true ){
		$consulta = "UPDATE usuario SET suscriptor=false WHERE usuario='$usuario'";
		if(mysqli_query($connection,$consulta)){
			mysqli_close($connection);
			return;
		}else{
			mysqli_close($connection);
			return;
		}
	}else{
		mysqli_close($connection);
		return;
	}
	mysqli_close($connection);
	return;
}
