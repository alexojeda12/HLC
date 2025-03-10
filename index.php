<?php
session_start();
if (isset($_SESSION["nombre_usuario"])) {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido - Elden Ring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://wallpapercat.com/w/full/6/1/b/12229-3840x2160-desktop-4k-elden-ring-wallpaper.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            text-align: center;
            margin-top: 15%;
        }
        .btn-custom {
            width: 200px;
            margin: 10px;
            font-size: 18px;
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 15px;
            display: inline-block;
        }
        h1, p {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="overlay">
            <h1>Bienvenido a la Base de Datos de Elden Ring</h1>
            <p>Accede para explorar toda la información del juego.</p>
            <a href="login.php" class="btn btn-primary btn-lg btn-custom">Iniciar Sesión</a>
            <a href="registro.php" class="btn btn-success btn-lg btn-custom">Registrarse</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
