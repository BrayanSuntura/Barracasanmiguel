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

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar los datos del formulario
    $nombre = $_POST['name'];
    $apellidopat = $_POST['apellidopat'];
    $apellidomat = $_POST['apellidomat'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $tipo_de_madera = $_POST['woodType'];
    $metros_cuadrados = $_POST['squareMeters'];
    $cost = $_POST['cost'];

    // Verificar que no haya campos vacíos
    if (empty($nombre) || empty($apellidopat) || empty($apellidomat) || empty($email) || empty($celular) || empty($tipo_de_madera) || empty($metros_cuadrados) || empty($cost)) {
        echo "<div class='alert alert-danger text-center'>Por favor, complete todos los campos.</div>";
    } else {
        // Preparar y ejecutar la consulta
        $stmt = $conecta->prepare("INSERT INTO reserva (nombre, apellidopat, apellidomat, correo_electronico, celular, tipo_de_madera, metros_cuadrados, cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssss", $nombre, $apellidopat, $apellidomat, $email, $celular, $tipo_de_madera, $metros_cuadrados, $cost);

            if ($stmt->execute()) {
                // Mensaje de registro exitoso
                echo "<div class='alert alert-success text-center'>Registro exitoso.</div>";
                // Vaciar el formulario
                $nombre = $apellidopat = $apellidomat = $email = $celular = $tipo_de_madera = $metros_cuadrados = $cost = '';
            } else {
                echo "<div class='alert alert-danger text-center'>Error al registrar: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger text-center'>Error al preparar la consulta: " . $conecta->error . "</div>";
        }
    }

    $conecta->close();
}
?>

<<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Reserva</title>
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
        .btn-submit {
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-to-home {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #d51e1e;
            border: 2px solid #1ddc0c;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s, color 0.3s;
        }
        .back-to-home:hover {
            background-color: #2bdd1b;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
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
    <script>
        // Datos de los tipos de madera
        const maderaDatos = {
            "Pino": { metros: 10, costo: 150 },
            "Roble": { metros: 15, costo: 200 },
            "Cedro": { metros: 8, costo: 180 },
            "Caoba": { metros: 12, costo: 220 },
            "Nogal": { metros: 10, costo: 250 },
            "Algarrobo": { metros: 9, costo: 230 },
            "Eucalipto": { metros: 14, costo: 190 },
            "Castaño": { metros: 7, costo: 210 },
            "Ciprés": { metros: 11, costo: 160 },
            "Teca": { metros: 10, costo: 240 },
            "Pau Ferro": { metros: 12, costo: 250 },
            "Tarara Amarilla": { metros: 13, costo: 210 },
            "Morado": { metros: 9, costo: 230 },
            "Tajibo": { metros: 10, costo: 200 },
            "Ipe": { metros: 8, costo: 270 }
        };

        // Función para autocompletar los campos y calcular el total
        function autoCompletar() {
            const tipoMadera = document.getElementById("woodType").value;
            const metrosInput = document.getElementById("squareMeters");
            const costoInput = document.getElementById("cost");

            let metros = 0;
            let costo = 0;

            if (maderaDatos[tipoMadera]) {
                metros = maderaDatos[tipoMadera].metros;
                costo = maderaDatos[tipoMadera].costo;
            }

            metrosInput.value = metros;
            costoInput.value = costo;

            // Calcular el total
            const cantidadMadera = parseFloat(metrosInput.value) || 0;
            const costoMadera = parseFloat(costoInput.value) || 0;
            const total = cantidadMadera * costoMadera;

            document.getElementById("total").textContent = "Total: " + total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Formulario de Reserva</h1>
        <form id="reservationForm" action="" method="post">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" name="name" id="name" required value="<?php echo isset($nombre) ? $nombre : ''; ?>">
            </div>

            <div class="form-group">
                <label for="apellidopat">Apellido Paterno:</label>
                <input type="text" class="form-control" name="apellidopat" id="apellidopat" required value="<?php echo isset($apellidopat) ? $apellidopat : ''; ?>">
            </div>

            <div class="form-group">
                <label for="apellidomat">Apellido Materno:</label>
                <input type="text" class="form-control" name="apellidomat" id="apellidomat" required value="<?php echo isset($apellidomat) ? $apellidomat : ''; ?>">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" id="email" required value="<?php echo isset($email) ? $email : ''; ?>">
            </div>

            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" class="form-control" name="celular" id="celular" required value="<?php echo isset($celular) ? $celular : ''; ?>">
            </div>

            <div class="form-group">
                <label for="woodType">Tipo de Madera:</label>
                <select class="form-control" name="woodType" id="woodType" required onchange="autoCompletar()">
                    <option value=""></option>
                    <option value="Pino">Pino</option>
                    <option value="Roble">Roble</option>
                    <option value="Cedro">Cedro</option>
                    <option value="Caoba">Caoba</option>
                    <option value="Nogal">Nogal</option>
                    <option value="Algarrobo">Algarrobo</option>
                    <option value="Eucalipto">Eucalipto</option>
                    <option value="Castaño">Castaño</option>
                    <option value="Ciprés">Ciprés</option>
                    <option value="Teca">Teca</option>
                    <option value="Pau Ferro">Pau Ferro</option>
                    <option value="Tarara Amarilla">Tarara Amarilla</option>
                    <option value="Morado">Morado</option>
                    <option value="Tajibo">Tajibo</option>
                    <option value="Ipe">Ipe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="squareMeters">Metros Cuadrados:</label>
                <input type="text" class="form-control" name="squareMeters" id="squareMeters" required>
            </div>

            <div class="form-group">
                <label for="cost">Costo:</label>
                <input type="text" class="form-control" name="cost" id="cost" required>
            </div>

            <div id="total" class="total">Total: 0.00</div>

            <button type="submit" class="btn btn-primary btn-submit">Enviar Reserva</button>
        </form>
    </div>
    <center>
    <a href="cliente.php" class="back-to-home">Volver al Inicio</a>    
    </center>
    

</body>
</html>






   