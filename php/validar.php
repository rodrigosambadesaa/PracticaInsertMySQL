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
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$num_variables = count($_POST); // Cuenta el número de variables recibidas por POST.
		// Validación de los datos recibidos por POST.
		if ($num_variables >= 1) {
			$edad_minima = 13; // Edad mínima para registrarse.

			// Validar que el email no esté vacío, tenga entre 5 y 320 caracteres y sea un email válido.
			if (!isset($_POST['correo']) || strlen($_POST['correo']) < 5 || strlen($_POST['correo']) > 320) {
				echo "El <strong>email</strong> debe tener entre 5 y 320 caracteres<br>";
				$error = true;
			} elseif (filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) === false) {
				echo "Correo <strong>inválido</strong>: <strong>{$_POST['correo']}</strong><br>";
				$error = true;
			}

			// Validar que la contraseña no esté vacía, tenga entre 4 y 20 caracteres y las contraseñas coincidan.
			if (!isset($_POST['clave']) || strlen($_POST['clave']) < 4 || strlen($_POST['clave']) > 20) {
				echo "La <strong>contraseña</strong> debe tener entre 4 y 20 caracteres<br>";
				$error = true;
			} elseif (!isset($_POST['clave_repe']) || $_POST['clave'] !== $_POST['clave_repe']) {
				echo "Las <strong>contraseñas</strong> deben coincidir<br>";
				$error = true;
			}

			// Validar que el nombre no esté vacío y tenga entre 3 y 80 caracteres.
			if (!isset($_POST['nombre']) || strlen($_POST['nombre']) < 3 || strlen($_POST['nombre']) > 80) {
				echo "El <strong>nombre</strong> debe tener entre 3 y 80 caracteres<br>";
				$error = true;
			}

			// Validar que la calle no esté vacía y tenga entre 5 y 40 caracteres.
			if (!isset($_POST['calle']) || strlen($_POST['calle']) < 5 || strlen($_POST['calle']) > 40) {
				echo "La <strong>calle</strong> debe tener entre 5 y 40 caracteres<br>";
				$error = true;
			}

			// Validar que el bloque, si se ha ingresado, tenga entre 1 y 3 caracteres.
			if (isset($_POST['bloque']) && !empty($_POST['bloque']) && (strlen($_POST['bloque']) < 1 || strlen($_POST['bloque']) > 3)) {
				echo "El <strong>bloque</strong> debe tener entre 1 y 3 caracteres<br>";
				$error = true;
			}

			// Validar que la escalera, si se ha ingresado, tenga entre 1 y 3 caracteres.
			if (isset($_POST['escalera']) && !empty($_POST['escalera']) && (strlen($_POST['escalera']) < 1 || strlen($_POST['escalera']) > 3)) {
				echo "La <strong>escalera</strong> debe tener entre 1 y 3 caracteres<br>";
				$error = true;
			}

			// Validar que el número no esté vacío y sea un entero positivo.
			if (!isset($_POST['numero']) || !ctype_digit($_POST['numero']) || $_POST['numero'] <= 0) {
				echo "El <strong>número</strong> no es válido: <strong>{$_POST['numero']}</strong><br>";
				$error = true;
			}

			// Validar que el piso, si se ha ingresado, tenga entre 3 y 20 caracteres.
			if (isset($_POST['piso']) && !empty($_POST['piso']) && (strlen($_POST['piso']) < 3 || strlen($_POST['piso']) > 20)) {
				echo "El <strong>piso</strong> debe tener entre 3 y 20 caracteres<br>";
				$error = true;
			}

			// Validar que la ciudad no esté vacía y tenga entre 3 y 40 caracteres.
			if (!isset($_POST['poblacion']) || strlen($_POST['poblacion']) < 3 || strlen($_POST['poblacion']) > 40) {
				echo "La <strong>ciudad</strong> debe tener entre 3 y 40 caracteres<br>";
				$error = true;
			}

			// Validar que la provincia no esté vacía y sea un entero entre 1 y 4.
			if (!isset($_POST['provincia']) || $_POST['provincia'] < 1 || $_POST['provincia'] > 4) {
				echo "Debes seleccionar una <strong>provincia</strong><br>";
				$error = true;
			}

			// Validar que la provincia sea un entero.
			if (!ctype_digit($_POST['provincia'])) {
				echo "La <strong>provincia</strong> debe ser un valor entero<br>";
				$error = true;
			}

			// Validar que el código postal no esté vacío y sea un entero de 5 dígitos.
			if (!isset($_POST['codigo_postal']) || !ctype_digit($_POST['codigo_postal']) || strlen($_POST['codigo_postal']) != 5) {
				echo "El <strong>código postal</strong> debe tener 5 dígitos<br>";
				$error = true;
			}

			// Validar que el estado civil no esté vacío y sea un entero de 1 dígito.
			if (!isset($_POST['estado_civil']) || strlen($_POST['estado_civil']) != 1) {
				echo "Debes seleccionar un <strong>estado civil</strong><br>";
				$error = true;
			}

			// Validar que la fecha de nacimiento no esté vacía.
			if (!isset($_POST['fecha_nacimiento'])) {
				echo "Debes seleccionar la <strong>fecha de nacimiento</strong><br>";
				$error = true;
			}

			// Validar que la fecha de nacimiento sea anterior a la fecha actual.
			if ($_POST['fecha_nacimiento'] >= date("Y-m-d")) {
				echo "La <strong>fecha de nacimiento</strong> debe ser anterior o igual a la fecha actual<br>";
				$error = true;
			}

			$edad_usuario = date("Y") - substr($_POST['fecha_nacimiento'], 0, 4);

			// Validar que el usuario tenga al menos 13 años.
			if ($edad_usuario < $edad_minima) {
				echo "El usuario debe tener al menos <strong>$edad_minima</strong> años para registrarse<br>";
				$error = true;
			}

			// Validar que el sitio web, si se ha ingresado, sea una URL válida.
			if (isset($_POST['web']) && !empty($_POST['web']) && filter_var($_POST['web'], FILTER_VALIDATE_URL) === false) {
				echo "El <strong>sitio web</strong> no es válido: <strong>{$_POST['web']}</strong><br>";
				$error = true;
			}

			if (isset($_POST['temas'])) {
				$a_counts = array();
				foreach ($_POST['temas'] as $key => $val) {
					if (!isset($a_counts[$val])) {
						$a_counts[$val] = 1;
					} else {
						$a_counts[$val]++;
					}
					echo $key . " => " . $val . "<br>";
				}
				if (count($a_counts) === 0) {
					echo "Debes seleccionar al menos un <strong>tema</strong><br>";
					$error = true;
				}
			}

			// Validar que el campo "sobre ti" no esté vacío.
			if (!isset($_POST['sobre_usted']) || strlen($_POST['sobre_usted']) === 0) {
				echo "Debes completar el campo <strong>sobre ti</strong><br>";
				$error = true;
			}

			// Validar que se hayan aceptado los términos y condiciones.
			if (!isset($_POST['terminos'])) {
				echo "Debes aceptar los <strong>términos y condiciones</strong><br>";
				$error = true;
			}

			// Si hay errores, mostrarlos y dar la opción de volver al formulario para corregirlos.
			if ($error) {
				die("Debes corregir los errores. <a href='javascript:history.back();'>Volver</a>");
			} else {
				echo "<ol>Datos recibidos del formulario:<br>";
				echo "<li>Email: {$_POST['correo']}</li>";
				echo "<li>Nombre: {$_POST['nombre']}</li>";
				echo "<li>Calle: {$_POST['calle']}</li>";
				echo "<li>Bloque: {$_POST['bloque']}</li>";
				echo "<li>Escalera: {$_POST['escalera']}</li>";
				echo "<li>Número: {$_POST['numero']}</li>";
				echo "<li>Piso: {$_POST['piso']}</li>";
				echo "<li>Ciudad: {$_POST['poblacion']}</li>";
				echo "<li>Provincia: {$_POST['provincia']}</li>";
				echo "<li>Código Postal: {$_POST['codigo_postal']}</li>";
				echo "<li>Estado Civil: {$_POST['estado_civil']}</li>";
				echo "<li>Fecha de Nacimiento: {$_POST['fecha_nacimiento']}</li>";
				echo "<li>Sitio Web: {$_POST['web']}</li>";
				echo "<li>Temas: <ul>";
				foreach ($_POST['temas'] as $tema) {
					echo "<li>$tema</li>";
				}
				echo "</ul></li>";
				echo "</ol>";

				// Si no hay errores, procesar los datos e insertarlos en la base de datos.
				echo "<strong>Procesando registro...</strong><br>";
				/* INSERCIÓN EN LA BASE DE DATOS */

				$servidor = "localhost";
				$usuario = "root";
				$contrasenha = "";
				$base_de_datos = "mi_empresa";

				// Establecer conexión con el servidor y la base de datos.
				$conexion = mysqli_connect($servidor, $usuario, $contrasenha, $base_de_datos) or die("Error:" . mysqli_connect_error());

				// Establecer el juego de caracteres a utilizar en la base de datos para evitar problemas con ciertos caracteres.
				mysqli_query($conexion, "SET NAMES UTF8");

				// Preparar las consultas
				// Tabla usuarios
				// Encriptar la contraseña.
				/* IMPORTANTE: La cadena devuelta por la función hash siempre tiene una longitud de 32 caracteres.
							Por lo tanto, ajustamos la longitud de la contraseña en la base de datos a 32 caracteres */
				/* //Esto es mejor que encriptarlo directamente en la consulta porque nunca guardamos el valor original (texto plano) de la contraseña en la variable.
							Siempre se almacenará encriptada. Hemos elegido el algoritmo md5: https://es.wikipedia.org/wiki/MD5 */
				$clave = hash("md5", $_POST['clave']);

				/* Por razones de seguridad, una vez que los datos han sido validados, destruimos la variable $clave_repe */
				unset($_POST['clave_repe']);

				$sentencia_sql = "INSERT INTO `mi_empresa`.`usuarios` (`correo`, `clave`, `nombre`, `calle`, `bloque`, `escalera`, `numero`, `piso`, `poblacion`, `provincia`, `codigo_postal`, `estado_civil`, `fecha_nacimiento`, `web`, `sobre_usuario`) VALUES ('{$_POST['correo']}', '$clave', '{$_POST['nombre']}', '{$_POST['calle']}', '{$_POST['bloque']}', '{$_POST['escalera']}', '{$_POST['numero']}', '{$_POST['piso']}', '{$_POST['poblacion']}', '{$_POST['provincia']}', '{$_POST['codigo_postal']}', '{$_POST['estado_civil']}', '{$_POST['fecha_nacimiento']}', '{$_POST['web']}', '{$_POST['sobre_usted']}');";

				// Ejecutar la consulta de inserción
				mysqli_query($conexion, $sentencia_sql) or die("<strong>Fallo en la inserción, causa:</strong> " . mysqli_error($conexion));

				/* Tabla temas
							Recorrer el array de temas para la inserción */
				foreach ($_POST['temas'] as $tema) {
					$sentencia_sql = "INSERT INTO `mi_empresa`.`temas` (`correo`, `tema`) VALUES ('{$_POST['correo']}', '$tema');";
					// Ejecutar la consulta de inserción
					mysqli_query($conexion, $sentencia_sql) or die("<strong>Fallo en la inserción, causa:</strong> " . mysqli_error($conexion));
				}
				echo "Los datos se han insertado correctamente";
			}
		} else {
			// Si no se ha recibido ningún dato del formulario, mostrar un mensaje de error.
			die("No se ha recibido ningún dato del formulario");
		}
	}
	?>
</body>

</html>