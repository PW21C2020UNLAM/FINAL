<?php

function insertarAdmin($usuario, $clave){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($host, $user, $pass);

	if(!$connection){
		return;
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection,$datab);
		if (!$db){
			mysqli_close($connection);
			return;
		}else{
			$clave = md5($clave);
			$sql = "INSERT INTO usuario (usuario, clave, email, rol, suscriptor) VALUES ('$usuario', '$clave', '$email', 'admin', true)";
			if (mysqli_query($connection, $sql)) {
				return;
			} else {
				mysqli_close($connection);
				return;
			}
			mysqli_close($connection);
		};
	}
	return;
}

function registrarContenidista($usuario, $clave, $email){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass);

	if(!$connection){
		echo "No se ha podido conectar con el servidor";
		return "no_ok";
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection,$datab);
		if (!$db){
			echo "Error al acceder a la base de datos";
			mysqli_close($connection);
			return "no_ok";
		}else{
			$clave = md5($clave);
			$sql = "INSERT INTO usuario (usuario, clave, email, rol, suscriptor) VALUES ('$usuario', '$clave', '$email', 'contenidista', true)";
			if (mysqli_query($connection, $sql)) {
				echo "¡Usuario creado exitosamente!";
			} else {
				echo "¡El usuario ya existe!";
				mysqli_close($connection);
				return "no_ok";
			}
			mysqli_close($connection);
		};
	}
	return "Se creó correctamente el usuario $usuario con el email $email";
}
	
function validarMail($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return "ok";
	}else{
		echo "Esta dirección de correo ($email) NO es válida.";
		return "no_ok";
	}
}

function validarInsert($usuario, $clave, $email){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass);

	if(!$connection){
		echo "No se ha podido conectar con el servidor";
		return "no_ok";
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection,$datab);
		if (!$db){
			echo "Error al acceder a la base de datos";
			mysqli_close($connection);
			return "no_ok";
		}else{
			$clave = md5($clave);
			$sql = "INSERT INTO usuario (usuario, clave, email, rol, suscriptor) VALUES ('$usuario', '$clave', '$email', 'lector', true)";
			if (mysqli_query($connection, $sql)) {
				echo "¡Usuario creado exitosamente!";
			} else {
				echo "¡El usuario ya existe!";
				mysqli_close($connection);
				return "no_ok";
			}
			mysqli_close($connection);
		};
	}
	return "Se creó correctamente el usuario $usuario con el email $email";
}

function mostrarMensaje($mensaje){
	echo '<br><br> <label class="w3-text-brown"> ';									
	if( $mensaje!='no_ok' ){
		echo $mensaje.'<br><br>';
		echo '</label><a href="iniciarSesion.php"><input class="w3-btn w3-black" type="submit" value="¡Iniciar sesión ahora!"></a>';
	}else{
		echo '</label><br><br> <a href="registro.php"><input class="w3-btn w3-black" type="submit" value="Volver a registro"></a>';
	}
}

function mostrarMensajeRegistroContenidista($mensaje){
	echo '<br><br> <label class="w3-text-brown"> ';									
	if( $mensaje!='no_ok' ){
		echo $mensaje.'<br><br>';
	}else{
		echo '</label><br><br> <a href="registroContenidista.php"><input class="w3-btn w3-black" type="submit" value="Volver a registro"></a>';
	}
}

function esUsuarioValido($usuarioIngresado,$claveIngresada){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass);

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
			$consulta = "SELECT clave FROM usuario WHERE usuario='$usuarioIngresado'";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$columna=mysqli_fetch_array($resultado);
				if($columna&&$columna['clave']==md5($claveIngresada)){
						mysqli_close($connection);
						return true;
					}
			}
		}
		mysqli_close($connection);
	}
	return false;
}

function cambiarClave($claveAnterior,$claveNueva,$usuario){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass, "pw2");

	if(!$connection){
		return false;
	}
	$consulta = "SELECT clave FROM usuario WHERE usuario='$usuario'";
	$resultado = mysqli_query($connection, $consulta);
	$columna=mysqli_fetch_array($resultado);
	if(  $columna['clave']==md5($claveAnterior) ){
		$claveNueva=md5($claveNueva);
		$consulta = "UPDATE usuario SET clave='$claveNueva' WHERE usuario='$usuario'";
		if(mysqli_query($connection,$consulta) ){
			mysqli_close($connection);
			return true;
		}else{
			mysqli_close($connection);
			return false;
		}
	}else{
		mysqli_close($connection);
		return false;
	}
	mysqli_close($connection);
	return false;
}

