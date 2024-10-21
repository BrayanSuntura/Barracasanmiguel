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

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $orderNumber = $_POST['order-number'];
    $reason = $_POST['reason'];
    $comments = $_POST['comments'];

    $sql = "INSERT INTO devoluciones (nombre, correo_electronico, numero_pedido, razon, comentarios)
            VALUES ('$name', '$email', '$orderNumber', '$reason', '$comments')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Devolución registrada con éxito');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Devolución</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #2c3e50;
        }
        .container {
            max-width: 800px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        input, textarea, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
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
        <h1>Política de Devolución</h1>
        <form action="" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="order-number">Número de Pedido:</label>
            <input type="text" id="order-number" name="order-number" required>

            <label for="reason">Razón de la Devolución:</label>
            <select id="reason" name="reason" required>
                <option value="">Seleccione una razón</option>
                <option value="damaged">Producto Dañado</option>
                <option value="wrong-item">Producto Incorrecto</option>
                <option value="not-satisfied">No Satisfecho</option>
                <option value="other">Otra Razón</option>
            </select>

            <label for="comments">Comentarios Adicionales:</label>
            <textarea id="comments" name="comments" rows="4"></textarea>
            
            <button type="submit">Enviar Devolución</button>
        </form>
    </div>
    <center>
   <!-- <a href="inicio.php" class="back-to-home">Volver al Inicio</a> -->
    </center>
</body>
</html>
