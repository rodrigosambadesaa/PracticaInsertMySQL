<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title> REGISTRO </title>
</head>
<body>
	<?php
		extract($_POST); // Generación de las variables a partir de los datos recibidos del formulario.
		// Validación de los datos recibidos del formulario.
		$error = false;

		if (!isset($correo) || strlen($correo) < 5 || strlen($correo) > 320) {
			echo "El <strong>correo</strong> electrónico ha de tener entre 5 y 320 caracteres<br>";
			$error = true;
		} elseif (filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
			echo "No es un <strong>correo</strong> electrónico válido: <strong>$correo</strong><br>";
			$error = true;
		}

		if (!isset($clave) || strlen($clave) < 4 || strlen($clave) > 20) {
			echo "La <strong>clave</strong> ha de tener entre 4 y 20 caracteres<br>";
			$error = true;
		} elseif (!isset($clave_repe) || $clave !== $clave_repe) {
			echo "Las <strong>claves</strong> han de ser iguales<br>";
			$error = true;
		}

		if (!isset($nombre) || strlen($nombre) < 3 || strlen($nombre) > 80) {
			echo "El <strong>nombre</strong> ha de tener entre 3 y 80 caracteres<br>";
			$error = true;
		}

		if (!isset($calle) || strlen($calle) < 5 || strlen($calle) > 40) {
			echo "La <strong>calle</strong> ha de tener entre 5 y 40 caracteres<br>";
			$error = true;
		}

		if (!isset($numero) || !ctype_digit($numero) || $numero <= 0) {
			echo "El <strong>número</strong> no es válido: <strong>$numero</strong><br>";
			$error = true;
		}

		if (isset($piso) && $piso != null && (strlen($piso) < 3 || strlen($piso) > 20)) {
			echo "El <strong>piso</strong> ha de tener entre 3 y 20 caracteres<br>";
			$error = true;
		}

		if (!isset($poblacion) || strlen($poblacion) < 3 || strlen($poblacion) > 40) {
			echo "La <strong>población</strong> ha de tener entre 3 y 40 caracteres<br>";
			$error = true;
		}

		if (!isset($provincia) || $provincia < 1 || $provincia > 4) {
			echo "Debe seleccionar la <strong>provincia</strong><br>";
			$error = true;
		} 
		
		if (!ctype_digit($provincia)) {
			echo "La <strong>provincia</strong> debe ser un valor entero<br>";
			$error = true;
		}

		if (!isset($codigo_postal) || !ctype_digit($codigo_postal) || strlen($codigo_postal) != 5) {
			echo "El <strong>código postal</strong> ha de tener 5 dígitos<br>";
			$error = true;
		}

		if (!isset($estado_civil) || strlen($estado_civil) != 1) {
			echo "Debe seleccionar el <strong>estado civil</strong><br>";
			$error = true;
		}

		if (!isset($fecha_nacimiento)) {
			echo "Debe seleccionar la <strong>fecha de nacimiento</strong><br>";
			$error = true;
		}

		if ($fecha_nacimiento > date("Y-m-d")) {
			echo "La <strong>fecha de nacimiento</strong> debe ser anterior a la fecha actual<br>";
			$error = true;
		}

		if (isset($web) && $web != null && filter_var($web, FILTER_VALIDATE_URL) === false) {
			echo "La <strong>dirección web</strong> no es válida: <strong>$web</strong><br>";
			$error = true;
		}

		if (!isset($temas) || !is_array($temas) || count($temas) === 0) {
			echo "No ha marcado ningún <strong>tema</strong><br>";
			$error = true;
		}

		if ($error) {
			die("Debe corregir los errores. <a href='javascript:history.back();'>Volver</a>");
		} else {
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

			$sentencia_sql = "INSERT INTO `practica_insert_mysql`.`usuario` (`correo`, `clave`, `nombre`, `calle`, `numero`, `piso`, `poblacion`, `provincia`, `codigo_postal`, `estado_civil`, `fecha_nacimiento`, `web`) VALUES ('$correo', '$clave', '$nombre', '$calle', '$numero', '$piso', '$poblacion', '$provincia', '$codigo_postal', '$estado_civil', '$fecha_nacimiento', '$web');";

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
	?>
</body>
</html>
