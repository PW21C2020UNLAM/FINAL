<?php

include_once('../fpdf/fpdf.php');

function mostrarNoticias($directorio,$usuario){
	$arrayDirectorio = scandir($directorio, 1);
	foreach ($arrayDirectorio as &$archivo ){
		if( $archivo!="." && $archivo!=".." ){
			echo imprimirNoticia($archivo,$directorio,$usuario);
		}
	}
}

function imprimirNoticia($archivo, $directorio, $usuario){
	$nombre=str_replace(".jpg",".txt",$archivo);
	$noticia=obtenerNoticia($nombre, $directorio);
	
	$enlace=esSuscripto($usuario)?'<form action="../controladores/mostrarPDF.php" method="post" enctype="application/x-www-form-urlencoded" target="_blank"><br><br>
										<input type="hidden" name="pdf" value="'.$noticia['titulo']."|".$noticia['tituloDesc']."|".$noticia['tituloDesc2']."|".$directorio.$noticia['imagenEXT']."|".$noticia['articulo'].'"/>
										
										<input class="w3-btn w3-black" type="submit" value="Descargar como PDF"><br><br>
									</form>'
								
								:'<a href="../vistas/suscribirse.php" class="w3-btn w3-black">Descargar como PDF</a>';

	return '<!-- Blog entry --><div class="w3-container w3-white w3-margin w3-padding-large"><div class="w3-center"><h3>'.$noticia['titulo'].'</h3><h5>'.$noticia['tituloDesc'].', <span class="w3-opacity">'.$noticia['tituloDesc2'].'</span></h5></div><div class="w3-justify"><img src="'.$directorio.$noticia['imagenEXT'].'" style="width:100%" class="w3-padding-16"><p>'.$noticia['articulo'].'</p></div>'.$enlace.'</div><hr>';
}

function esSuscripto($usuario){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

	if(!$connection){
		return false;
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection,$datab);
		if (!$db){
			echo "Error al acceder a la base de datos";
			mysqli_close($connection);
			return false;
		}else{
			$consulta = "SELECT suscriptor FROM usuario WHERE usuario='$usuario'";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$columna=mysqli_fetch_array($resultado);
				if($columna['suscriptor']==true){
					mysqli_close($connection);
					return true;
				}
			}
		}
		mysqli_close($connection);
	}
	return false;
}

function obtenerNoticia($nombreArchivo,$directorio){
	$directorio=str_replace("imagenes","texto",$directorio);
	$nombre=$directorio.$nombreArchivo;
	$fp = fopen($nombre, "rb");
	$datos = fread($fp, filesize($nombre));
	fclose($fp);
	$campos=explode("|", $datos);
	$noticia = array(
		'titulo' => $campos[0],
		'tituloDesc' => $campos[1],
		'tituloDesc2' => $campos[2],
		'imagenEXT' => $campos[3],
		'articulo' => $campos[4],
	);
	return $noticia;
}

function mostrarNoticiaPendienteDeAprobacion(){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if($connection){
		$datab = "pw2";
		$db = mysqli_select_db($connection, $datab);
		if (!$db){
			mysqli_close($connection);
			echo "No hay noticias pendientes de aprobación...";
			return;
		}else{
			$consulta = "SELECT idNoticia FROM noticias WHERE estado='pendiente' ORDER BY idNoticia ASC";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$columna=mysqli_fetch_array($resultado, MYSQLI_NUM);
				if(isset($columna[0])){
					echo imprimirNoticiaPendiente($columna[0].'.jpg', '../noticiasPendientes/imagenes/');
				}else{
					echo "No hay noticias pendientes de aprobación...";
				}
			}
		}
		mysqli_close($connection);
	}else{
		echo "No hay noticias pendientes de aprobación...";
		return;
	}
}

