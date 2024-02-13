<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>REGISTRO</title>
	<link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
	<?php
		$error = false;
		$num_variables = extract($_POST); // Generación de las variables a partir de los datos recibidos del formulario.
		// Validación de los datos recibidos del formulario.

		if ($num_variables >= 1) {
			$edad_minima = 13; // Edad mínima para registrarse.

			// Validar que el correo electrónico no esté vacío, que tenga entre 5 y 320 caracteres y que sea un correo electrónico válido.
			if (!isset($correo) || strlen($correo) < 5 || strlen($correo) > 320) {
				echo "El <strong>correo</strong> electrónico ha de tener entre 5 y 320 caracteres<br>";
				$error = true;
			} elseif (filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
				echo "No es un <strong>correo</strong> electrónico válido: <strong>$correo</strong><br>";
				$error = true;
			}
			
			// Validar que la clave no esté vacía, que tenga entre 4 y 20 caracteres y que las claves sean iguales.
			if (!isset($clave) || strlen($clave) < 4 || strlen($clave) > 20) {
				echo "La <strong>clave</strong> ha de tener entre 4 y 20 caracteres<br>";
				$error = true;
			} elseif (!isset($clave_repe) || $clave !== $clave_repe) {
				echo "Las <strong>claves</strong> han de ser iguales<br>";
				$error = true;
			}
	
			// Validar que el nombre no esté vacío, que tenga entre 3 y 80 caracteres.
			if (!isset($nombre) || strlen($nombre) < 3 || strlen($nombre) > 80) {
				echo "El <strong>nombre</strong> ha de tener entre 3 y 80 caracteres<br>";
				$error = true;
			}
	
			// Validar que la calle no esté vacía, que tenga entre 5 y 40 caracteres.
			if (!isset($calle) || strlen($calle) < 5 || strlen($calle) > 40) {
				echo "La <strong>calle</strong> ha de tener entre 5 y 40 caracteres<br>";
				$error = true;
			}

			// Validar el bloque, si se ha introducido, que tenga entre 1 y 3 caracteres.
			if (isset($bloque) && $bloque != null && (strlen($bloque) < 1 || strlen($bloque) > 3)) {
				echo "El <strong>bloque</strong> ha de tener entre 1 y 3 caracteres<br>";
				$error = true;
			}

			// Validar la escalera, si se ha introducido, que tenga entre 1 y 3 caracteres.
			if (isset($escalera) && $escalera != null && (strlen($escalera) < 1 || strlen($escalera) > 3)) {
				echo "La <strong>escalera</strong> ha de tener entre 1 y 3 caracteres<br>";
				$error = true;
			}
	
			// Validar que el número no esté vacío, que sea un número entero positivo.
			if (!isset($numero) || !ctype_digit($numero) || $numero <= 0) {
				echo "El <strong>número</strong> no es válido: <strong>$numero</strong><br>";
				$error = true;
			}
	
			// Validar el piso, si se ha introducido, que tenga entre 3 y 20 caracteres.
			if (isset($piso) && $piso != null && (strlen($piso) < 3 || strlen($piso) > 20)) {
				echo "El <strong>piso</strong> ha de tener entre 3 y 20 caracteres<br>";
				$error = true;
			}
	
			// Validar que la población no esté vacía, que tenga entre 3 y 40 caracteres.
			if (!isset($poblacion) || strlen($poblacion) < 3 || strlen($poblacion) > 40) {
				echo "La <strong>población</strong> ha de tener entre 3 y 40 caracteres<br>";
				$error = true;
			}
	
			// Validar que la provincia no esté vacía, que sea un número entero entre 1 y 4.
			if (!isset($provincia) || $provincia < 1 || $provincia > 4) {
				echo "Debe seleccionar la <strong>provincia</strong><br>";
				$error = true;
			} 
			
			// Validar que la provincia sea un número entero.
			if (!ctype_digit($provincia)) {
				echo "La <strong>provincia</strong> debe ser un valor entero<br>";
				$error = true;
			}
	
			// Validar que el código postal no esté vacío, que sea un número entero de 5 dígitos.
			if (!isset($codigo_postal) || !ctype_digit($codigo_postal) || strlen($codigo_postal) != 5) {
				echo "El <strong>código postal</strong> ha de tener 5 dígitos<br>";
				$error = true;
			}
	
			// Validar que el estado civil no esté vacío, que sea un número entero entre 1 y 4.
			if (!isset($estado_civil) || strlen($estado_civil) != 1) {
				echo "Debe seleccionar el <strong>estado civil</strong><br>";
				$error = true;
			}
	
			// Validar que la fecha de nacimiento no esté vacía.
			if (!isset($fecha_nacimiento)) {
				echo "Debe seleccionar la <strong>fecha de nacimiento</strong><br>";
				$error = true;
			}
	
			// Validar que la fecha de nacimiento sea anterior a la fecha actual.
			if ($fecha_nacimiento >= date("Y-m-d")) {
				echo "La <strong>fecha de nacimiento</strong> debe ser anterior o igual a la fecha actual<br>";
				$error = true;
			}

			$edad_usuario = date("Y") - substr($fecha_nacimiento, 0, 4);

			// Validar que el usuario tenga al menos 13 años.
			if ($edad_usuario < $edad_minima) {
				echo "El usuario debe tener al menos <strong>$edad_minima</strong> años para registrarse<br>";
				$error = true;
			}
	
			// Validar que la dirección web, si se ha introducido, sea una dirección web válida.
			if (isset($web) && $web != null && filter_var($web, FILTER_VALIDATE_URL) === false) {
				echo "La <strong>dirección web</strong> no es válida: <strong>$web</strong><br>";
				$error = true;
			}
	
			// Validar que se ha marcado al menos un tema.
			if (!isset($temas) || !is_array($temas) || count($temas) === 0) {
				echo "No ha marcado ningún <strong>tema</strong><br>";
				$error = true;
			}

			// Validar que se haya rellenado el textarea de sobre usted.
			if (!isset($sobre_usted) || strlen($sobre_usted) === 0) {
				echo "Debe rellenar el campo <strong>sobre usted</strong><br>";
				$error = true;
			}

			// Validar que se han aceptado los términos y condiciones.
			if (!isset($terminos)) {
				echo "Debe aceptar los <strong>términos y condiciones</strong><br>";
				$error = true;
			}
	
			// Si hay errores, se muestran y se da la opción de volver al formulario para corregirlos.
			if ($error) {
				die("Debe corregir los errores. <a href='javascript:history.back();'>Volver</a>");
			} else {
				echo "<ol>Datos recibidos del formulario:<br>";
				echo "<li>Correo: $correo</li>";
				echo "<li>Nombre: $nombre</li>";
				echo "<li>Calle: $calle</li>";
				echo "<li>Bloque: $bloque</li>";
				echo "<li>Escalera: $escalera</li>";
				echo "<li>Número: $numero</li>";
				echo "<li>Piso: $piso</li>";
				echo "<li>Población: $poblacion</li>";
				echo "<li>Provincia: $provincia</li>";
				echo "<li>Código postal: $codigo_postal</li>";
				echo "<li>Estado civil: $estado_civil</li>";
				echo "<li>Fecha de nacimiento: $fecha_nacimiento</li>";
				echo "<li>Dirección web: $web</li>";
				echo "<li>Temas: <ul>";
				foreach ($temas as $tema) {
					echo "<li>$tema</li>";
				}
				echo "</ul></li>";
				echo "</ol>";

				// Si no hay errores, se procesan los datos y se insertan en la base de datos.
				echo "<strong>Procesando registro...</strong><br>";
				/* INSERCIÓN EN LA BASE DE DATOS */
	
				$servidor = "localhost";
				$usuario = "root";
				$contrasenha = "";
				$base_de_datos = "practica_insert_mysql";
	
				// Establecemos la conexión con el servidor y con la base de datos.
				$conexion = mysqli_connect($servidor, $usuario, $contrasenha, $base_de_datos) or die ("Error:" . mysqli_connect_error());
	
				//Especificación del sistema de caracteres a utilizar en la base de datos, para evitar problemas con ciertos caracteres
				mysqli_query($conexion, "SET NAMES UTF8");
	
				//Preparación de las consultas
				//Tabla usuarios
				//Encriptación de la contraseña.
				/* IMPORTANTE: El string devuelto por la función hash siempre tiene una longitud de 32 caracteres.
				Ajustamos, por tanto, la longitud de la contraseña en la base de datos a 32 caracteres */
				/* //Esto es mejor que encriptarla directamente en la consulta, porque así nunca conservamos en la variable el valor original (texto plano) de la contraseña.
				Siempre se guardará encriptada. Se ha escogido el algoritmo md5: https://es.wikipedia.org/wiki/MD5 */
				$clave = hash("md5", $clave);
	
				/* Por razones de seguridad, una vez validados los datos destruimos la variable $clave_repe */
				unset($clave_repe);
	
				$sentencia_sql = "INSERT INTO `practica_insert_mysql`.`usuarios` (`correo`, `clave`, `nombre`, `calle`, `bloque`, `escalera`, `numero`, `piso`, `poblacion`, `provincia`, `codigo_postal`, `estado_civil`, `fecha_nacimiento`, `web`, `sobre_usuario`) VALUES ('$correo', '$clave', '$nombre', '$calle', '$bloque', '$escalera', '$numero', '$piso', '$poblacion', '$provincia', '$codigo_postal', '$estado_civil', '$fecha_nacimiento', '$web', '$sobre_usted');";
	
				// Lanzamos la consulta insert
				mysqli_query($conexion, $sentencia_sql) or die ("<strong>La inserción ha fallado, causa:</strong> " . mysqli_error($conexion));
	
				/* Tabla temas	
				Recorrido del array de temas para la inserción */
				foreach ($temas as $tema) {
					$sentencia_sql = "INSERT INTO `practica_insert_mysql`.`temas` (`correo`, `tema`) VALUES ('$correo', '$tema');";
					// Lanzamos la consulta insert
					mysqli_query($conexion, $sentencia_sql) or die ("<strong>La inserción ha fallado, causa:</strong> " . mysqli_error($conexion));
				}				
				echo "Los datos se han insertado correctamente";
			}
			
		} else {
			// Si no se han recibido datos del formulario, se muestra un mensaje de error.
			die("No se han recibido datos del formulario");
		}

	?>
</body>
</html>
