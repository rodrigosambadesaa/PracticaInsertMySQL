<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>REGISTRO</title>
	<link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
	<?php

	function hashSHA512($string)
	{
		return hash('sha512', $string);
	}

	function checkVirusTotal($url, $api_key)
	{
		// URL de la API de VirusTotal para consultar URLs maliciosas
		$api_url = 'https://www.virustotal.com/vtapi/v2/url/report?apikey=' . $api_key . '&resource=' . urlencode($url);

		// Realiza la solicitud GET a la API
		$response = file_get_contents($api_url);

		// Verifica si la solicitud fue exitosa
		if ($response !== false) {
			$data = json_decode($response, true);

			// Comprueba si la URL está en la lista de URLs maliciosas
			if ($data['response_code'] === 1 && $data['positives'] > 0) {
				echo $url . ' es una URL maliciosa.';
				return true;
			} else {
				echo $url . ' no es una URL maliciosa.';
				return false;
			}
		} else {
			echo 'Error al consultar la API.';
			return false;
		}
	}

	function esDominioMalicioso($domain)
	{
		try {
			// URL de la API de abuse.ch para consultar dominios maliciosos
			$apiUrl = 'https://urlhaus.abuse.ch/api/domain/' . urlencode($domain) . '/';

			// Realiza la solicitud GET a la API
			$response = file_get_contents($apiUrl);

			// Verifica si la solicitud fue exitosa
			if ($response !== false) {
				$data = json_decode($response, true);

				// Comprueba si el dominio está en la lista de dominios maliciosos
				if ($data['query_status'] === 'ok' && $data['url_count'] > 0) {
					echo $domain . ' es un dominio malicioso.';
					return true;
				} else {
					echo $domain . ' no es un dominio malicioso.';
					return false;
				}
			} else {
				echo 'Error al consultar la API.';
				return false;
			}
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}

	$error = false;
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$num_variables = count($_POST); // Cuenta el número de variables recibidas por POST.
		// Validación de los datos recibidos por POST.
		if ($num_variables >= 1) {
			$edad_minima = 13; // Edad mínima para registrarse.

			// Validar que el email no esté vacío, tenga entre 5 y 320 caracteres y sea un email válido.
			if (!isset($_POST['correo']) || strlen(trim($_POST['correo'])) < 5 || strlen(trim($_POST['correo'])) > 320) {
				echo "El <strong>email</strong> debe tener entre 5 y 320 caracteres: {$_POST['correo']}<br>";
				$error = true;
			} elseif (filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) === false) {
				echo "Correo <strong>inválido</strong>: <strong>{$_POST['correo']}</strong><br>";
				$error = true;
			}

			// Validar que las contraseñas sean hashes SHA-512 válidos.
			if (!isset($_POST['clave']) || !isset($_POST['clave_repe']) || strlen(trim($_POST['clave'])) < 15 || strlen(trim($_POST['clave_repe'])) < 15) {
				echo "Las <strong>contraseñas</strong> deben tener al menos 15 caracteres<br>";
				$error = true;
			} elseif (trim($_POST['clave']) !== trim($_POST['clave_repe'])) {
				echo "Las <strong>contraseñas</strong> no coinciden<br>";
				$error = true;
			}

			// Validar que el nombre no esté vacío y tenga entre 3 y 80 caracteres.
			if (!isset($_POST['nombre']) || strlen(trim($_POST['nombre'])) < 3 || strlen(trim($_POST['nombre'])) > 80) {
				echo "El <strong>nombre</strong> debe tener entre 3 y 80 caracteres: {$_POST['nombre']}<br>";
				$error = true;
			}

			// Validar que la calle no esté vacía y tenga entre 5 y 40 caracteres.
			if (!isset($_POST['calle']) || strlen(trim($_POST['calle'])) < 5 || strlen(trim($_POST['calle'])) > 40) {
				echo "La <strong>calle</strong> debe tener entre 5 y 40 caracteres: {$_POST['calle']}<br>";
				$error = true;
			}

			// Validar que el bloque, si se ha ingresado, tenga entre 1 y 3 caracteres.
			if (isset($_POST['bloque']) && !empty($_POST['bloque']) && (strlen(trim($_POST['bloque'])) < 1 || strlen(trim($_POST['bloque'])) > 3)) {
				echo "El <strong>bloque</strong> debe tener entre 1 y 3 caracteres: {$_POST['bloque']}<br>";
				$error = true;
			}

			// Validar que la escalera, si se ha ingresado, tenga entre 1 y 3 caracteres.
			if (isset($_POST['escalera']) && !empty($_POST['escalera']) && (strlen(trim($_POST['escalera'])) < 1 || strlen(trim($_POST['escalera'])) > 3)) {
				echo "La <strong>escalera</strong> debe tener entre 1 y 3 caracteres: {$_POST['escalera']}<br>";
				$error = true;
			}

			// Validar que el número no esté vacío y sea un entero positivo.
			if (!isset($_POST['numero']) || !ctype_digit(trim($_POST['numero'])) || (int) trim($_POST['numero']) <= 0) {
				echo "El <strong>número</strong> no es válido: {$_POST['numero']}<br>";
				$error = true;
			}

			// Validar que el piso, si se ha ingresado, tenga entre 3 y 20 caracteres.
			if (isset($_POST['piso']) && !empty($_POST['piso']) && (strlen(trim($_POST['piso'])) < 3 || strlen(trim($_POST['piso'])) > 20)) {
				echo "El <strong>piso</strong> debe tener entre 3 y 20 caracteres: {$_POST['piso']}<br>";
				$error = true;
			}

			// Validar que la ciudad no esté vacía y tenga entre 3 y 40 caracteres.
			if (!isset($_POST['poblacion']) || strlen(trim($_POST['poblacion'])) < 3 || strlen(trim($_POST['poblacion'])) > 40) {
				echo "La <strong>ciudad</strong> debe tener entre 3 y 40 caracteres: {$_POST['poblacion']}<br>";
				$error = true;
			}

			// Validar que la provincia no esté vacía y sea un entero entre 1 y 4.
			if (!isset($_POST['provincia']) || (int) trim($_POST['provincia']) < 1 || (int) trim($_POST['provincia']) > 4) {
				echo "Debes seleccionar una <strong>provincia</strong>: {$_POST['provincia']}<br>";
				$error = true;
			}

			// Validar que la provincia sea un entero.
			if (!ctype_digit((int) trim($_POST['provincia']))) {
				echo "La <strong>provincia</strong> debe ser un valor entero: {$_POST['provincia']}<br>";
				$error = true;
			}

			// Validar que el código postal no esté vacío y sea un entero de 5 dígitos.
			if (!isset($_POST['codigo_postal']) || !ctype_digit((int) trim($_POST['codigo_postal'])) || strlen(trim($_POST['codigo_postal'])) !== 5) {
				echo "El <strong>código postal</strong> debe tener 5 dígitos: {$_POST['codigo_postal']}<br>";
				$error = true;
			}

			// Validar que el estado civil no esté vacío y sea un entero de 1 dígito.
			if (!isset($_POST['estado_civil']) || strlen((int) trim($_POST['estado_civil'])) !== 1) {
				echo "Debes seleccionar un <strong>estado civil</strong>: {$_POST['estado_civil']}<br>";
				$error = true;
			}

			// Validar que la fecha de nacimiento no esté vacía.
			if (!isset($_POST['fecha_nacimiento'])) {
				echo "Debes seleccionar la <strong>fecha de nacimiento</strong>: {$_POST['fecha_nacimiento']}<br>";
				$error = true;
			}

			// Validar que la fecha de nacimiento sea anterior a la fecha actual.
			if (trim($_POST['fecha_nacimiento']) >= date("Y-m-d")) {
				echo "La <strong>fecha de nacimiento</strong> debe ser anterior o igual a la fecha actual: {$_POST['fecha_nacimiento']}<br>";
				$error = true;
			}

			$edad_usuario = date("Y") - substr($_POST['fecha_nacimiento'], 0, 4);

			// Validar que el usuario tenga al menos 13 años.
			if ($edad_usuario < $edad_minima) {
				echo "Debes tener al menos <strong>$edad_minima</strong> años para registrarte. Ahora mismo tienes {$_POST['edad_usuario']}<br>";
				$error = true;
			}

			// Validar que el sitio web, si se ha ingresado, sea una URL válida.
			if (isset($_POST['web']) && !empty($_POST['web']) && filter_var(trim($_POST['web']), FILTER_VALIDATE_URL) === false) {
				echo "El <strong>sitio web</strong> no es válido: <strong>{$_POST['web']}</strong><br>";
				$error = true;
			}

			// Validar que el dominio del sitio web no sea malicioso.
			if (isset($_POST['web']) && !empty($_POST['web']) && esDominioMalicioso(parse_url(trim($_POST['web']), PHP_URL_HOST))) {
				echo "El <strong>dominio</strong> del sitio web es malicioso: <strong>{$_POST['web']}</strong><br>";
				$error = true;
			}

			$a_counts = array();
			if (isset($_POST['temas'])) {
				foreach ($_POST['temas'] as $key => $val) {
					if (!isset($a_counts[$val])) {
						$a_counts[$val] = 1;
					} else {
						$a_counts[$val]++;
					}
					// echo $key . " => " . $val . "<br>";
				}
			}

			if (count($a_counts) === 0) {
				echo "Debes seleccionar al menos un <strong>tema</strong><br>";
				$error = true;
			}

			// Validar que el campo "sobre ti" no esté vacío.
			if (!isset($_POST['sobre_usted']) || strlen(trim($_POST['sobre_usted'])) === 0) {
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
				// echo "<ol>Datos recibidos del formulario:<br>";
				// echo "<li>Email: {$_POST['correo']}</li>";
				// echo "<li>Nombre: {$_POST['nombre']}</li>";
				// echo "<li>Calle: {$_POST['calle']}</li>";
				// echo "<li>Bloque: {$_POST['bloque']}</li>";
				// echo "<li>Escalera: {$_POST['escalera']}</li>";
				// echo "<li>Número: {$_POST['numero']}</li>";
				// echo "<li>Piso: {$_POST['piso']}</li>";
				// echo "<li>Ciudad: {$_POST['poblacion']}</li>";
				// echo "<li>Provincia: {$_POST['provincia']}</li>";
				// echo "<li>Código Postal: {$_POST['codigo_postal']}</li>";
				// echo "<li>Estado Civil: {$_POST['estado_civil']}</li>";
				// echo "<li>Fecha de Nacimiento: {$_POST['fecha_nacimiento']}</li>";
				// echo "<li>Sitio Web: {$_POST['web']}</li>";
				// echo "<li>Temas: <ul>";
				// foreach ($_POST['temas'] as $tema) {
				// 	echo "<li>$tema</li>";
				// }
				// echo "</ul></li>";
				// echo "</ol>";

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

				// Encriptar la contraseña con SHA-512
				$clave = hashSHA512($_POST['clave']);
				unset($_POST['clave_repe']); // Eliminar la contraseña repetida del array de datos.

				$correo = trim($_POST['correo']);
				$nombre = trim($_POST['nombre']);
				$calle = trim($_POST['calle']);
				$bloque = trim($_POST['bloque']);
				$escalera = trim($_POST['escalera']);
				$numero = trim($_POST['numero']);
				$piso = trim($_POST['piso']);
				$poblacion = trim($_POST['poblacion']);
				$provincia = trim($_POST['provincia']);
				$codigo_postal = trim($_POST['codigo_postal']);
				$estado_civil = trim($_POST['estado_civil']);
				$fecha_nacimiento = trim($_POST['fecha_nacimiento']);
				$web = trim($_POST['web']);
				$sobre_usted = trim($_POST['sobre_usted']);

				$sentencia_sql = "INSERT INTO `mi_empresa`.`usuarios` (`correo`, `clave`, `nombre`, `calle`, `bloque`, `escalera`, `numero`, `piso`, `poblacion`, `provincia`, `codigo_postal`, `estado_civil`, `fecha_nacimiento`, `web`, `sobre_usuario`) VALUES ('$correo', '$clave', '$nombre', '$calle', '$bloque', '$escalera', '$numero', '$piso', '$poblacion', '$provincia', '$codigo_postal', '$estado_civil', '$fecha_nacimiento', '$web', '$sobre_usted');";

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
	} else {
		echo "Acceso denegado";
	}
	?>
</body>

</html>