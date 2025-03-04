<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contraseña = $_POST['contraseña'];

    $stmt = $conexion->prepare("SELECT id, nombre_usuario, contraseña, rol FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Almacenar datos en la sesión
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://wallpapers.com/images/hd/elden-ring-eternal-queen-sdo2qgcc593i6l6l.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-primary {
            background-color: #ffd700;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e6c200;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-container">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (isset($error)) echo "<p class='error-message text-center'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
        <!-- <p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php" class="text-warning">Regístrate aquí</a></p> -->
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>