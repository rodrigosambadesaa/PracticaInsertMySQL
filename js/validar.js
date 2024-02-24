const selectorFechaNacimiento = document.getElementById('fecha_nacimiento');
const fechaLimite = new Date();
fechaLimite.setDate(fechaLimite.getDate());

// Obtener el formulario por su ID
const formulario = document.getElementById('formulario');

// Crear un div para los mensajes de error
const errorDiv = document.createElement('div');
errorDiv.classList.add('error-message');
formulario.appendChild(errorDiv);

// Agregar un evento de escucha para el envío del formulario
formulario.addEventListener('submit', function (event) {
    // Detener el envío del formulario
    event.preventDefault();

    // Obtener el número de variables del formulario
    const numeroVariables = formulario.length;

    if (numeroVariables === 0) {
        throw new Error('El formulario no tiene variables');
    }

    // Limpiar los mensajes de error
    errorDiv.innerHTML = '';

    // Edad mínima para registrarse
    const edadMinima = 13;

    // Realizar las validaciones necesarias
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const direccionCalle = document.getElementById('direccionCalle').value;
    const direccionBloque = document.getElementById('direccionBloque').value;
    const direccionEscalera = document.getElementById('direccionEscalera').value;
    const direccionNumero = document.getElementById('direccionNumero').value;
    const direccionPiso = document.getElementById('direccionPiso').value;
    const poblacion = document.getElementById('poblacion').value;
    const provincia = document.getElementById('provincia').value;
    const codigoPostal = document.getElementById('codigoPostal').value;
    const estadoCivil = document.getElementById('estadoCivil').value;
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    const paginaWeb = document.getElementById('paginaWeb').value;
    const terminos = document.getElementById('terminos').checked;

    let errorMessages = "";
    let error = false;

    // Validar el email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email) || email.length < 5 || email.length > 320) {
        errorMessages += 'Por favor, introduce un <strong>email</strong> válido entre 3 y 320 caracteres<br>';
        error = true;
    }

    // Validar la contraseña
    if (password.length < 4 || password.length > 20) {
        errorMessages += 'La <strong>contraseña</strong> debe tener entre 4 y 20 caracteres'
        error = true;
    }

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
        errorMessages += 'Las <strong>contraseñas</strong> no coinciden<br>';
        error = true;
    }

    // Validar que se haya ingresado un nombre y apellidos
    if (nombre === '') {
        errorMessages += 'Por favor, introduce tu <strong>nombre y apellidos</strong><br>';
        error = true;
    }

    // Validar el nombre
    if (nombre.length < 3 || nombre.length > 80) {
        errorMessages += 'Por favor, introduce un <strong>nombre</strong> válido entre 3 y 80 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una dirección de calle
    if (direccionCalle === '') {
        errorMessages += 'Por favor, introduce tu <strong>dirección de calle</strong><br>';
        error = true;
    }

    // Validar la longitud de la dirección de calle
    if (direccionCalle.length < 5 || direccionCalle.length > 40) {
        errorMessages += 'Por favor, introduce una <strong>dirección de calle</strong> válida entre 5 y 40 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado un bloque de dirección
    if (direccionBloque !== '' && (direccionBloque.length < 1 || direccionBloque.length > 3)) {
        errorMessages += 'Por favor, introduce un <strong>bloque</strong> válido entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una escalera de dirección
    if (direccionEscalera !== '' && (direccionEscalera.length < 1 || direccionEscalera.length > 3)) {
        errorMessages += 'Por favor, introduce una <strong>escalera</strong> válida entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado un número de dirección
    if (direccionNumero === '') {
        errorMessages += 'Por favor, introduce tu <strong>número</strong> de dirección<br>';
        error = true;
    }

    // Validar que el número de dirección sea un número natural positivo
    if (isNaN(direccionNumero) || direccionNumero <= 0 || direccionNumero % 1 !== 0) {
        errorMessages += 'Por favor, introduce un <strong>número</strong> de dirección válido<br>';
        error = true;
    }

    // Validar el piso
    if (direccionPiso !== '' && (direccionPiso.length < 3 || direccionPiso.length > 20)) {
        errorMessages += 'Por favor, introduce un <strong>piso</strong> válido entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una población
    if (poblacion === '') {
        errorMessages += 'Por favor, introduce tu <strong>población</strong><br>';
        error = true;
    }

    // Validar que se haya ingresado una población válida
    if (poblacion.length < 3 || poblacion.length > 40) {
        errorMessages += 'Por favor, introduce una <strong>población</strong> válida entre 3 y 40 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una provincia
    if (provincia === '') {
        errorMessages += 'Por favor, selecciona una <strong>provincia</strong><br>';
        error = true;
    }

    // Validar que el valor de la provincia esté entre 1 y 4
    if (provincia < 1 || provincia > 4) {
        errorMessages += 'Por favor, selecciona una <strong>provincia</strong> válida<br>';
        error = true;
    }

    // Validar que la provincia sea un entero
    if (isNaN(provincia) || !Number.isInteger(Number(provincia))) {
        errorMessages += 'Por favor, selecciona una <strong>provincia</strong> válida<br>';
        error = true;
    }

    // Validar que se haya ingresado un código postal
    if (codigoPostal === '') {
        errorMessages += 'Por favor, introduce tu <strong>código postal</strong><br>';
        error = true;
    }

    // Validar que el código postal sea un entero de 5 dígitos
    if (isNaN(codigoPostal) || !Number.isInteger(Number(codigoPostal)) || codigoPostal.length !== 5) {
        errorMessages += 'Por favor, introduce un <strong>código postal</strong> válido de 5 dígitos<br>';
        error = true;
    }

    // Validar que se haya seleccionado un estado civil
    if (estadoCivil === '' || estadoCivil.length !== 1) {
        errorMessages += 'Por favor, selecciona un <strong>estado civil</strong><br>';
        error = true;
    }

    // Validar que la fecha de nacimiento sea anterior a la fecha actual
    const fechaActual = new Date();
    if (fechaNacimiento >= fechaActual) {
        errorMessages += 'Por favor, introduce una <strong>fecha de nacimiento</strong> válida<br>';
        error = true;
    }

    function validarUrl(url) {
        // Validar el esquema
        if (!/^https?:\/\//.test(url)) {
            return false;
        }

        // Validar el nombre de dominio
        const domain = new URL(url).hostname;
        if (esDominioMalicioso(domain)) {
            return false;
        }

        // Validar la ruta
        const path = new URL(url).pathname;
        if (/[\<\>\;]/.test(path)) {
            return false;
        }

        return true;
    }

    const fetch = require('node-fetch');

    async function esDominioMalicioso(domain) {
        try {
            // URL de la API de abuse.ch para consultar dominios maliciosos
            const apiUrl = `https://urlhaus.abuse.ch/api/domain/${domain}/`;

            // Realiza la solicitud GET a la API
            const response = await fetch(apiUrl);

            // Verifica si la solicitud fue exitosa
            if (response.ok) {
                const data = await response.json();

                // Comprueba si el dominio está en la lista de dominios maliciosos
                if (data.query_status === "ok" && data.url_count > 0) {
                    console.log(`${domain} es un dominio malicioso.`);
                    return true;
                } else {
                    console.log(`${domain} no es un dominio malicioso.`);
                    return false;
                }
            } else {
                console.error(`Error al consultar la API: ${response.status} - ${response.statusText}`);
                return false;
            }
        } catch (error) {
            console.error('Error:', error);
            return false;
        }
    }


    if (paginaWeb !== '') {
        if (!validarUrl(paginaWeb)) {
            errorMessages += 'Por favor, introduce una <strong>página web</strong> válida<br>';
            error = true;
            return;
        }

        try {
            const paginaWebUrl = new URL(paginaWeb);
        } catch (error) {
            errorMessages += 'Por favor, introduce una <strong>página web</strong> válida<br>';
            error = true;
        }
    }

    const edadUsuario = fechaActual.getFullYear() - new Date(fechaNacimiento).getFullYear();
    if (edadUsuario < edadMinima) {
        errorMessages += `Debes tener al menos ${edadMinima} años para registrarte. Ahora mismo tienes ${edadUsuario}<br>`;
        error = true;
    }

    // Validar que al menos un tema esté seleccionado
    const temasSeleccionados = document.querySelectorAll('input[name="temas[]"]:checked');

    if (temasSeleccionados.length === 0) {
        errorMessages += 'Por favor, selecciona al menos un <strong>tema</strong><br>';
        error = true;
    }

    // Validar que el textarea de sobre usted no esté vacío
    const sobreUsted = document.getElementById('sobre_usted').value;
    if (sobreUsted === '') {
        errorMessages += 'Por favor, rellena el campo <strong>sobre usted</strong><br>';
        error = true;
    }

    if (!terminos) {
        errorMessages += 'Por favor, acepta los <strong>términos y condiciones</strong><br>';
        error = true;
    }

    if (error) {
        errorDiv.innerHTML = errorMessages;
        return;
    } else {
        formulario.submit();
    }

});