function imprimirNoticiaPendiente($archivo, $directorio){
	$nombre=str_replace(".jpg",".txt",$archivo);
	$noticia=obtenerNoticia($nombre,$directorio);
	echo '<!-- Blog entry --><div class="w3-container w3-white w3-margin w3-padding-large"><div class="w3-center"><h3>';
	echo $noticia['titulo'];
	echo '</h3><h5>';
	echo $noticia['tituloDesc'];
	echo ', <span class="w3-opacity">';
	echo $noticia['tituloDesc2'];
	echo '</span></h5></div><div class="w3-justify"><img src="'.$directorio;
	echo $noticia['imagenEXT'];
	echo '" style="width:100%" class="w3-padding-16"><p>';
	echo $noticia['articulo'];
	echo '</div>  
								<form action="aceptarNoticia.php" method="post" enctype="application/x-www-form-urlencoded">
									<input type="hidden" name="directorio" value="'.$nombre.'"/>
									<input class="w3-btn w3-black" type="submit" value="Validar noticia">
								</form><br>
								<form action="rechazarNoticia.php" method="post" enctype="application/x-www-form-urlencoded">
									<input type="hidden" name="directorio" value="'.$nombre.'"/>
									<input class="w3-btn w3-black" type="submit" value="Rechazar noticia">
								</form>
							</div>
						</div><hr>';
}

function obtenerFechaYHoraActual(){ // Sólo para nombrar los archivos
	$fecha = new DateTime();
	$fecha->modify('-5 hours');
	return $fecha->format('YmdHis');
}

function subirNoticia($tituloForm,$subtituloForm,$fechaForm,$imagenForm_tmp,$cuerpoForm,$paqueteForm){
	$nombre=obtenerFechaYHoraActual();
	$file = fopen("../noticiasPendientes/texto/" . $nombre. ".txt", "w");
	if(!$file){
		return "ERROR";
	}
	if(!move_uploaded_file($imagenForm_tmp, "../noticiasPendientes/imagenes/" . $nombre . ".jpg")){
		fclose($file);
		return "ERROR";
	}
	fwrite($file, "$tituloForm|$subtituloForm|$fechaForm|$nombre".".jpg"."|$cuerpoForm");
	fclose($file);
	return cargarNoticiaEnBaseDeDatos($nombre, $paqueteForm);
}

function cargarNoticiaEnBaseDeDatos($nombre, $paqueteForm){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

	if(!$connection){
		return "No se ha podido conectar con el servidor";
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection, $datab);
		if (!$db){
			mysqli_close($connection);
			return "Error al acceder a la base de datos";
		}else{
			$esPremium = ( $paqueteForm=="ninguno"? false : true ); // los paquetes son 'ninguno', 'diario' y 'revista'
			$sql = "INSERT INTO noticias (idNoticia, esPremium, paquete, cantidadDescargas, estado) VALUES ('$nombre', '$esPremium', '$paqueteForm', 0, 'pendiente')"; // los estados son 'pendiente', 'aprobada' y 'rechazada'
			if (!mysqli_query($connection, $sql)) {
				mysqli_close($connection);
				return "No se pudo insertar en la base de datos";
			}
		}
	}
	mysqli_close($connection);
	return "¡Se subió exitosamente la noticia!";
	
}

function moverNoticiaAceptada($fileNameTXT){
	$id=str_replace(".txt","",$fileNameTXT);
	cambiarEstadoNoticia($id,'aceptada');
	$fileNameJPG=str_replace(".txt",".jpg",$fileNameTXT);
	$dirOrigen1="../noticiasPendientes/imagenes/".$fileNameJPG;
	$dirOrigen2="../noticiasPendientes/texto/".$fileNameTXT;
	$dirDestino1="../noticias/imagenes/".$fileNameJPG;
	$dirDestino2="../noticias/texto/".$fileNameTXT;
	rename($dirOrigen1,$dirDestino1);
	rename($dirOrigen2,$dirDestino2);
}

function moverNoticiaRechazada($fileNameTXT){
	$id=str_replace(".txt","",$fileNameTXT);
	cambiarEstadoNoticia($id,'rechazada');
	$fileNameJPG=str_replace(".txt",".jpg",$fileNameTXT);
	$dirOrigen1="../noticiasPendientes/imagenes/".$fileNameJPG;
	$dirOrigen2="../noticiasPendientes/texto/".$fileNameTXT;
	$dirDestino1="../noticiasRechazadas/imagenes/".$fileNameJPG;
	$dirDestino2="../noticiasRechazadas/texto/".$fileNameTXT;
	rename($dirOrigen1,$dirDestino1);
	rename($dirOrigen2,$dirDestino2);
}

function cambiarEstadoNoticia($id, $nuevoEstado){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if($connection){
		$consulta = "UPDATE noticias SET estado='$nuevoEstado' WHERE idNoticia='$id'";
		$resultado = mysqli_query($connection, $consulta);
		if( mysqli_query($connection, $consulta) ){
			mysqli_close($connection);
		}
	}
}