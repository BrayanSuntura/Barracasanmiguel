<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barraca_san_miguel_madera"; // Nombre de la base de datos
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

// Procesar actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['name'];
    $apellidopat = $_POST['apellidopat'];
    $apellidomat = $_POST['apellidomat'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $tipo_de_madera = $_POST['woodType'];
    $metros_cuadrados = $_POST['squareMeters'];
    $cost = $_POST['cost'];

    // Verificar que no haya campos vacíos
    if (!empty($nombre) && !empty($apellidopat) && !empty($apellidomat) && !empty($email) && !empty($celular) && !empty($tipo_de_madera) && !empty($metros_cuadrados) && !empty($cost)) {
        // Actualizar el registro en la base de datos
        $stmt = $conecta->prepare("UPDATE reserva SET nombre=?, apellidopat=?, apellidomat=?, correo_electronico=?, celular=?, tipo_de_madera=?, metros_cuadrados=?, cost=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("ssssssssi", $nombre, $apellidopat, $apellidomat, $email, $celular, $tipo_de_madera, $metros_cuadrados, $cost, $id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success text-center'>Reserva actualizada correctamente.</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Error al actualizar la reserva: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger text-center'>Error al preparar la consulta: " . $conecta->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Por favor, complete todos los campos.</div>";
    }
}

// Obtener todas las reservas
$result = $conecta->query("SELECT * FROM reserva");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reserva de Madera</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2c3e50;
            padding: 20px;
        }
        .container {
            margin-top: 50px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .table {
            margin-top: 20px;
        }
        .btn-update {
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-to-home {
    display: inline-block;
    width: 220px;
    margin: 20px auto;
    padding: 12px 25px;
    text-align: center;
    text-decoration: none;
    color: #fff;
    background: linear-gradient(45deg, #0b3d91, #001f54); /* Azul marino oscuro */
    border: 3px solid #0bda51;
    border-radius: 50px;
    font-family: 'Arial', sans-serif;
    font-weight: bold;
    font-size: 18px;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), inset 0px 0px 10px rgba(255, 255, 255, 0.3);
    transition: background 0.4s ease, transform 0.4s ease, box-shadow 0.4s ease, color 0.4s ease;
}

.back-to-home:hover {
    background: linear-gradient(45deg, #003366, #001033); /* Variación más clara en el hover */
    color: #f0f0f0;
    transform: scale(1.05);
    box-shadow: 5px 5px 25px rgba(0, 0, 0, 0.4), inset 0px 0px 15px rgba(255, 255, 255, 0.5);
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Reserva de Madera</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo Electrónico</th>
                    <th>Celular</th>
                    <th>Tipo de Madera</th>
                    <th>Metros Cuadrados</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="post" action="">
                        <td><?php echo $row['id']; ?><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></td>
                        <td><input type="text" name="name" class="form-control" value="<?php echo $row['nombre']; ?>"></td>
                        <td><input type="text" name="apellidopat" class="form-control" value="<?php echo $row['apellidopat']; ?>"></td>
                        <td><input type="text" name="apellidomat" class="form-control" value="<?php echo $row['apellidomat']; ?>"></td>
                        <td><input type="email" name="email" class="form-control" value="<?php echo $row['correo_electronico']; ?>"></td>
                        <td><input type="text" name="celular" class="form-control" value="<?php echo $row['celular']; ?>"></td>
                        <td>
                            <select name="woodType" class="form-control">
                                <option value="Pino" <?php if($row['tipo_de_madera'] == "Pino") echo "selected"; ?>>Pino</option>
                                <option value="Roble" <?php if($row['tipo_de_madera'] == "Roble") echo "selected"; ?>>Roble</option>
                                <option value="Cedro" <?php if($row['tipo_de_madera'] == "Cedro") echo "selected"; ?>>Cedro</option>
                                <option value="Caoba" <?php if($row['tipo_de_madera'] == "Caoba") echo "selected"; ?>>Caoba</option>
                                <option value="Nogal" <?php if($row['tipo_de_madera'] == "Nogal") echo "selected"; ?>>Nogal</option>
                                <option value="Algarrobo" <?php if($row['tipo_de_madera'] == "Algarrobo") echo "selected"; ?>>Algarrobo</option>
                                <option value="Eucalipto" <?php if($row['tipo_de_madera'] == "Eucalipto") echo "selected"; ?>>Eucalipto</option>
                                <option value="Castaño" <?php if($row['tipo_de_madera'] == "Castaño") echo "selected"; ?>>Castaño</option>
                                <option value="Ciprés" <?php if($row['tipo_de_madera'] == "Ciprés") echo "selected"; ?>>Ciprés</option>
                                <option value="Teca" <?php if($row['tipo_de_madera'] == "Teca") echo "selected"; ?>>Teca</option>
                                <option value="Pau Ferro" <?php if($row['tipo_de_madera'] == "Pau Ferro") echo "selected"; ?>>Pau Ferro</option>
                                <option value="Tarara Amarilla" <?php if($row['tipo_de_madera'] == "Tarara Amarilla") echo "selected"; ?>>Tarara Amarilla</option>
                                <option value="Morado" <?php if($row['tipo_de_madera'] == "Morado") echo "selected"; ?>>Morado</option>
                                <option value="Tajibo" <?php if($row['tipo_de_madera'] == "Tajibo") echo "selected"; ?>>Tajibo</option>
                                <option value="Ipe" <?php if($row['tipo_de_madera'] == "Ipe") echo "selected"; ?>>Ipe</option>
                            </select>
                        </td>
                        <td><input type="text" name="squareMeters" class="form-control" value="<?php echo $row['metros_cuadrados']; ?>"></td>
                        <td><input type="text" name="cost" class="form-control" value="<?php echo $row['cost']; ?>"></td>
                        <td>
                            <button type="submit" name="update" class="btn btn-primary btn-update">Guardar</button>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <center>
    <a href="index1.php" class="back-to-home">Volver al Inicio</a>    
    </center>
</body>
</html>

<?php
$conecta->close();
?>
