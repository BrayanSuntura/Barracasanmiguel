<?php
// Conexión a la base de datos MySQL
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "mi_base_datos"; 
$port = 3306; 

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Actualización de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $userId = $_POST['user_id'];
    $updatedUsername = $_POST['updated_username'];
    $updatedPassword = $_POST['updated_password'];

    // Actualizar el usuario
    $stmt = $conn->prepare("UPDATE usuarios SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $updatedUsername, $updatedPassword, $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado con éxito.');</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Borrar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $userId = $_POST['user_id'];

    // Borrar el usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado con éxito.');</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Obtener usuarios
$result = $conn->query("SELECT id, username, password FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgba(255, 94, 98, 0.9), rgba(255, 149, 0, 0.9));
            color: #333;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .show-password {
            cursor: pointer;
            margin-left: 10px;
            font-size: 14px;
            color: #007BFF;
        }
    </style>
    <script>
        function togglePasswordVisibility(elementId) {
            const passwordField = document.getElementById(elementId);
            const currentType = passwordField.type;

            // Alternar entre texto y contraseña
            if (currentType === "password") {
                passwordField.type = "text";
                passwordField.nextElementSibling.textContent = "Ocultar";
            } else {
                passwordField.type = "password";
                passwordField.nextElementSibling.textContent = "Mostrar";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Lista de Usuarios Registrados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td>
                    <input type="password" id="password-<?php echo $row['id']; ?>" value="<?php echo $row['password']; ?>" readonly>
                    <span class="show-password" onclick="togglePasswordVisibility('password-<?php echo $row['id']; ?>')">Mostrar</span>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="updated_username" placeholder="Nuevo nombre" required>
                        <input type="password" name="updated_password" placeholder="Nueva contraseña" required>
                        <button type="submit" name="update">Actualizar</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php
    // Cerrar la conexión
    $conn->close();
    ?>
</body>
</html>

