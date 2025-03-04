<?php
session_start();
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elden Ring: Nightreign - Fecha de Lanzamiento y Novedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://the4kwallpaperfactory.com/wp-content/uploads/2023/06/elden-ring-wallpaper-fond-ecran-godfrey-hoara-loux-painting-style-4k-mobile-phone-desktop-scaled.jpg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        .news-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            margin-top: 50px;
            border-radius: 10px;
        }
        .news-title {
            font-size: 2.5rem;
            color: white;
            text-align: center;
        }
        .news-date {
            font-size: 1rem;
            text-align: center;
            color: #bbb;
            margin-bottom: 20px;
        }
        .news-content {
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .news-img {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #f8d210;
            color: #121212;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #e0c10d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="news-container">
            <h1 class="news-title">Elden Ring: Nightreign - Fecha de Lanzamiento y Novedades</h1>
            <p class="news-date"><strong>30 de mayo de 2025</strong></p>
            <img src="https://media.graphassets.com/zR249sYTuumbsLpWbE9W" class="img-fluid rounded mx-auto d-block news-img" alt="Elden Ring Nightreign">
            <p class="news-content">
                <strong>Elden Ring: Nightreign</strong> es la próxima edición especial del aclamado RPG de acción de FromSoftware. 
                Su lanzamiento está programado para el <strong>30 de mayo de 2025</strong>, ofreciendo a los jugadores una nueva forma de sumergirse en el mundo de las Tierras Intermedias.
            </p>
            <h3 class="news-content">Novedades de Nightreign</h3>
            <ul class="news-content">
                <li>Incluye la versión base del juego con todas las actualizaciones.</li>
                <li>Contenido adicional exclusivo, como arte conceptual y banda sonora.</li>
                <li>Optimización y mejoras gráficas para la nueva generación.</li>
            </ul>
            <p class="news-content">Si aún no has explorado el mundo de <strong>Elden Ring</strong>, esta edición es la oportunidad perfecta para adentrarte en una de las mejores experiencias de rol y acción de los últimos años.</p>
            <div class="text-center mt-4">
                <a href="home.php" class="btn btn-custom">Volver al Inicio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
