<?php
$user = "root";
$pass = "beatport";
$host = "localhost";

$connection = mysqli_connect($host, $user, $pass);

if(!$connection){
	echo "No se ha podido conectar con el servidor...";
}else{
	echo "Hemos conectado al servidor <br>" ;
	$datab = "nirvana";
	$db = mysqli_select_db($connection,$datab);
	if (!$db){
		echo "No se ha podido encontrar la base de datos";
	}else{
		echo "Base de datos seleccionada: ".$datab ;
	};
}
