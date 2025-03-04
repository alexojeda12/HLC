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
    <title>Inicio - Elden Ring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://steamuserimages-a.akamaihd.net/ugc/2058741034012525685/D0FBE13833A04573BA78B1584C510EFC5CED0DEF/');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .main-title {
            color: white;
        }
        .subtitle {
            color: white;
        }
        /* Estilos de la caja de noticia */
        .news-box {
            background-color: rgba(0, 0, 0, 0.6); 
            border-radius: 10px;
            overflow: hidden;
            margin-top: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .news-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-content {
            padding: 15px;
        }
        .news-title {
            font-size: 1.5em;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .news-description {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand"><img src="https://1000marcas.net/wp-content/uploads/2024/08/Elden-Ring-Logo.png" alt="Elden Ring Logo" style="height: 65px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="leerarmas.php">Ver Armas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leerarmaduras.php">Ver Armaduras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leerjefes.php">Ver Jefes</a>
                </li>
                <?php if (isset($_SESSION["nombre_usuario"])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white">¡Bienvenido, <?php echo $_SESSION["nombre_usuario"]; ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                    <?php if ($_SESSION["rol"] == "admin"): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Panel Admin</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <div class="container text-center mt-5">
        <h1 class="main-title">Base de Datos de Elden Ring</h1>
        <p class="subtitle">Consulta información y entérate de las últimas novedades del juego.</p>
        
        <!-- Primera caja de noticia -->
        <div class="news-box">
            <a href="noticia1.php">
                <img class="news-image" src="https://media.graphassets.com/zR249sYTuumbsLpWbE9W" alt="Noticia Imagen">
                <div class="news-content">
                    <h2 class="news-title">Elden Ring Nightreign</h2>
                    <p class="news-description">Fecha de Lanzamiento y Novedades</p>
                </div>
            </a>
        </div>

        <!-- Segunda caja de noticia (vacía por ahora, pero lista para añadir contenido) -->
        <div class="news-box">
            <a href="noticia2.php">
                <img class="news-image" src="https://gaming-cdn.com/images/products/13652/orig/elden-ring-shadow-of-the-erdtree-pc-juego-steam-europe-cover.jpg?v=1718975158" alt="Segunda Noticia Imagen">
                <div class="news-content">
                    <h2 class="news-title">Próxima Actualización en Elden Ring</h2>
                    <p class="news-description">Detalles y características de la próxima actualización.</p>
                </div>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
