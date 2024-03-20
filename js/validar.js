const selectorFechaNacimiento = document.getElementById('fecha_nacimiento');
const fechaLimite = new Date();
fechaLimite.setDate(fechaLimite.getDate());

// Obtener el formulario por su ID
const formulario = document.getElementById('formulario');

// Crear un div para los mensajes de error
const errorDiv = document.createElement('div');
errorDiv.classList.add('error-message');
formulario.appendChild(errorDiv);

function hashSHA512(s) {
    return new Hashes(s);
}

function test_input(data) {
    data = data.trim();
    data = data.replace(/\\/g, '');
    data = data.replace(/</g, '&lt;');
    data = data.replace(/>/g, '&gt;');
    return data;
}

class Hashes {

    constructor() {
        this.hexcase = 0;
        this.b64pad = "";
    }

    constructor(s) {
        return this.rstr2hex(this.rstr(s));
    }

    hex(s) {
        return this.rstr2hex(this.rstr(s));
    }

    rstr(s) {
        return this.binl2rstr(this.binl(s));
    }

    binl(s) {
        const bin = [];
        const mask = (1 << 8) - 1;
        for (let i = 0; i < s.length * 8; i += 8) {
            bin[i >> 5] |= (s.charCodeAt(i / 8) & mask) << (24 - i % 32);
        }
        return bin;
    }

    binl2rstr(input) {
        let output = "";
        for (let i = 0; i < input.length * 32; i += 8) {
            output += String.fromCharCode((input[i >> 5] >> (24 - i % 32)) & 0xFF);
        }
        return output;
    }

    rstr2hex(input) {
        const hexTab = "0123456789abcdef";
        let output = "";
        for (let i = 0; i < input.length; i++) {
            const x = input.charCodeAt(i);
            output += hexTab.charAt((x >> 4) & 0x0F) + hexTab.charAt(x & 0x0F);
        }
        return output;
    }

}

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
    const foto = document.getElementById('foto').files[0];
    const nombre = document.getElementById('nombre').value.test_input();
    const email = document.getElementById('email').value.test_input();
    const password = document.getElementById('password').value.test_input();
    const confirmPassword = document.getElementById('confirmPassword').value.test_input();
    const direccionCalle = document.getElementById('direccionCalle').value.test_input();
    const direccionBloque = document.getElementById('direccionBloque').value.test_input();
    const direccionEscalera = document.getElementById('direccionEscalera').value.test_input();
    const direccionNumero = document.getElementById('direccionNumero').value.test_input();
    const direccionPiso = document.getElementById('direccionPiso').value.test_input();
    const poblacion = document.getElementById('poblacion').value.test_input();
    const provincia = document.getElementById('provincia').value;
    const codigoPostal = document.getElementById('codigoPostal').value.test_input();
    const estadoCivil = document.getElementById('estadoCivil').value;
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value.test_input();
    const paginaWeb = document.getElementById('paginaWeb').value.test_input();
    const sexo = document.querySelector('input[name="sexo"]:checked');
    const terminos = document.getElementById('terminos').checked;

    let errorMessages = "";
    let error = false;

    async function checkVirusTotal(url) {
        const response = await fetch(url);
        const data = await response.json();
        if (data.positives > 0) {
            return true;
        }
        return false;
    }

    function checkVirusTotal(foto) {
        return new Promise((resolve, reject) => {
            fetch(foto)
                .then(response => response.json())
                .then(data => {
                    if (data.positives > 0) {
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    // Validar que se haya seleccionado una foto (opcional)
    if (foto !== '' && foto.length < 5) {
        errorMessages += 'Por favor, selecciona una <strong>foto</strong> válida<br>';
        error = true;
    }

    // Validar que la foto, si se ha introducido, no sea maliciosa
    if (foto !== '') {
        const virusTotalAPIKey = '1d7d62b2b3dc21f9d8114da33fc9d32c3d82bca763096022777f16f82d1f9117';
        checkVirusTotal(`https://www.virustotal.com/vtapi/v2/file/report?apikey=${virusTotalAPIKey}&resource=${foto}`)
            .then((isMalicious) => {
                if (isMalicious) {
                    errorMessages += 'La <strong>foto</strong> seleccionada no es segura<br>';
                    error = true;
                }
            });
    }

    // Validar el email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email) || email.length < 5 || email.length > 320) {
        errorMessages += 'Por favor, introduce un <strong>email</strong> válido entre 3 y 320 caracteres<br>';
        error = true;
    }

    // Validar la contraseña
    if (password.length < 15) {
        errorMessages += 'La <strong>contraseña</strong> debe tener al menos 15 caracteres<br>';
        error = true;
    }

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
        errorMessages += 'Las <strong>contraseñas</strong> no coinciden<br>';
        error = true;
    } else {
        // Encriptar las contraseñas con SHA-512
        password = hashSHA512(password);
        confirmPassword = hashSHA512(confirmPassword);
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
    if (isNaN(direccionNumero) || direccionNumero <= 0 || !Number.isInteger(Number(direccionNumero))) {
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

    const edadUsuario = fechaActual.getFullYear() - new Date(fechaNacimiento).getFullYear();
    if (edadUsuario < edadMinima) {
        errorMessages += `Debes tener al menos ${edadMinima} años para registrarte. Ahora mismo tienes ${edadUsuario}<br>`;
        error = true;
    }

    // Validar que la página web, si se ha introducido, sea válida
    if (paginaWeb !== '') {
        // Validar que la página web sea válida y que no esté en una base de datos de páginas web maliciosas
        const paginaWebRegex = /^(http|https):\/\/[a-z0-9\.-]+\.[a-z]{2,4}/;
        if (!paginaWebRegex.test(paginaWeb)) {
            errorMessages += 'Por favor, introduce una <strong>página web</strong> válida<br>';
            error = true;
        }

        const virusTotalAPIKey = '1d7d62b2b3dc21f9d8114da33fc9d32c3d82bca763096022777f16f82d1f9117';
        checkVirusTotal(`https://www.virustotal.com/vtapi/v2/url/report?apikey=${virusTotalAPIKey}&resource=${paginaWeb}`)
            .then((isMalicious) => {
                if (isMalicious) {
                    errorMessages += 'La <strong>página web</strong> introducida no es segura<br>';
                    error = true;
                }
            });
    }

    // Validar que se haya seleccionado un sexo
    if (!sexo) {
        errorMessages += 'Por favor, selecciona un <strong>sexo</strong><br>';
        error = true;
    }


    // Validar que al menos un tema esté seleccionado
    const temasSeleccionados = document.querySelectorAll('input[name="temas[]"]:checked');

    if (temasSeleccionados.length === 0) {
        errorMessages += 'Por favor, selecciona al menos un <strong>tema</strong><br>';
        error = true;
    }

    // Validar que el textarea de sobre usted no esté vacío
    const sobreUsted = document.getElementById('sobre_usted').value.trim();
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
