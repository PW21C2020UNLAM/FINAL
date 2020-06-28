<?php
	// renombrar archivo como "mostrarSuscripciones()" -> hacer consulta a la base de datos y que muestre, de haber alguna, las suscripciones disponibles
function consultarSuscripciones($usuario){
	$credenciales=obtenerCredencialesArchivoINI("database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

	if(!$connection){
		echo "Error del servidor, intente nuevamente más tarde...";
	}
	$consulta = "SELECT suscriptor FROM usuario WHERE usuario='$usuario'";
	$resultado = mysqli_query($connection, $consulta);
	$columna=mysqli_fetch_array($resultado);
	if(  $columna['suscriptor']==false ){
		mysqli_close($connection);
		echo "Usuario NO suscripto...";
	}else{
		mysqli_close($connection);
		echo 'Usuario suscripto</label> <input type="hidden" name="eliminarSuscripcion" value=""/><input class="w3-btn w3-black" type="submit" value="Eliminar suscripcion"> <br><br>';
	}
}

function eliminarSuscripcion($usuario){
	$credenciales=obtenerCredencialesArchivoINI("database.ini");
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
