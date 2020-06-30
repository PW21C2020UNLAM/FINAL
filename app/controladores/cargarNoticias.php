<?php

include_once('../fpdf/fpdf.php');

function mostrarNoticias($usuario){
	$arrayIDNoticias = obtenerNoticiasSegunUsuario($usuario,'aceptadas'); // Debe contener los ID's de las noticias
	foreach ($arrayIDNoticias as &$noticiaID ){
		echo imprimirNoticia($noticiaID,"../noticias/imagenes/",$usuario);
	}
}

function mostrarNoticiasRechazadas($usuario){
	$arrayIDNoticias = obtenerNoticiasSegunUsuario($usuario,'rechazadas'); // Debe contener los ID's de las noticias
	foreach ($arrayIDNoticias as &$noticiaID ){
		echo imprimirNoticia($noticiaID,"../noticiasRechazadas/imagenes/",$usuario);
	}
}

function obtenerNoticiasSegunUsuario($usuario, $condicion){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if($connection){
		$datab = "pw2";
		$db = mysqli_select_db($connection, $datab);
		if (!$db){
			mysqli_close($connection);
			echo "No se encontraron noticias para el usuario actual...";
			return null;
		}else{
			$suscripto = obtenerSuscripcion($usuario);
			$consulta="";
			if($condicion=='aceptadas'){
				if($suscripto){
					$consulta = "SELECT idNoticia FROM noticias WHERE estado='aceptada' ORDER BY idNoticia DESC";
				}else{
					$consulta = "SELECT idNoticia FROM noticias WHERE estado='aceptada' AND esPremium=false ORDER BY idNoticia DESC";
				}
			}else{
				if($condicion=='rechazadas'){
					$consulta = "SELECT idNoticia FROM noticias WHERE estado='rechazada' ORDER BY idNoticia DESC";
				}else{
					$consulta = "SELECT idNoticia FROM noticias WHERE estado='pendiente' ORDER BY idNoticia ASC";
				}
			}
			$resultado = mysqli_query($connection, $consulta);
			$retorno;
			if ($resultado) {
				while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
					$nuevo_array[]=$fila;
				}
				foreach($nuevo_array as $fila){
					foreach($fila as $columna ){
						$columna=$columna.'.jpg';
						$retorno[]=$columna;
					}
				}
				mysqli_close($connection);
				return $retorno;
			}
		}
		mysqli_close($connection);
	}else{
		echo "No se encontraron noticias para el usuario actual...";
		return null;
	}
}

function obtenerSuscripcion($usuario){ // retorna true o false indicando si está suscripto o no...
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if($connection){
		$datab = "pw2";
		$db = mysqli_select_db($connection, $datab);
		if (!$db){
			mysqli_close($connection);
			return false;
		}else{
			$consulta = "SELECT suscriptor FROM usuario WHERE usuario='$usuario'";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$columna=mysqli_fetch_array($resultado);
				if(isset($columna['suscriptor'])){
					mysqli_close($connection);
					return $columna['suscriptor'];
				}
			}
		}
		mysqli_close($connection);
	}
	return false;
}

