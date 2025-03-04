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
    <title>Elden Ring: Shadow of the Erdtree - Todo lo que Necesitas Saber</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images3.alphacoders.com/135/1352926.png');
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
            <h1 class="news-title">Elden Ring: Shadow of the Erdtree - Todo lo que Necesitas Saber</h1>
            <p class="news-date"><strong>10 de febrero de 2025</strong></p>
            <img src="https://gaming-cdn.com/images/products/13652/orig/elden-ring-shadow-of-the-erdtree-pc-juego-steam-europe-cover.jpg?v=1718975158" class="img-fluid rounded mx-auto d-block news-img" alt="Elden Ring Shadow of the Erdtree">
            <p class="news-content">
                <strong>Elden Ring: Shadow of the Erdtree</strong> es el esperado DLC que expande aún más el universo de <strong>Elden Ring</strong> con nuevas tierras por explorar y desafíos por superar. Este contenido adicional llega para expandir el lore del juego y ofrecer a los jugadores nuevas mecánicas y secretos.
            </p>
            <h3 class="news-content">Novedades de Shadow of the Erdtree</h3>
            <ul class="news-content">
                <li>Explora el misterioso mundo de las tierras sombrías, donde la Erdtree ya no es lo que solía ser.</li>
                <li>Encuentra nuevos enemigos, jefes y una historia que promete sorprender a los fanáticos.</li>
                <li>Adquiere nuevas habilidades y equipo, perfeccionando tu personaje en este desafío expandido.</li>
            </ul>
            <p class="news-content">Si creías que <strong>Elden Ring</strong> no podía ser más grande, este DLC te demostrará lo contrario. <strong>Shadow of the Erdtree</strong> es un viaje que los veteranos del juego no pueden dejar pasar.</p>
            <div class="text-center mt-4">
                <a href="home.php" class="btn btn-custom">Volver al Inicio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
