<?php

function mostrarNoticias(){
	$directorio="./noticias/imagenes/";
	$arrayDirectorio = scandir($directorio, 1);
	foreach ($arrayDirectorio as &$archivo ){
		if( $archivo!="." && $archivo!=".." ){
			imprimirNoticia($archivo);
		}
	}
}

function imprimirNoticia($archivo){
	$nombre=str_replace(".jpg",".txt",$archivo);
	$noticia=obtenerNoticia($nombre);
	echo '<!-- Blog entry --><div class="w3-container w3-white w3-margin w3-padding-large"><div class="w3-center"><h3>';
	echo $noticia['titulo'];
	echo '</h3><h5>';
	echo $noticia['tituloDesc'];
	echo ', <span class="w3-opacity">';
	echo $noticia['tituloDesc2'];
	echo '</span></h5></div><div class="w3-justify"><img src="./noticias/imagenes/';
	echo $noticia['imagenEXT'];
	echo '" style="width:100%" class="w3-padding-16"><p>';
	echo $noticia['articulo'];
	echo '</div></div><hr>';
}

function obtenerNoticia($nombreArchivo){
	$nombre='./noticias/texto/'.$nombreArchivo;
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

function obtenerFechaYHoraActual(){ // Sólo para nombrar los archivos
	$fecha = new DateTime();
	$fecha->modify('-5 hours');
	return $fecha->format('YmdHis');
}