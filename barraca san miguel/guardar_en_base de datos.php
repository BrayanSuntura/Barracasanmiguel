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
    $cost = $_POST['cost']; // Asegúrate de que este campo exista en el formulario

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

<!DOCTYPE html>
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
        .total {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
    <script>
        // Datos de los tipos de madera con costos por debajo de 100
        const maderaDatos = {
            "Pino": { costo: 50 },
            "Roble": { costo: 70 },
            "Cedro": { costo: 60 },
            "Caoba": { costo: 80 },
            "Nogal": { costo: 90 },
            "Algarrobo": { costo: 85 },
            "Eucalipto": { costo: 75 },
            "Castaño": { costo: 65 },
            "Ciprés": { costo: 55 },
            "Teca": { costo: 95 },
            "Pau Ferro": { costo: 90 },
            "Tarara Amarilla": { costo: 85 },
            "Morado": { costo: 80 },
            "Tajibo": { costo: 70 },
            "Ipe": { costo: 95 }
        };

        const costoTabla = 30; // Costo fijo de una tabla (30 Bs)

        // Función para actualizar el costo y calcular el total
        function actualizarCosto() {
            const tipoMadera = document.getElementById("woodType").value;
            const metrosInput = document.getElementById("squareMeters");
            const tablasInput = document.getElementById("cantidadTablas");

            let costoMadera = 0;

            // Obtener el costo por metro cuadrado de la madera seleccionada
            if (maderaDatos[tipoMadera]) {
                costoMadera = maderaDatos[tipoMadera].costo;
            }

            // Calcular el costo total basado en la cantidad de tablas y el costo de la madera
            const cantidadMadera = parseFloat(metrosInput.value) || 0;
            const cantidadTablas = parseInt(tablasInput.value) || 1; // Cantidad de tablas
            const total = (cantidadMadera * costoMadera) + (cantidadTablas * costoTabla);

            // Mostrar el total calculado
            document.getElementById("total").textContent = "Total: " + total.toFixed(2) + " Bs";

            // Actualizar el valor del campo oculto 'cost' con el total calculado
            document.getElementById("cost").value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Formulario de Reserva</h1>
        <form id="reservationForm" action="" method="post">
            <!-- Campos originales -->
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="apellidopat">Apellido Paterno:</label>
                <input type="text" class="form-control" name="apellidopat" id="apellidopat" required>
            </div>

            <div class="form-group">
                <label for="apellidomat">Apellido Materno:</label>
                <input type="text" class="form-control" name="apellidomat" id="apellidomat" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" class="form-control" name="celular" id="celular" required>
            </div>

            <!-- Campos de madera -->
            <div class="form-group">
                <label for="woodType">Tipo de Madera:</label>
                <select class="form-control" name="woodType" id="woodType" required onchange="actualizarCosto()">
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
                <input type="number" class="form-control" name="squareMeters" id="squareMeters" required onchange="actualizarCosto()">
            </div>

            <div class="form-group">
                <label for="cantidadTablas">Cantidad de Tablas:</label>
                <input type="number" class="form-control" name="cantidadTablas" id="cantidadTablas" required value="1" onchange="actualizarCosto()">
            </div>

            <!-- Campo oculto para el costo -->
            <input type="hidden" name="cost" id="cost">

            <div id="total" class="total">Total:Bs</div>

            <button type="submit" class="btn btn-primary btn-submit">Enviar Reserva</button>
        </form>
    </div>
</body>
</html>

