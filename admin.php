<?php
session_start();
if (!isset($_SESSION["nombre_usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

require_once "conexion.php"; // Asegúrate de tener un archivo db.php con la conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="home.php">Elden Ring Admin</a>
        <a class="btn btn-danger" href="logout.php">Cerrar Sesión</a>
    </div>
</nav>
<div class="container mt-4">
    <h1 class="text-center">Panel de Administración</h1>
    <div class="row">
        <div class="col-md-3"><a href="crud_armaduras.php" class="btn btn-primary w-100 mb-3">Gestionar Armaduras</a></div>
        <div class="col-md-3"><a href="crud_armas.php" class="btn btn-primary w-100 mb-3">Gestionar Armas</a></div>
        <div class="col-md-3"><a href="crud_jefes.php" class="btn btn-primary w-100 mb-3">Gestionar Jefes</a></div>
        <div class="col-md-3"><a href="crud_usuarios.php" class="btn btn-warning w-100 mb-3">Gestionar Usuarios</a></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
