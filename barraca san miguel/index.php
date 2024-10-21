<?php
// Conexión a la base de datos MySQL
$servername = "localhost"; // Cambia esto si tu servidor no está en localhost
$username = "root"; // Tu usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "mi_base_datos"; // El nombre de tu base de datos
$port = 3306; // Puerto de MySQL

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Comprobar si el usuario ya existe
    $checkUser = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
    
    // Verificar si la preparación de la consulta fue exitosa
    if ($checkUser === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $checkUser->bind_param("s", $newUsername);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo "<script>document.getElementById('error-message').textContent = 'El nombre de usuario ya está en uso.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
    } else {
        // Preparar y ejecutar la inserción
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $newUsername, $newPassword);

        if ($stmt->execute()) {
            header("Location: index1.php");
            exit();
        } else {
            echo "<script>document.getElementById('error-message').textContent = 'Error: " . $stmt->error . "'; document.getElementById('error-message').style.visibility = 'visible';</script>";
        }
    }

    $stmt->close();
}

// Validación de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
    
    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            header("Location: index1.php"); // Redirigir si el inicio de sesión es exitoso
            exit();
        } else {
            echo "<script>document.getElementById('error-message').textContent = 'Contraseña incorrecta.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
        }
    } else {
        echo "<script>document.getElementById('error-message').textContent = 'Usuario no encontrado.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barraca san miguel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, rgba(255, 94, 98, 0.9), rgba(255, 149, 0, 0.9));
        }

        .login-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
            color: #fff;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        #login-button, #register-button {
            width: 100%;
            padding: 12px;
            background-color: rgba(0, 204, 255, 0.8);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-bottom: 10px;
        }

        #login-button:hover, #register-button:hover {
            background-color: rgba(0, 204, 255, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        #error-message {
            margin-top: 10px;
            color: #ff6b6b;
            visibility: hidden;
        }

        .show-password {
            position: relative;
        }

        .show-password input {
            padding-right: 40px;
        }

        .show-password i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
        }

        .login-container a {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-container a:hover {
            color: rgba(255, 255, 255, 1);
        }

        /* Ocultar el formulario de registro por defecto */
        #register-container {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container" id="login-container">
        <h2>Barraca san miguel</h2>
        <form id="login-form" method="POST">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required minlength="4">
            </div>
            <div class="form-group show-password">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required minlength="8">
                <i id="togglePassword" class="far fa-eye"></i>
            </div>
            <button id="login-button" type="submit" name="login">Iniciar Sesión</button>
            <div id="error-message"></div>
            <a href="#" id="register-link">Registrarse</a>
        </form>
    </div>

    <!-- Formulario de registro -->
    <div class="login-container" id="register-container">
        <h2>Registrarse</h2>
        <form id="register-form" method="POST">
            <div class="form-group">
                <label for="new-username">Usuario</label>
                <input type="text" id="new-username" name="new_username" placeholder="Crea tu usuario" required minlength="4">
            </div>
            <div class="form-group show-password">
                <label for="new-password">Contraseña</label>
                <input type="password" id="new-password" name="new_password" placeholder="Crea tu contraseña" required minlength="8">
                <i id="toggleNewPassword" class="far fa-eye"></i>
            </div>
            <button id="register-button" type="submit" name="register">Registrarse</button>
        </form>
        <a href="#" id="back-to-login">Volver al Inicio de Sesión</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginContainer = document.getElementById('login-container');
            const registerContainer = document.getElementById('register-container');
            const registerLink = document.getElementById('register-link');
            const backToLogin = document.getElementById('back-to-login');

            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                loginContainer.style.display = 'none';
                registerContainer.style.display = 'block';
            });

            backToLogin.addEventListener('click', function(e) {
                e.preventDefault();
                registerContainer.style.display = 'none';
                loginContainer.style.display = 'block';
            });
        });
    </script>

    <?php
    // Conexión a la base de datos MySQL
    $servername = "localhost"; // Cambia esto si tu servidor no está en localhost
    $username = "root"; // Tu usuario de MySQL
    $password = ""; // Tu contraseña de MySQL
    $dbname = "mi_base_datos"; // El nombre de tu base de datos
    $port = 3306; // Puerto de MySQL

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Registro de usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $newUsername = $_POST['new_username'];
        $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // Comprobar si el usuario ya existe
        $checkUser = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
        $checkUser->bind_param("s", $newUsername);
        $checkUser->execute();
        $checkUser->store_result();

        if ($checkUser->num_rows > 0) {
            echo "<script>document.getElementById('error-message').textContent = 'El nombre de usuario ya está en uso.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
        } else {
            // Preparar y ejecutar la inserción
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $newUsername, $newPassword);

            if ($stmt->execute()) {
                header("Location: index1.php");
                exit();
            } else {
                echo "<script>document.getElementById('error-message').textContent = 'Error: " . $stmt->error . "'; document.getElementById('error-message').style.visibility = 'visible';</script>";
            }
        }

        $stmt->close();
    }

    // Validación de inicio de sesión
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                header("Location: index1.php"); // Redirigir si el inicio de sesión es exitoso
                exit();
            } else {
                echo "<script>document.getElementById('error-message').textContent = 'Contraseña incorrecta.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
            }
        } else {
            echo "<script>document.getElementById('error-message').textContent = 'Usuario no encontrado.'; document.getElementById('error-message').style.visibility = 'visible';</script>";
        }

        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>