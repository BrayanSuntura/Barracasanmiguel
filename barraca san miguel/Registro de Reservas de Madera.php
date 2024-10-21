<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Madera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
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
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
        <h2>Registro de Reservas de Madera</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Tipo de Madera</th>
                    <th>Metros Cuadrados</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "tu_usuario";
                $password = "";
                $dbname = "MaderaDB";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta para obtener las reservas de madera
                $sql = "SELECT * FROM reserva_de_madera";
                $result = $conn->query($sql);

                // Mostrar los resultados en la tabla
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["idreserva"] . "</td>
                                <td>" . $row["nombre"] . "</td>
                                <td>" . $row["correo_electronico"] . "</td>
                                <td>" . $row["tipo_de_madera"] . "</td>
                                <td>" . $row["metros_cuadrados"] . "</td>
                                <td>" . $row["costo"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay reservas</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <center>
    <a href="index1.php" class="back-to-home">Volver al Inicio</a>
    </center>
</body>
</html>