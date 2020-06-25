<?php

function mostrarNoticias($directorio){
	$arrayDirectorio = scandir($directorio, 1);
	foreach ($arrayDirectorio as &$archivo ){
		if( $archivo!="." && $archivo!=".." ){
			imprimirNoticia($archivo,$directorio);
		}
	}
}

function imprimirNoticia($archivo,$directorio){
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
	echo '</div></div><hr>';
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

function mostrarNoticiaPendienteDeAprobacion($directorio){
	$arrayDirectorio = scandir($directorio);
	if(sizeof($arrayDirectorio)==2){
		echo "No hay noticias pendientes de aprobación...";
		return;
	}
	imprimirNoticiaPendiente($arrayDirectorio[2],$directorio);
}


function imprimirNoticiaPendiente($archivo,$directorio){
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
									<input type="hidden" name="directorio" value="'.$nombre.'" />
									<input class="w3-btn w3-black" type="submit" value="Validar noticia">
								</form><br>
								<form action="rechazarNoticia.php" method="post" enctype="application/x-www-form-urlencoded">
									<input type="hidden" name="directorio" value="'.$nombre.'" />
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

function subirNoticia($tituloForm,$subtituloForm,$fechaForm,$imagenForm_tmp,$cuerpoForm){
	$nombre=obtenerFechaYHoraActual();
	if(!move_uploaded_file($imagenForm_tmp, "./noticiasPendientes/imagenes/" . $nombre . ".jpg")){
		return "ERROR";
	}
	$file = fopen("./noticiasPendientes/texto/" . $nombre. ".txt", "w");
	if(!$file){
		return "ERROR";
	}
	fwrite($file, "$tituloForm|$subtituloForm|$fechaForm|$nombre".".jpg"."|$cuerpoForm");
	return "¡Noticia enviada exitosamente!";
}

function moverNoticiaAceptada($fileNameTXT){
	$fileNameJPG=str_replace(".txt",".jpg",$fileNameTXT);
	$dirOrigen1="./noticiasPendientes/imagenes/".$fileNameJPG;
	$dirOrigen2="./noticiasPendientes/texto/".$fileNameTXT;
	$dirDestino1="./noticias/imagenes/".$fileNameJPG;
	$dirDestino2="./noticias/texto/".$fileNameTXT;
	rename($dirOrigen1,$dirDestino1);
	rename($dirOrigen2,$dirDestino2);
}

function moverNoticiaRechazada($fileNameTXT){
	$fileNameJPG=str_replace(".txt",".jpg",$fileNameTXT);
	$dirOrigen1="./noticiasPendientes/imagenes/".$fileNameJPG;
	$dirOrigen2="./noticiasPendientes/texto/".$fileNameTXT;
	$dirDestino1="./noticiasRechazadas/imagenes/".$fileNameJPG;
	$dirDestino2="./noticiasRechazadas/texto/".$fileNameTXT;
	rename($dirOrigen1,$dirDestino1);
	rename($dirOrigen2,$dirDestino2);
}