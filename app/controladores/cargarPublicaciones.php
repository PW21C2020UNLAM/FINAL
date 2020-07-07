<?php
include_once("cargarNoticias.php");

function consultarNombresDePublicaciones(){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

    if(!$connection){
        echo "Error del servidor, intente nuevamente más tarde...";
    }
    $consulta = "SELECT nombre FROM publicacion";
    $resultado = mysqli_query($connection, $consulta);
    if($resultado){
        return $resultado;
    }
}

function obtenerPublicaciones($estado){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

    if(!$connection){
        echo "Error del servidor, intente nuevamente más tarde...";
    }
    if ($estado=="aprobada"){
        $consulta = "SELECT nombre FROM publicacion WHERE estado = '$estado'";
    } else {
        $consulta = "SELECT nombre FROM publicacion WHERE estado = '$estado' ORDER BY idPublicacion DESC";
    }
    $resultado = mysqli_query($connection, $consulta);
    if($resultado){
        return $resultado;
    }
}

function subirPublicacion($nombreForm,$imagenForm_tmp){
    $resultado = validarNombreDePublicacionNoRepetido($nombreForm);
    if($resultado) {
        if(!move_uploaded_file($imagenForm_tmp, "../publicacionesPendientes/" . $nombreForm . ".jpg")){
            return "ERROR";
        }
        return subirPublicacionEnBaseDeDatos($nombreForm);
    } else {
        return "Ya existe esta publicación";
    }
}

function validarNombreDePublicacionNoRepetido($nombreForm){
    $resultado = consultarNombresDePublicaciones();
    if($resultado) {
        $resultado->data_seek(0);
        while($fila = $resultado->fetch_assoc()){
            if ($nombreForm == $fila['nombre']){
            return false;
            }
        }
        return true;
    } else {
        return false;
    }
}

function subirPublicacionEnBaseDeDatos($nombreForm){
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
            $sql = "INSERT INTO publicacion (nombre, estado, esPremium) VALUES ('$nombreForm', 'pendiente', 1)"; // los estados son 'pendiente', 'aprobada' y 'rechazada'
            if (!mysqli_query($connection, $sql)) {
                mysqli_close($connection);
                return "No se pudo insertar en la base de datos";
            }
        }
    }
    mysqli_close($connection);
    return "¡Se subió exitosamente la publicación!";
}

function obtenerEstadoDePublicacion($nombre){
    $credenciales=obtenerCredencialesArchivoINI("../database.ini");
    $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

    if(!$connection){
        echo "Error del servidor, intente nuevamente más tarde...";
    }
    $consulta = "SELECT estado FROM publicacion WHERE nombre = '$nombre'";
    $resultado = mysqli_query($connection, $consulta);
    if($resultado){
        return $resultado;
    }
}

function moverPublicacion($fileNameJPG, $estado){
    modificarEstadoDePublicacion($fileNameJPG, $estado);
    $dirOrigen = "../publicacionesPendientes/" . $fileNameJPG . ".jpg";
    if ($estado=="aprobada"){
        $dirDestino = "../publicaciones/" . $fileNameJPG . ".jpg";
    } else if ($estado=="rechazada"){
        $dirDestino = "../publicacionesRechazadas/" . $fileNameJPG . ".jpg";
    }
    rename($dirOrigen, $dirDestino);
}

function modificarEstadoDePublicacion($fileNameJPG, $estado){
        $credenciales = obtenerCredencialesArchivoINI("../database.ini");
        $connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

        if (!$connection) {
            return "No se ha podido conectar con el servidor";
        } else {
            $datab = "pw2";
            $db = mysqli_select_db($connection, $datab);
            if (!$db) {
                mysqli_close($connection);
                return "Error al acceder a la base de datos";
            } else {
                $sql = "UPDATE publicacion SET estado = '$estado' WHERE nombre = '$fileNameJPG'"; // los estados son 'pendiente', 'aprobada' y 'rechazada'
                if (!mysqli_query($connection, $sql)) {
                    mysqli_close($connection);
                    return "No se pudo modificar en la base de datos";
                }
            }
        }
        mysqli_close($connection);
        return "¡Publicación aceptada con exito!";
}

?>