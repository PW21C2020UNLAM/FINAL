<?php
function obtenerCantidadDeLectores(){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
    if(!$connection){
        return false;
    }
    $res = 0;
    $consulta = "SELECT COUNT(*) as totalLectores FROM usuario WHERE rol='lector'";
    $resultado = mysqli_query($connection, $consulta);
    $columna=mysqli_fetch_array($resultado);
    if( isset($columna['totalLectores']) ){
        $res = $columna['totalLectores'];
    }
    mysqli_close($connection);
    return $res;
}

function obtenerPorcentajeDeSuscriptores(){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if(!$connection){
		return false;
	}
	$res = 0;
	$consulta = obtenerCantidadDeLectores();
	$consulta2 = "SELECT COUNT(DISTINCT usuario) as totalSuscriptores from suscripcion";
	$resultadoSuscriptores = mysqli_query($connection, $consulta2);
	$columnaSuscriptores=mysqli_fetch_array($resultadoSuscriptores);
	if( isset($consulta) && isset($columnaSuscriptores['totalSuscriptores']) ){
			$res = $columnaSuscriptores['totalSuscriptores']/$consulta;
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

function obtenerTotalNoticias($estado){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
    if(!$connection){
        return false;
    }
    $res = 0;
    $consulta = "SELECT COUNT(estado) as total FROM noticias WHERE estado='$estado'";
    $resultado = mysqli_query($connection, $consulta);
    $columna = mysqli_fetch_array($resultado);
    if( isset($columna['total']) ){
        $res = $columna['total'];
    }
    mysqli_close($connection);
    return $res;
}

function obtenerTotalPublicaciones($estado){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
    if(!$connection){
        return false;
    }
    $res = 0;
    $consulta = "SELECT COUNT(estado) as total FROM publicacion WHERE estado='$estado'";
    $resultado = mysqli_query($connection, $consulta);
    $columna = mysqli_fetch_array($resultado);
    if( isset($columna['total']) ){
        $res = $columna['total'];
    }
    mysqli_close($connection);
    return $res;
}

function mostrarReportesEnPDF($usuario){
    $reporte1 = "Cantidad de lectores: " . obtenerCantidadDeLectores();
    $reporte2 = "Porcentaje de lectores suscriptos: " . obtenerPorcentajeDeSuscriptores() . "%";
    $reporte3 = "Cantidad de contenidistas: " . obtenerCantidadContenidistasRegistrados();
    $reporte4 = "Total de noticias aceptadas: " . obtenerTotalNoticias("aceptada");
    $reporte5 = "Total de noticias pendientes: " . obtenerTotalNoticias("pendiente");
    $reporte6 = "Total de noticias rechazadas: " . obtenerTotalNoticias("rechazada");
    $reporte7 = "Total de publicaciones aprobadas: " . obtenerTotalPublicaciones("aprobada");
    $reporte8 = "Total de publicaciones pendientes: " . obtenerTotalPublicaciones("pendiente");
    $reporte9 = "Total de publicaciones pendientes: " . obtenerTotalPublicaciones("rechazada");
    $now = new DateTime();
    $fechaEmision = "Fecha de emisión del reporte: " . $now->format('d'. '/' .'m' . '/' . 'Y');

    $enlace = esSuscripto($usuario) ? '<form action="../controladores/mostrarReportePDF.php" method="post" enctype="application/x-www-form-urlencoded" target="_blank"><br>
										<input type="hidden" name="pdf" value="' . $reporte1 . "|" . $reporte2 . "|" . $reporte3 . "|" . $reporte4 . "|" . $reporte5 . '|' . $reporte6 . "|" . $reporte7 . "|" . $reporte8 . "|" . $reporte9 . "|" . $fechaEmision . '"/>
										<input type="hidden" name="usuario" value="' . $usuario . '"/>
										<input class="w3-bar-item w3-button w3-black" type="submit" value="Ver en PDF">
									</form>'

        : '<a href="../vistas/suscribirse.php" class="w3-bar-item w3-button w3-black">Ver en PDF</a>';

    return "$enlace";
}