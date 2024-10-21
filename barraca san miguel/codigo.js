document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('errorMessage');
   
    if (username === 'brayan' && password === 'infocal1234') {
        window.location.href = 'index1.php'; 
    } else {
        errorMessage.textContent = 'Usuario o contraseña incorrectos';
        errorMessage.style.display = 'block';
    }
});
