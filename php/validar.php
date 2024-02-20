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
	$num_variables = count($_POST); // Count the number of variables received from the form.
	// Validation of the data received from the form.
	if ($num_variables >= 1) {
		$edad_minima = 13; // Minimum age to register.

		// Validate that the email is not empty, has between 5 and 320 characters, and is a valid email.
		if (!isset($_POST['correo']) || strlen($_POST['correo']) < 5 || strlen($_POST['correo']) > 320) {
			echo "The <strong>email</strong> must have between 5 and 320 characters<br>";
			$error = true;
		} elseif (filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL) === false) {
			echo "Invalid <strong>email</strong>: <strong>{$_POST['correo']}</strong><br>";
			$error = true;
		}

		// Validate that the password is not empty, has between 4 and 20 characters, and the passwords match.
		if (!isset($_POST['clave']) || strlen($_POST['clave']) < 4 || strlen($_POST['clave']) > 20) {
			echo "The <strong>password</strong> must have between 4 and 20 characters<br>";
			$error = true;
		} elseif (!isset($_POST['clave_repe']) || $_POST['clave'] !== $_POST['clave_repe']) {
			echo "The <strong>passwords</strong> must match<br>";
			$error = true;
		}

		// Validate that the name is not empty and has between 3 and 80 characters.
		if (!isset($_POST['nombre']) || strlen($_POST['nombre']) < 3 || strlen($_POST['nombre']) > 80) {
			echo "The <strong>name</strong> must have between 3 and 80 characters<br>";
			$error = true;
		}

		// Validate that the street is not empty and has between 5 and 40 characters.
		if (!isset($_POST['calle']) || strlen($_POST['calle']) < 5 || strlen($_POST['calle']) > 40) {
			echo "The <strong>street</strong> must have between 5 and 40 characters<br>";
			$error = true;
		}

		// Validate the block, if entered, has between 1 and 3 characters.
		if (isset($_POST['bloque']) && !empty($_POST['bloque']) && (strlen($_POST['bloque']) < 1 || strlen($_POST['bloque']) > 3)) {
			echo "The <strong>block</strong> must have between 1 and 3 characters<br>";
			$error = true;
		}

		// Validate the staircase, if entered, has between 1 and 3 characters.
		if (isset($_POST['escalera']) && !empty($_POST['escalera']) && (strlen($_POST['escalera']) < 1 || strlen($_POST['escalera']) > 3)) {
			echo "The <strong>staircase</strong> must have between 1 and 3 characters<br>";
			$error = true;
		}

		// Validate that the number is not empty and is a positive integer.
		if (!isset($_POST['numero']) || !ctype_digit($_POST['numero']) || $_POST['numero'] <= 0) {
			echo "The <strong>number</strong> is not valid: <strong>{$_POST['numero']}</strong><br>";
			$error = true;
		}

		// Validate the floor, if entered, has between 3 and 20 characters.
		if (isset($_POST['piso']) && !empty($_POST['piso']) && (strlen($_POST['piso']) < 3 || strlen($_POST['piso']) > 20)) {
			echo "The <strong>floor</strong> must have between 3 and 20 characters<br>";
			$error = true;
		}

		// Validate that the city is not empty and has between 3 and 40 characters.
		if (!isset($_POST['poblacion']) || strlen($_POST['poblacion']) < 3 || strlen($_POST['poblacion']) > 40) {
			echo "The <strong>city</strong> must have between 3 and 40 characters<br>";
			$error = true;
		}

		// Validate that the province is not empty and is an integer between 1 and 4.
		if (!isset($_POST['provincia']) || $_POST['provincia'] < 1 || $_POST['provincia'] > 4) {
			echo "You must select a <strong>province</strong><br>";
			$error = true;
		}

		// Validate that the province is an integer.
		if (!ctype_digit($_POST['provincia'])) {
			echo "The <strong>province</strong> must be an integer value<br>";
			$error = true;
		}

		// Validate that the postal code is not empty and is a 5-digit integer.
		if (!isset($_POST['codigo_postal']) || !ctype_digit($_POST['codigo_postal']) || strlen($_POST['codigo_postal']) != 5) {
			echo "The <strong>postal code</strong> must have 5 digits<br>";
			$error = true;
		}

		// Validate that the marital status is not empty and is an integer between 1 and 4.
		if (!isset($_POST['estado_civil']) || strlen($_POST['estado_civil']) != 1) {
			echo "You must select a <strong>marital status</strong><br>";
			$error = true;
		}

		// Validate that the date of birth is not empty.
		if (!isset($_POST['fecha_nacimiento'])) {
			echo "You must select the <strong>date of birth</strong><br>";
			$error = true;
		}

		// Validate that the date of birth is before the current date.
		if ($_POST['fecha_nacimiento'] >= date("Y-m-d")) {
			echo "The <strong>date of birth</strong> must be before or equal to the current date<br>";
			$error = true;
		}

		$edad_usuario = date("Y") - substr($_POST['fecha_nacimiento'], 0, 4);

		// Validate that the user is at least 13 years old.
		if ($edad_usuario < $edad_minima) {
			echo "The user must be at least <strong>$edad_minima</strong> years old to register<br>";
			$error = true;
		}

		// Validate that the website, if entered, is a valid URL.
		if (isset($_POST['web']) && !empty($_POST['web']) && filter_var($_POST['web'], FILTER_VALIDATE_URL) === false) {
			echo "The <strong>website</strong> is not valid: <strong>{$_POST['web']}</strong><br>";
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
				echo "You must select at least one topic<br>";
				$error = true;
			}
		}

		// Validate that the "about you" textarea is filled.
		if (!isset($_POST['sobre_usted']) || strlen($_POST['sobre_usted']) === 0) {
			echo "You must fill in the <strong>about you</strong> field<br>";
			$error = true;
		}

		// Validate that the terms and conditions have been accepted.
		if (!isset($_POST['terminos'])) {
			echo "You must accept the <strong>terms and conditions</strong><br>";
			$error = true;
		}

		// If there are errors, display them and give the option to go back to the form to correct them.
		if ($error) {
			die("You must correct the errors. <a href='javascript:history.back();'>Go back</a>");
		} else {
			echo "<ol>Data received from the form:<br>";
			echo "<li>Email: {$_POST['correo']}</li>";
			echo "<li>Name: {$_POST['nombre']}</li>";
			echo "<li>Street: {$_POST['calle']}</li>";
			echo "<li>Block: {$_POST['bloque']}</li>";
			echo "<li>Staircase: {$_POST['escalera']}</li>";
			echo "<li>Number: {$_POST['numero']}</li>";
			echo "<li>Floor: {$_POST['piso']}</li>";
			echo "<li>City: {$_POST['poblacion']}</li>";
			echo "<li>Province: {$_POST['provincia']}</li>";
			echo "<li>Postal Code: {$_POST['codigo_postal']}</li>";
			echo "<li>Marital Status: {$_POST['estado_civil']}</li>";
			echo "<li>Date of Birth: {$_POST['fecha_nacimiento']}</li>";
			echo "<li>Website: {$_POST['web']}</li>";
			echo "<li>Topics: <ul>";
			foreach ($_POST['temas'] as $tema) {
				echo "<li>$tema</li>";
			}
			echo "</ul></li>";
			echo "</ol>";

			// If there are no errors, process the data and insert it into the database.
			echo "<strong>Processing registration...</strong><br>";
			/* DATABASE INSERTION */

			$servidor = "localhost";
			$usuario = "root";
			$contrasenha = "";
			$base_de_datos = "practica_insert_mysql";

			// Establish connection with the server and the database.
			$conexion = mysqli_connect($servidor, $usuario, $contrasenha, $base_de_datos) or die("Error:" . mysqli_connect_error());

			// Set the character set to use in the database to avoid problems with certain characters.
			mysqli_query($conexion, "SET NAMES UTF8");

			// Prepare the queries
			// Table usuarios
			// Encrypt the password.
			/* IMPORTANT: The string returned by the hash function always has a length of 32 characters.
				Therefore, we adjust the length of the password in the database to 32 characters */
			/* //This is better than encrypting it directly in the query because we never keep the original (plain text) value of the password in the variable.
				It will always be stored encrypted. We have chosen the md5 algorithm: https://en.wikipedia.org/wiki/MD5 */
			$clave = hash("md5", $_POST['clave']);

			/* For security reasons, once the data has been validated, we destroy the $clave_repe variable */
			unset($_POST['clave_repe']);

			$sentencia_sql = "INSERT INTO `practica_insert_mysql`.`usuarios` (`correo`, `clave`, `nombre`, `calle`, `bloque`, `escalera`, `numero`, `piso`, `poblacion`, `provincia`, `codigo_postal`, `estado_civil`, `fecha_nacimiento`, `web`, `sobre_usuario`) VALUES ('{$_POST['correo']}', '$clave', '{$_POST['nombre']}', '{$_POST['calle']}', '{$_POST['bloque']}', '{$_POST['escalera']}', '{$_POST['numero']}', '{$_POST['piso']}', '{$_POST['poblacion']}', '{$_POST['provincia']}', '{$_POST['codigo_postal']}', '{$_POST['estado_civil']}', '{$_POST['fecha_nacimiento']}', '{$_POST['web']}', '{$_POST['sobre_usted']}');";

			// Execute the insert query
			mysqli_query($conexion, $sentencia_sql) or die("<strong>Insertion failed, cause:</strong> " . mysqli_error($conexion));

			/* Table temas
				Loop through the topics array for insertion */
			foreach ($_POST['temas'] as $tema) {
				$sentencia_sql = "INSERT INTO `practica_insert_mysql`.`temas` (`correo`, `tema`) VALUES ('{$_POST['correo']}', '$tema');";
				// Execute the insert query
				mysqli_query($conexion, $sentencia_sql) or die("<strong>Insertion failed, cause:</strong> " . mysqli_error($conexion));
			}
			echo "Data has been inserted successfully";
		}
	} else {
		// If no data has been received from the form, display an error message.
		die("No data has been received from the form");
	}
