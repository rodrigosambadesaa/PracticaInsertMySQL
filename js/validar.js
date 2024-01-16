const selectorFechaNacimiento = document.getElementById('fecha_nacimiento');
const fechaLimite = new Date(); // Assign a valid value to the fechaLimite variable
fechaLimite.setDate(fechaLimite.getDate() - 1); // Set the previous day

selectorFechaNacimiento.max = fechaLimite.toISOString().split("T")[0];
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

    // Limpiar los mensajes de error
    errorDiv.innerHTML = '';

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

    let errorMessages = "";
    let error = false;

    // Validar el email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email) || email.length < 3 || email.length > 320) {
        errorMessages += 'Por favor, introduce un email válido entre 3 y 320 caracteres<br>';
        error = true;
    }

    // Validar la contraseña
    if (password.length < 4 || password.length > 20) {
        errorMessages+= 'La contraseña debe tener entre 4 y 20 caracteres'
        error = true;
    }

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
        errorMessages += 'Las contraseñas no coinciden<br>';
        error = true;
    }

    // Validar que se haya ingresado un nombre y apellidos
    if (nombre.trim() === '') {
        errorMessages += 'Por favor, introduce tu nombre y apellidos<br>';
        error = true;
    }

    // Validar el nombre
    if (nombre.length < 3 || nombre.length > 80) {
        errorMessages += 'Por favor, introduce un nombre válido entre 3 y 80 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una dirección de calle
    if (direccionCalle.trim() === '') {
       errorMessages += 'Por favor, introduce tu dirección de calle<br>';
       error = true;
    }

    // Validar la longitud de la dirección de calle
    if (direccionCalle.length < 5 || direccionCalle.length > 40) {
       errorMessages += 'Por favor, introduce una dirección de calle válida entre 5 y 40 caracteres<br>';
       error = true;
    }

    // Validar que se haya ingresado un bloque de dirección
    if(direccionBloque.trim() !== '' && (direccionBloque.length < 1 || direccionBloque.length > 3)) {
        errorMessages += 'Por favor, introduce un bloque válido entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una escalera de dirección
    if (direccionEscalera.trim() !== '' && (direccionEscalera.length < 1 || direccionEscalera.length > 3)) {
        errorMessages += 'Por favor, introduce una escalera válida entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado un número de dirección
    if (direccionNumero.trim() === '') {
       errorMessages += 'Por favor, introduce tu número de dirección<br>';
       error = true;
    }

    // Validar que el número de dirección sea un número natural positivo
    if (isNaN(direccionNumero) || direccionNumero <= 0 || direccionNumero % 1 !== 0) {
        errorMessages += 'Por favor, introduce un número de dirección válido<br>';
        error = true;
    }

    // Validar el piso
    if (direccionPiso.trim() !== '' && (direccionPiso.length < 3 || direccionPiso.length > 20)) {
        errorMessages += 'Por favor, introduce un piso válido entre 3 y 20 caracteres<br>';
        error = true;
    }

    // Validar que se haya ingresado una población
    if (poblacion.trim() === '') {
       errorMessages += 'Por favor, introduce tu población<br>';
       error = true;
    }
    // Validar que se haya ingresado una población válida
    if (poblacion.length < 3 || poblacion.length > 40) {
       errorMessages += 'Por favor, introduce una población válida entre 3 y 40 caracteres<br>';
       error = true;
    }

    // Validar que se haya ingresado una provincia
    if (provincia.trim() === '') {
        errorMessages += 'Por favor, selecciona una provincia<br>';
        error = true;
    }

    // Validar que el valor de la provincia esté entre 1 y 4
    if (provincia < 1 || provincia > 4) {
        errorMessages += 'Por favor, selecciona una provincia válida<br>';
        error = true;
    }

    // Validar que la provincia sea un entero
    if (isNaN(provincia) || !Number.isInteger(Number(provincia))) {
       errorMessages += 'Por favor, selecciona una provincia válida<br>';
       error = true;
    }

    // Validar que se haya ingresado un código postal
    if (codigoPostal.trim() === '') {
        errorMessages += 'Por favor, introduce tu código postal<br>';
        error = true;
    }

    // Validar que el código postal sea un entero de 5 dígitos
    if (isNaN(codigoPostal) || !Number.isInteger(Number(codigoPostal)) || codigoPostal.length !== 5) {
        errorMessages += 'Por favor, introduce un código postal válido de 5 dígitos<br>';
        error = true;
    }

    // Validar que se haya seleccionado un estado civil
    if (estadoCivil === '' || estadoCivil.length !== 1) {
        errorMessages += 'Por favor, selecciona un estado civil<br>';
        error = true;
    }

    // Validar que la fecha de nacimiento sea anterior a la fecha actual
    const fechaActual = new Date();
    if (fechaNacimiento >= fechaActual) {
        errorMessages += 'Por favor, introduce una fecha de nacimiento válida<br>';
        error = true;
    }

    if (paginaWeb.trim() !== '') {
        try {
            const paginaWebUrl = new URL(paginaWeb);
        } catch (error) {
            errorMessages += 'Por favor, introduce una página web válida<br>';
            error = true;
        }
    }

    // Validar que al menos un tema esté seleccionado
    const temasSeleccionados = document.querySelectorAll('input[name="temas[]"]:checked');
    
    if (temasSeleccionados.length === 0) {
        errorMessages += 'Por favor, selecciona al menos un tema<br>';
        error = true;
    }

    if (error) {
        errorDiv.innerHTML = errorMessages;
        return;
    } else {
        formulario.submit();
    }

});