function eliminarCuenta($usuario, $clave){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass, "pw2");

	if(!$connection){
		return false;
	}
	$consulta = "SELECT clave FROM usuario WHERE usuario='$usuario'";
	$resultado = mysqli_query($connection, $consulta);
	$columna=mysqli_fetch_array($resultado);
	if(  $columna['clave'] == md5($clave) ){
		$consulta = "DELETE FROM usuario WHERE usuario='$usuario'";
		if(mysqli_query($connection,$consulta) ){
			mysqli_close($connection);
			return true;
		}else{
			mysqli_close($connection);
			return false;
		}
	}else{
		mysqli_close($connection);
		return false;
	}
	mysqli_close($connection);
	return false;
}

function eliminarCuentaAdmin($usuarioDelete,$usr,$clave){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";
	$connection = mysqli_connect($host, $user, $pass, "pw2");
	$resultado=false;
	if(!esUsuarioValido($usr,$clave)){
		return false;
	}
	if(obtenerRolUsuario($usr)!="admin"){
		return false;
	}
	if(!$connection){
		return $resultado;
	}
	if(obtenerRolUsuario($usuarioDelete)){
		$consulta = "DELETE FROM usuario WHERE usuario='$usuarioDelete'";
		if(mysqli_query($connection,$consulta)){
			$resultado=true;
		}else{
			$resultado=false;
		}
	}
	mysqli_close($connection);
	return $resultado;
}

function validarSuscribirse($usuario, $numero, $codigoSeguridad){
	if (is_numeric($numero) && is_numeric($codigoSeguridad)) {
		$user = "root";
		$pass = "beatport";
		$host = "localhost";

		$connection = mysqli_connect($host, $user, $pass, "pw2");

		if(!$connection){
			return "Error del servidor, intente nuevamente más tarde...";
		}
		$consulta = "SELECT suscriptor FROM usuario WHERE usuario='$usuario'";
		$resultado = mysqli_query($connection, $consulta);
		$columna=mysqli_fetch_array($resultado);
		if(  $columna['suscriptor']==false ){
			$consulta = "UPDATE usuario SET suscriptor=true WHERE usuario='$usuario'";
			if(mysqli_query($connection,$consulta) ){
				mysqli_close($connection);
				return "¡Suscripción exitosa!";
			}else{
				mysqli_close($connection);
				return "Error del servidor, intente nuevamente más tarde...";
			}
		}else{
			mysqli_close($connection);
			return "¡Ya se encuentra suscripto!";
		}
		mysqli_close($connection);
		return false;
	}else{
		return "¡Error! Debe ingresar números.";
	}
}

function obtenerRolUsuario($userName){
	$user = "root";
	$pass = "beatport";
	$host = "localhost";

	$connection = mysqli_connect($host, $user, $pass);

	if(!$connection){
		return null;
	}else{
		$datab = "pw2";
		$db = mysqli_select_db($connection,$datab);
		if (!$db){
			echo "Error al acceder a la base de datos";
			mysqli_close($connection);
			return null;
		}else{
			$consulta = "SELECT rol FROM usuario WHERE usuario='$userName'";
			$resultado = mysqli_query($connection, $consulta);
			if ($resultado) {
				$columna=mysqli_fetch_array($resultado);
				if($columna){
						mysqli_close($connection);
						return $columna['rol'];
					}
			}
		}
		mysqli_close($connection);
	}
	return null;
}

function headerSegunRol($rol){
	if($rol){
		$rol=ucfirst($rol);
		return "Location: index".$rol.".php";
	}
}

function cambiarEmail($emailNuevo,$usuario){
    $user = "root";
    $pass = "beatport";
    $host = "localhost";

    $connection = mysqli_connect($host, $user, $pass, "pw2");

    if(!$connection){
        return false;
    }

    if (filter_var($emailNuevo, FILTER_VALIDATE_EMAIL)){
        $emailInexistente = true;
        $consulta = "SELECT email FROM usuario";
        $resultado = mysqli_query($connection, $consulta);
        while($emails = $resultado->fetch_assoc()){
            if ($emails['email'] == $emailNuevo){
                $emailInexistente = false;
            }
        }
        if($emailInexistente){
        $consulta = "UPDATE usuario SET email='$emailNuevo' WHERE usuario='$usuario'";
        if(mysqli_query($connection,$consulta) ){
            mysqli_close($connection);
            return true;
        }else{
            mysqli_close($connection);
            return false;
        }} else {
                mysqli_close($connection);
                return false;
        }
    }

}