function imprimirNoticia($idNoticia, $directorioDeImagenes, $usuario){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');
	if($connection){
		$datab = "pw2";
		$db = mysqli_select_db($connection, $datab);
		if (!$db){
			mysqli_close($connection);
			echo "No hay noticias disponibles en este momento...";
			return;
		}else{
			$consulta = "SELECT * FROM noticias WHERE idNoticia='$idNoticia'";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$fila=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
				if(isset($fila['idNoticia'])){
					$enlace=esSuscripto($usuario)?'<form action="../controladores/mostrarPDF.php" method="post" enctype="application/x-www-form-urlencoded" target="_blank"><br><br>
										<input type="hidden" name="pdf" value="'.$fila['tituloForm']."|".$fila['subtituloForm']."|".$fila['fechaForm']."|".$directorioDeImagenes.$fila['imagenJPG']."|".$fila['cuerpoForm'].'"/>
										<input type="hidden" name="usuario" value="'.$usuario.'"/>
										<input type="hidden" name="idNoticia" value="'.$idNoticia.'"/>
										<input class="w3-btn w3-black" type="submit" value="Descargar como PDF"><br><br>
									</form>'
								
								:'<a href="../vistas/suscribirse.php" class="w3-btn w3-black">Descargar como PDF</a>';
					
					return '<!-- Blog entry --><div class="w3-container w3-white w3-margin w3-padding-large"><div class="w3-center"><h3>'.$fila['tituloForm'].'</h3><h5>'.$fila['subtituloForm'].', <span class="w3-opacity">'.$fila['fechaForm'].'</span></h5></div><div class="w3-justify"><img src="'.$directorioDeImagenes.$fila['imagenJPG'].'" style="width:100%" class="w3-padding-16"><p>'.$fila['cuerpoForm'].'</p></div>'.$enlace.'</div><hr>';

				}else{
					echo "No hay noticias disponibles en este momento...";
				}
			}
		}
		mysqli_close($connection);
	}
	echo "No hay noticias disponibles en este momento...";
	return;
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
				if(isset($columna['suscriptor'])&&$columna['suscriptor']==true){
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
			$consulta = "SELECT * FROM noticias WHERE estado='pendiente' ORDER BY idNoticia ASC";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$fila=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
				if(isset($fila['idNoticia'])){
					echo imprimirNoticiaPendiente($fila['idNoticia'], $fila['tituloForm'], $fila['subtituloForm'], $fila['fechaForm'], $fila['imagenJPG'], $fila['cuerpoForm'], '../noticiasPendientes/imagenes/');
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

function imprimirNoticiaPendiente($idNoticia, $tituloForm, $subtituloForm, $fechaForm, $imagenJPG, $cuerpoForm, $directorio){
	echo '<!-- Blog entry --><div class="w3-container w3-white w3-margin w3-padding-large"><div class="w3-center"><h3>';
	echo $tituloForm;
	echo '</h3><h5>';
	echo $subtituloForm;
	echo ', <span class="w3-opacity">';
	echo $fechaForm;
	echo '</span></h5></div><div class="w3-justify"><img src="'.$directorio.$imagenJPG;
	echo '" style="width:100%" class="w3-padding-16"><p>';
	echo $cuerpoForm;
	echo '</div>  
								<form action="aceptarNoticia.php" method="post" enctype="application/x-www-form-urlencoded">
									<input type="hidden" name="idNoticia" value="'.$idNoticia.'"/>
									<input class="w3-btn w3-black" type="submit" value="Validar noticia">
								</form><br>
								<form action="rechazarNoticia.php" method="post" enctype="application/x-www-form-urlencoded">
									<input type="hidden" name="idNoticia" value="'.$idNoticia.'"/>
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
	if(!move_uploaded_file($imagenForm_tmp, "../noticiasPendientes/imagenes/" . $nombre . ".jpg")){
		return "ERROR";
	}
	return cargarNoticiaEnBaseDeDatos($nombre, $tituloForm, $subtituloForm, $fechaForm, $nombre.".jpg", $cuerpoForm, $paqueteForm);
}

function cargarNoticiaEnBaseDeDatos($nombre, $tituloForm, $subtituloForm, $fechaForm, $imagenJPG, $cuerpoForm, 									$paqueteForm){
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
			$sql = "INSERT INTO noticias (idNoticia, esPremium, paquete, cantidadDescargas, estado, tituloForm, subtituloForm, fechaForm, imagenJPG, cuerpoForm) VALUES ('$nombre', '$esPremium', '$paqueteForm', 0, 'pendiente', '$tituloForm', '$subtituloForm', '$fechaForm', '$imagenJPG', '$cuerpoForm')"; // los estados son 'pendiente', 'aprobada' y 'rechazada'
			if (!mysqli_query($connection, $sql)) {
				mysqli_close($connection);
				return "No se pudo insertar en la base de datos";
			}
		}
	}
	mysqli_close($connection);
	return "¡Se subió exitosamente la noticia!";
	
}

function moverNoticiaAceptada($idNoticia){
	cambiarEstadoNoticia($idNoticia,'aceptada');
	$fileNameJPG=$idNoticia.".jpg";
	$dirOrigen="../noticiasPendientes/imagenes/".$fileNameJPG;
	$dirDestino="../noticias/imagenes/".$fileNameJPG;
	rename($dirOrigen, $dirDestino);
}

function moverNoticiaRechazada($idNoticia){
	cambiarEstadoNoticia($idNoticia,'rechazada');
	$fileNameJPG=$idNoticia.".jpg";
	$dirOrigen="../noticiasPendientes/imagenes/".$fileNameJPG;
	$dirDestino="../noticiasRechazadas/imagenes/".$fileNameJPG;
	rename($dirOrigen, $dirDestino);
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