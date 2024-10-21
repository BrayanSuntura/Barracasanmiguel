<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escuela_db"; // Nombre de la base de datos
$port = 3306; // Puerto de MySQL

// Intentar conectar a la base de datos
$conecta = mysqli_connect($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if (!$conecta) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Configurar el conjunto de caracteres
if (!$conecta->set_charset("utf8")) {
    die("Error al configurar el conjunto de caracteres: " . $conecta->error);
}

// Manejo de inicio de sesión
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conecta->prepare("SELECT id, contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($contrasena, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: menu.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
    $stmt->close();
}

// Registro de asistencia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $curso = $_POST['curso'];
    $nivel_academico = $_POST['nivel_academico'];

    // Comprobar si la fecha es un día laborable
    $diaSemana = date('N', strtotime($fecha));
    if ($diaSemana < 6) { // 1 (lunes) a 5 (viernes)
        $stmt = $conecta->prepare("INSERT INTO asistencia (nombre, fecha, estado, curso, nivel_academico) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $fecha, $estado, $curso, $nivel_academico);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Asistencia registrada.";
    } else {
        $mensaje = "No se puede registrar asistencia en fines de semana.";
    }
}

// Obtener registros de asistencia
$result_asistencia = $conecta->query("SELECT * FROM asistencia");

// Registro de docentes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_docente'])) {
    $nombre_docente = $_POST['nombre_docente'];
    $categoria_docente = $_POST['categoria_docente'];

    $stmt = $conecta->prepare("INSERT INTO docentes (nombre, categoria) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre_docente, $categoria_docente);
    $stmt->execute();
    $stmt->close();
    $mensaje_docente = "Docente registrado.";
}

// Registro de estudiantes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_estudiante'])) {
    $nombre_estudiante = $_POST['nombre_estudiante'];
    $categoria_estudiante = $_POST['categoria_estudiante'];

    $stmt = $conecta->prepare("INSERT INTO estudiantes (nombre, categoria) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre_estudiante, $categoria_estudiante);
    $stmt->execute();
    $stmt->close();
    $mensaje_estudiante = "Estudiante registrado.";
}

// Obtener registros de docentes y estudiantes
$result_docentes = $conecta->query("SELECT * FROM docentes");
$result_estudiantes = $conecta->query("SELECT * FROM estudiantes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .menu {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido</h1>
        <div class="text-center menu">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#menuCollapse" aria-expanded="false" aria-controls="menuCollapse">
                Inicio
            </button>
        </div>

        <div class="collapse" id="menuCollapse">
            <div class="card">
                <div class="card-body">
                    <h3>Registro de Asistencia</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre del estudiante/docente</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" name="estado">
                                <option value="Presente">Presente</option>
                                <option value="Ausente">Ausente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="curso">Curso</label>
                            <input type="text" class="form-control" name="curso">
                        </div>
                        <div class="form-group">
                            <label for="nivel_academico">Nivel Académico</label>
                            <input type="text" class="form-control" name="nivel_academico">
                        </div>
                        <button type="submit" name="registrar" class="btn btn-primary btn-block">Registrar Asistencia</button>
                        <?php if (isset($mensaje)): ?>
                            <div class="alert alert-info mt-3"><?php echo $mensaje; ?></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Registro de Docentes</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre_docente">Nombre del Docente</label>
                            <input type="text" class="form-control" name="nombre_docente" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria_docente">Categoría</label>
                            <input type="text" class="form-control" name="categoria_docente" required>
                        </div>
                        <button type="submit" name="registrar_docente" class="btn btn-success btn-block">Registrar Docente</button>
                        <?php if (isset($mensaje_docente)): ?>
                            <div class="alert alert-info mt-3"><?php echo $mensaje_docente; ?></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Registro de Estudiantes</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre_estudiante">Nombre del Estudiante</label>
                            <input type="text" class="form-control" name="nombre_estudiante" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria_estudiante">Categoría</label>
                            <input type="text" class="form-control" name="categoria_estudiante" required>
                        </div>
                        <button type="submit" name="registrar_estudiante" class="btn btn-info btn-block">Registrar Estudiante</button>
                        <?php if (isset($mensaje_estudiante)): ?>
                            <div class="alert alert-info mt-3"><?php echo $mensaje_estudiante; ?></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Lista de Asistencias</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Curso</th>
                                <th>Nivel Académico</th>
                            </
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_asistencia->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['fecha']; ?></td>
                                    <td><?php echo $row['estado']; ?></td>
                                    <td><?php echo $row['curso']; ?></td>
                                    <td><?php echo $row['nivel_academico']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Lista de Docentes</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_docentes->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['categoria']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Lista de Estudiantes</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_estudiantes->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['categoria']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar conexión
$conecta->close();
?>

