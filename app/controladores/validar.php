<?php

function insertarAdmin($usuario, $clave){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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

function insertarContenidista($usuario, $clave, $email){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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
		$credenciales=obtenerCredencialesArchivoINI("../database.ini");
		$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

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
				$sql = "SELECT email FROM usuario WHERE email='$email'";
				$resultadoQuery = mysqli_query($connection, $sql);
				if ($resultadoQuery && mysqli_fetch_array($resultadoQuery)) {
						echo "Esta dirección de correo ($email) YA ESTÁ EN USO.";
						mysqli_close($connection);
						return "no_ok";
				} else {
					mysqli_close($connection);
					return "ok";
				}
			}
		}
	}else{
		echo "Esta dirección de correo ($email) NO es válida.";
		return "no_ok";
	}	
}

function insertarUsuario($usuario, $clave, $email){
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

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
			$sql = "INSERT INTO usuario (usuario, clave, email, rol, suscriptor) VALUES ('$usuario', '$clave', '$email', 'lector', false)";
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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";
	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');
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
		$credenciales=obtenerCredencialesArchivoINI("../database.ini");
		$email = "administracion@infonete.com";

		$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");
	$email = "administracion@infonete.com";

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'],'pw2');

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
	$credenciales=obtenerCredencialesArchivoINI("../database.ini");

	$connection = mysqli_connect($credenciales['host'], $credenciales['user'], $credenciales['pass'], 'pw2');

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

function obtenerCredencialesArchivoINI($archivo){
	return parse_ini_file($archivo);
}

function mostrarFooter(){
	echo '<!-- Footer -->
        <footer class="w3-container" style="padding:32px; background-color:black; color:white; display:inline-flex; width:100%">
            <div style="padding-left:10%;">
                <b>Infonete S.A.</b><br>
                <a href="index.php" style="text-decoration:none">Inicio</a><br>
                <a href="vistas/contacto.php" style="text-decoration:none">Contacto</a><br>
                <a href="mailto:redaccion@infonete.com" style="text-decoration:none">Redacción</a><br>
                <a href="mailto:comercial@infonete.com" style="text-decoration:none">Comercial</a>
            </div>
            <div style="padding-left:26%;">
                <b>Redes Sociales</b><br>
                <a href="http://www.instagram.com" style="text-decoration:none">Instagram</a><br>
                <a href="http://www.facebook.com" style="text-decoration:none">Facebook</a><br>
                <a href="http://www.twitter.com" style="text-decoration:none">Twitter</a>
            </div>
            <div style="padding-left:26%;">
                <b>Alumnos</b><br>
                Pereyra, Maximiliano<br>
                Rodriguez, Sebastian<br>
            </div>
        </footer>';
}