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
    let hash = '';
    const charSize = 8;
    const blockSize = 512;
    const outputSize = 512;
    const roundConstants = [
        '428a2f98d728ae22', '7137449123ef65cd', 'b5c0fbcfec4d3b2f', 'e9b5dba58189dbbc',
        '3956c25bf348b538', '59f111f1b605d019', '923f82a4af194f9b', 'ab1c5ed5da6d8118',
        'd807aa98a3030242', '12835b0145706fbe', '243185be4ee4b28c', '550c7dc3d5ffb4e2',
        '72be5d74f27b896f', '80deb1fe3b1696b1', '9bdc06a725c71235', 'c19bf174cf692694',
        'e49b69c19ef14ad2', 'efbe4786384f25e3', '0fc19dc68b8cd5b5', '240ca1cc77ac9c65',
        '2de92c6f592b0275', '4a7484aa6ea6e483', '5cb0a9dcbd41fbd4', '76f988da831153b5',
        '983e5152ee66dfab', 'a831c66d2db43210', 'b00327c898fb213f', 'bf597fc7beef0ee4',
        'c6e00bf33da88fc2', 'd5a79147930aa725', '06ca6351e003826f', '142929670a0e6e70',
        '27b70a8546d22ffc', '2e1b21385c26c926', '4d2c6dfc5ac42aed', '53380d139d95b3df',
        '650a73548baf63de', '766a0abb3c77b2a8', '81c2c92e47edaee6', '92722c851482353b',
        'a2bfe8a14cf10364', 'a81a664bbc423001', 'c24b8b70d0f89791', 'c76c51a30654be30',
        'd192e819d6ef5218', 'd69906245565a910', 'f40e35855771202a', '106aa07032bbd1b8',
        '19a4c116b8d2d0c8', '1e376c085141ab53', '2748774cdf8eeb99', '34b0bcb5e19b48a8',
        '391c0cb3c5c95a63', '4ed8aa4ae3418acb', '5b9cca4f7763e373', '682e6ff3d6b2b8a3',
        '748f82ee5defb2fc', '78a5636f43172f60', '84c87814a1f0ab72', '8cc702081a6439ec',
        '90befffa23631e28', 'a4506cebde82bde9', 'bef9a3f7b2c67915', 'c67178f2e372532b',
        'ca273eceea26619c', 'd186b8c721c0c207', 'eada7dd6cde0eb1e', 'f57d4f7fee6ed178',
        '06f067aa72176fba', '0a637dc5a2c898a6', '113f9804bef90dae', '1b710b35131c471b',
        '28db77f523047d84', '32caab7b40c72493', '3c9ebe0a15c9bebc', '431d67c49c100d4c',
        '4cc5d4becb3e42b6', '597f299cfc657e2a', '5fcb6fab3ad6faec', '6c44198c4a475817'
    ];

    function rightRotate(x, n) {
        return (x >>> n) | (x << (32 - n));
    }

    function toHex(value) {
        return value.toString(16).padStart(8, '0');
    }

    function processBlock(block, h) {
        const words = new Array(80);
        for (let i = 0; i < 16; i++) {
            words[i] = parseInt(block.slice(i * 8, (i + 1) * 8), 16);
        }
        for (let i = 16; i < 80; i++) {
            const s0 = rightRotate(words[i - 15], 7) ^ rightRotate(words[i - 15], 18) ^ (words[i - 15] >>> 3);
            const s1 = rightRotate(words[i - 2], 17) ^ rightRotate(words[i - 2], 19) ^ (words[i - 2] >>> 10);
            words[i] = (words[i - 16] + s0 + words[i - 7] + s1) & 0xffffffff;
        }

        let a = h[0];
        let b = h[1];
        let c = h[2];
        let d = h[3];
        let e = h[4];
        let f = h[5];
        let g = h[6];
        let h = h[7];

        for (let i = 0; i < 80; i++) {
            const s1 = rightRotate(e, 6) ^ rightRotate(e, 11) ^ rightRotate(e, 25);
            const ch = (e & f) ^ (~e & g);
            const temp1 = (h + s1 + ch + roundConstants[i] + words[i]) & 0xffffffff;
            const s0 = rightRotate(a, 2) ^ rightRotate(a, 13) ^ rightRotate(a, 22);
            const maj = (a & b) ^ (a & c) ^ (b & c);
            const temp2 = (s0 + maj) & 0xffffffff;

            h = g;
            g = f;
            f = e;
            e = (d + temp1) & 0xffffffff;
            d = c;
            c = b;
            b = a;
            a = (temp1 + temp2) & 0xffffffff;
        }

        h[0] = (h[0] + a) & 0xffffffff;
        h[1] = (h[1] + b) & 0xffffffff;
        h[2] = (h[2] + c) & 0xffffffff;
        h[3] = (h[3] + d) & 0xffffffff;
        h[4] = (h[4] + e) & 0xffffffff;
        h[5] = (h[5] + f) & 0xffffffff;
        h[6] = (h[6] + g) & 0xffffffff;
        h[7] = (h[7] + h) & 0xffffffff;
    }

    function padMessage(message) {
        const messageLength = message.length * charSize;
        const padLength = blockSize - ((messageLength + 128) % blockSize);
        const paddedMessage = message + '80'.padEnd(padLength / charSize, '0') + toHex(messageLength).padStart(16, '0');
        return paddedMessage;
    }

    const paddedMessage = padMessage(s);
    const numBlocks = paddedMessage.length / (blockSize / charSize);
    const h = [
        0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a,
        0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
    ];

    for (let i = 0; i < numBlocks; i++) {
        const block = paddedMessage.slice(i * (blockSize / charSize), (i + 1) * (blockSize / charSize));
        processBlock(block, h);
    }

    for (let i = 0; i < outputSize / charSize; i++) {
        hash += toHex(h[i]);
    }

    return hash;
}

function test_input(data) {
    data = data.trim();
    data = data.replace(/\\/g, '');
    data = data.replace(/</g, '&lt;');
    data = data.replace(/>/g, '&gt;');
    return data;
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
    const nombre = test_input(document.getElementById('nombre').value);
    const email = test_input(document.getElementById('email').value);
    const password = test_input(document.getElementById('password').value);
    const confirmPassword = test_input(document.getElementById('confirmPassword').value);
    const direccionCalle = test_input(document.getElementById('direccionCalle').value);
    const direccionBloque = test_input(document.getElementById('direccionBloque').value);
    const direccionEscalera = test_input(document.getElementById('direccionEscalera').value);
    const direccionNumero = test_input(document.getElementById('direccionNumero').value);
    const direccionPiso = test_input(document.getElementById('direccionPiso').value);
    const poblacion = test_input(document.getElementById('poblacion').value);
    const provincia = document.getElementById('provincia').value;
    const codigoPostal = test_input(document.getElementById('codigoPostal').value);
    const estadoCivil = document.getElementById('estadoCivil').value;
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const paginaWeb = test_input(document.getElementById('paginaWeb').value);
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

    // Validar que la fecha de nacimiento no esté vacía
    if (!fechaNacimiento) {
        errorMessages += 'Por favor, introduce tu <strong>fecha de nacimiento</strong><br>';
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
