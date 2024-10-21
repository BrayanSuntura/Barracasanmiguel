<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
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
                <button id="cerrarSesionBtn" class="btn btn-danger">Cerrar Sesión</button>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
                    <a href="#" onclick="loadContent('inicio')">Inicio</a> <!-- Botón Inicio -->
                    <a href="#" onclick="loadContent('index7.php')">Historia</a>
                    <a href="#" onclick="loadContent('index6.php')">Productos</a>
                    <a href="#" onclick="loadContent('guardar_en_base de datos.php')">Reserva</a>
                    <a href="#" onclick="loadContent('index4.php')">Cómo Comprar</a>
                    <a href="#" onclick="loadContent('index3.php')">Reserva de Devolución</a>
                    <a href="#" onclick="loadContent('index5.php')">Contacto</a>
                    <a href="#" onclick="loadContent('registro,de,madera.php')">Registro de Madera</a>
                    <a href="#" onclick="loadContent('devolucion,de,reserva.php')">Registro de Devolución</a>
                  
                </nav>
            </div>
            <main class="main col main-content">
                <iframe id="iframeContent" src=""></iframe>
            </main>
        </div>
    </div>

    <script>
        const inicioContent = `
            <div class="inicio-container">
                <header>
                    <h1>Bienvenido a Barraca San Miguel</h1>
                <section id="propiedades">
        <h2>Propiedades de la Madera</h2>
        <div class="content">
            <p>La polaridad de la madera le hace afín con otros productos polares como agua, barnices, pegamentos con base de agua. La densidad de la madera varía notablemente entre especies...</p>
            <img src="img/propiedades.jpeg" alt="Propiedades de la madera">
        </div>
    </section>

    <section id="dureza">
        <h2>Dureza de la Madera</h2>
        <div class="content">
            <p>Según su dureza, la madera se clasifica en:</p>
            <ul>
                <li><strong>Maderas duras:</strong> Son más densas y soportan mejor las inclemencias del tiempo. Ejemplos: haya, roble, nogal.</li>
                <li><strong>Maderas blandas:</strong> Son ligeras y de precio menor. Ejemplos: pino, abeto, abedul.</li>
                <li><strong>Maderas de dureza media:</strong> Ejemplo: castaño, que es flexible.</li>
            </ul>
            <img src="img/dureza-maderas.png" alt="Dureza de la madera">
        </div>
    </section>

    <section id="usos">
        <h2>Usos de la Madera</h2>
        <div class="content">
            <ul>
                <li>Pavimentos</li>
                <li>Menaje</li>
                <li>Carpintería</li>
                <li>Medicina</li>
            </ul>
            <img src="img/descarga (3).jpeg" alt="Usos de la madera">
        </div>
    </section>
    <section id="bosques-bolivia">
    <h2>Bosques de los Nueve Departamentos de Bolivia (Actualizado: 18 de septiembre de 2024)</h2>
    <div class="content">
        <p>Bolivia, con su vasta diversidad geográfica y climática, alberga una rica variedad de ecosistemas forestales. Cada uno de los nueve departamentos del país presenta características únicas que contribuyen a la diversidad de sus bosques.</p>

        <h3>La Paz</h3>
        <p>Los bosques de La Paz, ubicados en altitudes que varían desde los 3,000 hasta los 6,000 metros sobre el nivel del mar, son hogar de especies como el pino, la quina y el molle. En las zonas montañosas, la vegetación es densa y variada, incluyendo áreas de yunga donde crecen árboles frutales y plantas medicinales. Estos bosques son esenciales para la regulación del clima local y la conservación del agua, además de ser un hábitat para numerosas especies de flora y fauna endémicas.</p>

        <h3>Santa Cruz</h3>
        <p>El departamento de Santa Cruz se destaca por sus extensas llanuras y selvas tropicales. Los bosques de esta región están dominados por especies como el cedro, el viru viru y la caoba. Este ecosistema es vital para la biodiversidad y es conocido por su alta producción de madera de alta calidad. Los bosques tropicales de Santa Cruz también son importantes para la agricultura sostenible, proporcionando sombra y recursos para cultivos diversos, así como hábitat para especies en peligro de extinción como el jaguar y la anaconda.</p>

        <h3>Cochabamba</h3>
        <p>En Cochabamba, los bosques se encuentran en zonas de valles interandinos y montañas. Aquí predominan las especies de algarrobo y el eucalipto. Los bosques de esta región son importantes para la conservación del agua y la prevención de la erosión del suelo. Además, estos bosques proporcionan recursos maderables y no maderables, contribuyendo a la economía local y a la subsistencia de muchas familias. La rica biodiversidad de la región también apoya la producción de alimentos y medicamentos a partir de plantas nativas.</p>

        <h3>Potosí</h3>
        <p>Los bosques de Potosí están situados en zonas de gran altitud, donde el clima es más seco. Las especies de árboles como el queñua y la chuño son comunes. Estos bosques son fundamentales para las comunidades locales, ya que proporcionan madera y otros recursos. La recolección de productos forestales no maderables, como hierbas medicinales y frutos, es una actividad tradicional en la región. Estos bosques también son cruciales para la conservación del suelo y la regulación de los ciclos hidrológicos.</p>

        <h3>Oruro</h3>
        <p>En Oruro, los bosques son escasos y generalmente se encuentran en áreas montañosas. Las especies como el pino y el eucalipto son comunes, y la vegetación es adaptativa a las condiciones áridas del entorno. Aunque menos biodiversos, estos bosques juegan un papel importante en la prevención de la desertificación y en la mejora de la calidad del aire. Las comunidades locales dependen de estos bosques para leña y materiales de construcción, así como para la producción de productos agrícolas que requieren sombra.</p>

        <h3>Tarija</h3>
        <p>Tarija presenta un clima más templado y sus bosques son diversos, incluyendo especies de pinos y robles. Los bosques de Tarija son cruciales para la producción de madera y también para la preservación de la fauna local. La región es conocida por su producción de vino y, por lo tanto, los bosques también son importantes para mantener la calidad del suelo y del agua en las áreas de cultivo. La conservación de estos bosques ayuda a proteger la biodiversidad regional y a mitigar el cambio climático mediante la captura de carbono.</p>

        <h3>Chuquisaca</h3>
        <p>Los bosques de Chuquisaca están compuestos principalmente por especies nativas que crecen en las áreas de los valles. La vegetación es rica y variada, y es fundamental para el sustento de las comunidades locales. Estos bosques son el hogar de muchas especies de aves y mamíferos, lo que contribuye a la biodiversidad. Además, la recolección de frutos y plantas medicinales es una actividad común en esta región, promoviendo prácticas sostenibles y el uso responsable de los recursos naturales.</p>

        <h3>Beni</h3>
        <p>Beni alberga vastas extensiones de selvas tropicales, donde se encuentran especies como el marañón, el castaño y la palma. Estos bosques son importantes para la biodiversidad y son un recurso vital para las comunidades indígenas. La explotación sostenible de los recursos forestales, como la producción de aceite de palma y la recolección de frutos, es esencial para la economía local. Además, estos bosques ayudan a regular el clima y son clave para la conservación del agua en la región.</p>

        <h3>Pando</h3>
        <p>El departamento de Pando está cubierto en gran parte por bosques tropicales húmedos, donde abundan especies como el cedro, la caoba y el aguaje. La riqueza de estos bosques es crucial para la economía local y la conservación del medio ambiente. La explotación responsable de estos recursos contribuye a la sostenibilidad, y los bosques de Pando son esenciales para la protección de la biodiversidad, albergando numerosas especies de flora y fauna únicas. Estos ecosistemas también juegan un papel importante en la mitigación del cambio climático al capturar dióxido de carbono.</p>
    </div>
</section> 
                <footer>
                    <p>&copy; 2024 Barraca San Miguel - Todos los derechos reservados</p>
                </footer>
            </div>
        `;

        function loadContent(page) {
            if (page === 'inicio') {
                // Cargar el contenido de inicio en el iframe
                var iframe = document.getElementById('iframeContent');
                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(inicioContent);
                iframe.contentWindow.document.close();
            } else {
                // Cargar contenido de otras páginas
                document.getElementById('iframeContent').src = page;
            }
        }

        document.getElementById('cerrarSesionBtn').addEventListener('click', function() {
            window.location.href = 'index.php';
        });

        // Cargar automáticamente el contenido de "Inicio" al cargar la página
        window.onload = function() {
            loadContent('inicio');
        };
    </script>

</body>
</html>

