document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Validación simple (esto debería ser reemplazado por una validación real en un entorno de producción)
    if (username === 'prueba1' && password === 'prueba1') {
        alert('Inicio de sesión exitoso');
        window.location.href = '../pages/dashboard.html'; // Redirigir al dashboard
    } else {
        alert('Usuario o contraseña incorrectos');
    }
});