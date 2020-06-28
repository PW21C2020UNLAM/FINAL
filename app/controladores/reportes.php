<?php

function obtenerPorcentajeDeSuscriptores(){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if(!$connection){
		return false;
	}
	$res = 0;
	$consulta = "SELECT COUNT(*) as totalLectores FROM usuario WHERE rol='lector'";
	$consulta2 = "SELECT COUNT(*) as totalSuscriptores FROM usuario WHERE rol='lector' AND suscriptor=true";
	$resultadoLectores = mysqli_query($connection, $consulta);
	$resultadoSuscriptores = mysqli_query($connection, $consulta2);
	$columnaLectores=mysqli_fetch_array($resultadoLectores);
	$columnaSuscriptores=mysqli_fetch_array($resultadoSuscriptores);
	if( isset($columnaLectores['totalLectores']) && isset($columnaSuscriptores['totalSuscriptores']) ){
			$res = $columnaSuscriptores['totalSuscriptores']/$columnaLectores['totalLectores'];
		}
	mysqli_close($connection);
	return number_format(($res)*100,2,".",",");
}

function obtenerCantidadContenidistasRegistrados(){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if(!$connection){
		return false;
	}
	$res = 0;
	$consulta = "SELECT COUNT(*) as total FROM usuario WHERE rol='contenidista'";
	$consultaContenidistas = mysqli_query($connection, $consulta);
	$totalContenidistas=mysqli_fetch_array($consultaContenidistas);
	if( isset($totalContenidistas['total']) ){
			$res = $totalContenidistas['total'];
		}
	mysqli_close($connection);
	return $res;
}
