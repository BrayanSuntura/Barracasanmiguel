<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservas_devolucion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Actualizar registro si se envía el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo_electronico = $_POST['correo_electronico'];
    $numero_pedido = $_POST['numero_pedido'];
    $razon = $_POST['razon'];
    $comentarios = $_POST['comentarios'];

    $sql = "UPDATE devoluciones SET 
                nombre='$nombre', 
                correo_electronico='$correo_electronico', 
                numero_pedido='$numero_pedido', 
                razon='$razon', 
                comentarios='$comentarios' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error actualizando el registro: " . $conn->error;
    }
}

// Consultar todas las devoluciones
$sql = "SELECT * FROM devoluciones";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Devoluciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #2c3e50;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
            color: #2c3e50;
        }
        th {
            background-color: #2980b9;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            box-sizing: border-box;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions button {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .actions button:hover {
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
        <h1>Registro de Devoluciones</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Número de Pedido</th>
                <th>Razón</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar cada fila de datos con opción de edición
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form method='POST' action=''>
                                <td><input type='hidden' name='id' value='" . $row["id"] . "'>" . $row["id"] . "</td>
                                <td><input type='text' name='nombre' value='" . $row["nombre"] . "'></td>
                                <td><input type='email' name='correo_electronico' value='" . $row["correo_electronico"] . "'></td>
                                <td><input type='text' name='numero_pedido' value='" . $row["numero_pedido"] . "'></td>
                                <td>
                                    <select name='razon'>
                                        <option value='damaged' " . ($row["razon"] == "damaged" ? "selected" : "") . ">Producto Dañado</option>
                                        <option value='wrong-item' " . ($row["razon"] == "wrong-item" ? "selected" : "") . ">Producto Incorrecto</option>
                                        <option value='not-satisfied' " . ($row["razon"] == "not-satisfied" ? "selected" : "") . ">No Satisfecho</option>
                                        <option value='other' " . ($row["razon"] == "other" ? "selected" : "") . ">Otra Razón</option>
                                    </select>
                                </td>
                                <td><textarea name='comentarios'>" . $row["comentarios"] . "</textarea></td>
                                <td class='actions'>
                                    <button type='submit' name='update'>Guardar</button>
                                </td>
                            </form>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay devoluciones registradas</td></tr>";
            }
            ?>
        </table>
    </div>
    <center>
    <!-- <a href="inicio.php" class="back-to-home">Volver al Inicio</a> -->

    </center>
   
</body>
</html>

<?php
$conn->close();
?>
