<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/646c794df3.js">
    <style>
        body {
            background: #f1f1f1;
        }

        .barra {
            background: #00ADEF;
            padding-top: 15px;
            padding-bottom: 15px;
            margin: 0;
            width: 100%; /* Asegura que la franja ocupe el ancho completo */
        }

        .barra-lateral {
            background: #252121;
            color: #fff;
            min-width: 250px;
            min-height: 100vh;
            padding: 0;
        }

        .barra-lateral a {
            color: #fff;
            display: block;
            padding: 20px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .barra-lateral a:hover {
            background-color: #003C5D;
        }

        .main-content {
            padding-top: 40px;
        }

        iframe {
            width: 100%;
            height: 80vh;
            border: none;
        }

        .inicio-container {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h2, h3 {
            color: #007BFF;
        }

        ul {
            list-style-type: square;
        }

        ul li {
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .back-to-home {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light">BARRACA SAN MIGUEL</h4>
            </div>
            <div class="col-4 text-right barra">
                <!-- Aquí estaba el botón de cerrar sesión, eliminado -->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
                    <a href="#" onclick="loadContent('inicio_cliente')">Inicio</a>
                    <a href="#" onclick="loadContent('index6.php')">Productos</a>
                    <a href="#" onclick="loadContent('guardar_en_base de datos.php')">Reserva</a>
                    <a href="#" onclick="loadContent('index5.php')">Contacto</a>
                </nav>
            </div>
            <main class="main col main-content">
                <iframe id="iframeContent" src=""></iframe>
            </main>
        </div>
    </div>

    <script>
        function loadContent(page) {
            const iframe = document.getElementById("iframeContent");
            if (page === 'inicio_cliente') {
                iframe.src = ""; // Clear iframe for 'Inicio'
                document.getElementById("iframeContent").contentDocument.body.innerHTML = inicioContent; // Load Inicio content
            } else {
                iframe.src = page; // Load other pages
            }
        }

        // Load the initial content
        loadContent('inicio_cliente');
    </script>

    <footer>
        <p>&copy; 2024 Barraca San Miguel. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

