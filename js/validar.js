// Obtener el formulario por su ID
const formulario = document.getElementById('formulario');

// Agregar un evento de escucha para el envío del formulario
formulario.addEventListener('submit', function (event) {
    // Detener el envío del formulario
    event.preventDefault();

    // Realizar las validaciones necesarias
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const direccionCalle = document.getElementById('direccionCalle').value;
    const direccionNumero = document.getElementById('direccionNumero').value;
    const direccionPiso = document.getElementById('direccionPiso').value;
    const poblacion = document.getElementById('poblacion').value;
    const provincia = document.getElementById('provincia').value;
    const codigoPostal = document.getElementById('codigoPostal').value;
    const estadoCivil = document.getElementById('estadoCivil').value;
    const fechaNacimientoDia = document.getElementById('fechaNacimientoDia').value;
    const fechaNacimientoMes = document.getElementById('fechaNacimientoMes').value;
    const fechaNacimientoAnio = document.getElementById('fechaNacimientoAnio').value;
    const paginaWeb = document.getElementById('paginaWeb').value;

    // Validar el email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email) || email.length < 3 || email.length > 320) {
        alert('Por favor, introduce un email válido entre 3 y 320 caracteres');
        return;
    }

    // Validar la contraseña
    if (password.length < 4 || password.length > 20) {
        alert('La contraseña debe tener entre 4 y 20 caracteres');
        return;
    }

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
    }

    // Validar que se haya ingresado un nombre y apellidos
    if (nombre.trim() === '') {
        alert('Por favor, introduce tu nombre y apellidos');
        return;
    }

    // Validar el nombre
    if (nombre.length < 3 || nombre.length > 80) {
        alert('Por favor, introduce un nombre válido entre 3 y 80 caracteres');
        return;
    }

    // Validar que se haya ingresado una dirección de calle
    if (direccionCalle.trim() === '') {
        alert('Por favor, introduce tu dirección de calle');
        return;
    }

    // Validar la longitud de la dirección de calle
    if (direccionCalle.length < 5 || direccionCalle.length > 40) {
        alert('Por favor, introduce una calle válida entre 5 y 40 caracteres');
        return;
    }

    // Validar que se haya ingresado un número de dirección
    if (direccionNumero.trim() === '') {
        alert('Por favor, introduce el número de tu dirección');
        return;
    }

    // Validar que el número de dirección sea un número natural positivo
    if (isNaN(direccionNumero) || direccionNumero <= 0 || direccionNumero % 1 !== 0) {
        alert('Por favor, introduce un número de dirección válido');
        return;
    }

    // Validar el piso
    if (direccionPiso.trim() !== '' && (direccionPiso.length < 3 || direccionPiso.length > 20)) {
        alert('Por favor, introduce un piso válido entre 3 y 20 caracteres');
        return;
    }

    // Validar que se haya ingresado una población
    if (poblacion.trim() === '') {
        alert('Por favor, introduce tu población');
        return;
    }
    // Validar que se haya ingresado una población válida
    if (poblacion.length < 3 || poblacion.length > 40) {
        alert('Por favor, introduce una población válida entre 3 y 40 caracteres');
        return;
    }

    // Validar que se haya ingresado una provincia
    if (provincia.trim() === '') {
        alert('Por favor, introduce tu provincia');
        return;
    }

    // Validar que el valor de la provincia esté entre 1 y 4
    if (provincia < 1 || provincia > 4) {
        alert('Por favor, selecciona una provincia válida');
        return;
    }

    // Validar que la provincia sea un entero
    if (isNaN(provincia) || !Number.isInteger(Number(provincia))) {
        alert('Por favor, selecciona una provincia válida, numérica en forma de enteros');
        return;
    }

    // Validar que se haya ingresado un código postal
    if (codigoPostal.trim() === '') {
        alert('Por favor, introduce tu código postal');
        return;
    }

    // Validar que el código postal sea un entero de 5 dígitos
    if (isNaN(codigoPostal) || !Number.isInteger(Number(codigoPostal)) || codigoPostal.length !== 5) {
        alert('Por favor, introduce un código postal válido de 5 dígitos');
        return;
    }

    // Validar que se haya seleccionado un estado civil
    if (estadoCivil === '' || estadoCivil.length !== 1) {
        alert('Por favor, selecciona tu estado civil');
        return;
    }

    // Validar que se haya ingresado una fecha de nacimiento
    if (fechaNacimientoDia === '' || fechaNacimientoMes === '' || fechaNacimientoAnio === '') {
        alert('Por favor, introduce tu fecha de nacimiento completa');
        return;
    }

    // Validar que el día de la fecha de nacimiento sea un entero positivo de dos dígitos como máximo
    if (isNaN(fechaNacimientoDia) || !Number.isInteger(Number(fechaNacimientoDia)) || fechaNacimientoDia <= 0 || fechaNacimientoDia > 31) {
        alert('Por favor, introduce un día de nacimiento válido');
        return;
    }

    // Validar que el mes de la fecha de nacimiento sea un entero positivo de dos dígitos como máximo
    if (isNaN(fechaNacimientoMes) || !Number.isInteger(Number(fechaNacimientoMes)) || fechaNacimientoMes <= 0 || fechaNacimientoMes > 12) {
        alert('Por favor, introduce un mes de nacimiento válido');
        return;
    }

    // Validar que el año de la fecha de nacimiento sea un entero positivo de dos dígitos como máximo
    if (isNaN(fechaNacimientoAnio) || !Number.isInteger(Number(fechaNacimientoAnio))) {
        alert('Por favor, introduce un año de nacimiento válido');
        return;
    }

    // Validar que la fecha de nacimiento sea anterior a la fecha actual
    const fechaNacimiento = new Date(fechaNacimientoAnio, fechaNacimientoMes - 1, fechaNacimientoDia);
    const fechaActual = new Date();
    if (fechaNacimiento >= fechaActual) {
        alert('Por favor, introduce una fecha de nacimiento anterior a la fecha actual');
        return;
    }

    if (paginaWeb.trim() !== '') {
        try {
            const paginaWebUrl = new URL(paginaWeb);
        } catch (error) {
            alert('Por favor, introduce una URL válida');
            return;
        }
    }


    // Validar que al menos un tema esté seleccionado
    const temasSeleccionados = document.querySelectorAll('input[name="temas[]"]:checked');
    if (temasSeleccionados.length === 0) {
        alert('Por favor, selecciona al menos un tema');
        return;
    }

    formulario.submit();
});
