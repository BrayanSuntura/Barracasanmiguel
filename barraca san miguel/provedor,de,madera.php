<?php
session_start(); // Iniciar la sesión para usar variables de sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Barraca San Miguel Madera"; // Nombre correcto de la base de datos
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los tipos de madera y costos
$sql = "SELECT * FROM `provedor de madera`";
$result = $conn->query($sql);

// Agregar nueva madera
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['precio'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $insert_sql = "INSERT INTO `provedor de madera` (nombre, precio) VALUES ('$nombre', $precio)";
    if ($conn->query($insert_sql) === TRUE) {
        $_SESSION['message'] = 'Madera agregada exitosamente'; // Almacena mensaje en sesión
        header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página
        exit();
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Eliminar madera
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM `provedor de madera` WHERE id=$id";
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['message'] = 'Madera eliminada exitosamente'; // Almacena mensaje en sesión
        header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedor de Madera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #bbb 1px solid;
            margin-bottom: 20px;
        }
        header h1 {
            text-align: center;
            text-transform: uppercase;
            margin: 0;
            font-size: 24px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }
        .menu {
            display: flex;
            justify-content: flex-start;
            margin: 20px 0;
        }
        .menu-button {
            padding: 10px 20px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .menu-button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background: #007BFF;
            color: #fff;
        }
        table tr:nth-child(even) {
            background: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .form-container, .available-wood-container {
            display: none;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .form-container button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .alert {
            background: #e0f7fa;
            padding: 10px;
            border: 1px solid #00796b;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById('add-form');
            const availableWood = document.getElementById('available-wood');
            // Alternar la visibilidad del formulario de agregar madera
            if (form.style.display === 'block') {
                form.style.display = 'none'; // Ocultar el formulario si ya está visible
            } else {
                form.style.display = 'block'; // Mostrar el formulario
                availableWood.style.display = 'none'; // Ocultar la sección de madera disponible
            }
        }

        function showAvailableWood() {
            const form = document.getElementById('add-form');
            const availableWood = document.getElementById('available-wood');
            // Mostrar la sección de madera disponible y ocultar el formulario
            if (availableWood.style.display === 'block') {
                availableWood.style.display = 'none'; // Ocultar si ya está visible
            } else {
                availableWood.style.display = 'block'; // Mostrar madera disponible
                form.style.display = 'none'; // Ocultar el formulario
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Proveedor de Madera</h1>
        </div>
    </header>
    <div class="container">
        <?php
        // Mostrar mensaje si existe en la sesión
        if (isset($_SESSION['message'])) {
            echo "<div class='alert'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
        }
        ?>
        <div class="menu">
            <button class="menu-button" onclick="toggleForm()">Agregar Madera</button>
            <button class="menu-button" onclick="showAvailableWood()">Madera Disponible</button>
        </div>

        <div class="form-container" id="add-form">
            <h2>Agregar Tipo de Madera</h2>
            <form method="post" action="">
                <input type="text" name="nombre" placeholder="Nombre de la Madera" required>
                <input type="number" name="precio" placeholder="Costo" step="0.01" required>
                <button type="submit">Agregar</button>
            </form>
        </div>

        <div id="available-wood" class="available-wood-container">
            <h2>Madera Disponible</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['precio']}</td>
                                    <td><a href='?delete={$row['id']}' onclick='return confirm(\"¿Está seguro de que desea eliminar este elemento?\")'>Eliminar</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay madera disponible</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>

<?php
$conn->close(); // Cerrar conexión
?>
