<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		* {box-sizing: border-box;}

		input[type=text], select, textarea {
		width: 100%;
		padding: 12px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
		}

		input[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		}

		input[type=submit]:hover {
		background-color: #45a049;
		}

		.container {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
		}
		
		</style>
	</head>
	<body>
		<div class="w3-bar w3-black w3-hide-small">
			<a href="vistas/indexLector.php" class="w3-bar-item w3-button">Volver</a>
			
			</div>
			
			<h1 class="w3-xxlarge"><b>- Envíanos un mensaje -</b></h1>

			<div class="container">
				<form action="formularioEnviado.php">
					<label for="fname">Nombre</label>
					<input type="text" id="fname" name="firstname" placeholder="Escribe tu nombre..." required>

					<label for="lname">Apellido</label>
					<input type="text" id="lname" name="lastname" placeholder="Escribe tu apellido..."required>

					<label for="lname">Teléfono</label>
					<input type="text" id="phone" name="telephone" placeholder="Escribe tu numero de teléfono"required>

					<label for="subject">Mensaje</label>
					<textarea id="subject" name="subject" placeholder="Escribe algo..." style="height:200px" required></textarea>

					<input type="submit" value="Enviar">
				</form>
		
		</div>

	</body>
</html>
