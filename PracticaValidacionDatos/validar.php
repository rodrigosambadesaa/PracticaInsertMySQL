<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title> REGISTRO </title>
	</head>
	<body>
		<?php
			$error = false;
			extract($_POST); // Generación de las variables a partir de los datos recibidos del formulario.

			if (!isset($correo) || strlen($correo) < 5 || strlen($correo) > 320) {
				echo "El <strong>correo</strong> electrónico ha de tener entre 5 y 320 caracteres <br>";
				$error = true;
			} elseif (filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
				echo "No es un <strong>correo</strong> electrónico válido <br>";
				$error = true;
			}

			if (!isset($clave) || strlen($clave) < 4 || strlen($clave) > 20) {
				echo "La <strong>clave</strong> ha de tener entre 4 y 20 caracteres <br>";
				$error = true;
			} elseif (!isset($clave_repe) || $clave !== $clave_repe) {
				echo "Las <strong>claves</strong> han de ser iguales <br>";
				$error = true;
			}

			if (!isset($nombre) || strlen($nombre) < 3 || strlen($nombre) > 80) {
				echo "El <strong>nombre</strong> ha de tener entre 3 y 80 caracteres <br>";
				$error = true;
			}

			if (!isset($calle) || strlen($calle) < 5 || strlen($calle) > 40) {
				echo "La <strong>calle</strong> ha de tener entre 5 y 40 caracteres <br>";
				$error = true;
			}

			if (!isset($numero) || !ctype_digit($numero) || $numero <= 0) {
				echo "El <strong>número</strong> no es válido <br>";
				$error = true;
			}

			if (isset($piso) && $piso != null) {
				//El piso puede estar vacío
				//Si no está vacío y su longitud no es correcta, hay error
				if (strlen($piso) < 3 || strlen($piso) > 20) {
					echo "El <strong>piso</strong> ha de tener entre 3 y 20 caracteres <br>";
					$error = true;
				}
			}

			if (!isset($poblacion) || strlen($poblacion) < 3 || strlen($poblacion) > 40) {
				echo "La <strong>población</strong> ha de tener entre 3 y 40 caracteres <br>";
				$error = true;
			}

			if (!isset($provincia) || $provincia < 1 || $provincia > 4) {
				echo "Debe seleccionar la <strong>provincia</strong><br />";
				$error = true;
			} 
			
			if (!ctype_digit($provincia)) {
				echo "La <strong>provincia</strong> debe ser un valor entero<br>";
				$error = true;
			}

			if (!isset($codigo_postal) || !ctype_digit($codigo_postal) ||strlen($codigo_postal) != 5) {
				echo "El <strong>código postal</strong> ha de tener 5 dígitos <br>";
				$error = true;
			}

			if (!isset($estado_civil) || strlen($estado_civil) != 1) {
				echo "Debe seleccionar el <strong>estado civil</strong><br>";
				$error = true;
			}

			if (!isset($mes, $dia, $anho) || !ctype_digit($mes) || !ctype_digit($dia) || !ctype_digit($anho) || !checkdate($mes, $dia, $anho)) {
				echo "La <strong>fecha</strong> de nacimiento no es correcta <br>";
				$error = true;
			} 
			
			if (mktime(0, 0, 0, $mes, $dia, $anho) > time()) {
				echo "La <strong>fecha</strong> de nacimiento debe ser anterior a la actual <br>";
				$error = true;
			}

			if (isset($web) && $web != null) {
				//Solo hay error si no está vacía y no es válida
				if (filter_var($web, FILTER_VALIDATE_URL) === false) {
					echo "La <strong>dirección web</strong> no es válida <br>";
					$error = true;
				}
			}

			if (!isset($temas) || !is_array($temas) || count($temas) == 0) {
				echo "No ha marcado ningún <strong>tema</strong> <br>";
				$error = true;
			}

			if ($error == true) {
				die(
					"Debe corregir los errores. <a href='javascript:history.back();'>Volver</a>"
				);
			} else {
				echo "Los datos son correctos.";
			}
  		?>
	</body>
</html>			