<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestor_archivos";
$port = '3306'; 
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de formulario para crear categoría
if (isset($_POST['crear_categoria'])) {
    $nombre_categoria = $conn->real_escape_string($_POST['nombre_categoria']);
    $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre_categoria')";
    if ($conn->query($sql) === TRUE) {
        echo "Categoría creada exitosamente";
    } else {
        echo "Error al crear categoría: " . $conn->error;
    }
}

// Manejo de formulario para subir archivo
if (isset($_POST['subir_archivo'])) {
    $categoria_id = intval($_POST['categoria_id']);
    $nombre_archivo = $_FILES['archivo']['name'];
    $ruta_archivo = "uploads/" . basename($nombre_archivo);

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)) {
        $sql = "INSERT INTO archivos (nombre, ruta, categoria_id) VALUES ('$nombre_archivo', '$ruta_archivo', $categoria_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Archivo subido exitosamente";
        } else {
            echo "Error al subir archivo: " . $conn->error;
        }
    } else {
        echo "Error al mover el archivo";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Archivos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .container {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Menú desplegable -->
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="menuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Crear Categoría
            </button>
            <div class="dropdown-menu" aria-labelledby="menuDropdown">
                <form action="" method="post">
                    <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre de categoría" required>
                    <button type="submit" name="crear_categoria" class="btn btn-primary mt-2">Crear</button>
                </form>
                <div class="dropdown-divider"></div>
                <?php
                $sql = "SELECT * FROM categorias";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<a class='dropdown-item' href='#' onclick='mostrarArchivos(" . $row['id'] . ")'>" . $row['nombre'] . "</a>";
                }
                ?>
            </div>
        </div>

        <!-- Subir archivo -->
        <h3 class="mt-4">Subir Archivo</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select name="categoria_id" class="form-control" required>
                    <?php
                    $sql = "SELECT * FROM categorias";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="archivo">Archivo:</label>
                <input type="file" name="archivo" class="form-control-file" required>
            </div>
            <button type="submit" name="subir_archivo" class="btn btn-primary">Subir</button>
        </form>

        <!-- Mostrar archivos -->
        <h3 class="mt-4">Archivos</h3>
        <div id="archivos">
            <!-- Los archivos se mostrarán aquí -->
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function mostrarArchivos(categoriaId) {
            fetch('mostrar_archivos.php?categoria_id=' + categoriaId)
                .then(response => response.text())
                .then(data => document.getElementById('archivos').innerHTML = data);
        }
    </script>
</body>
</html>
