<?php

session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener valores de los filtros
$filtro_nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$filtro_tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Construcción de la consulta con filtros
$query = "SELECT nombre, tipo, daño_base, escalado FROM armas WHERE 1=1";
if (!empty($filtro_nombre)) {
    $query .= " AND nombre LIKE '%" . mysqli_real_escape_string($conexion, $filtro_nombre) . "%'";
}
if (!empty($filtro_tipo)) {
    $query .= " AND tipo = '" . mysqli_real_escape_string($conexion, $filtro_tipo) . "'";
}

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta tuvo éxito
if ($resultado === false) {
    // Si la consulta falló, mostrar el error
    echo "Error en la consulta: " . mysqli_error($conexion);
    exit;  // Detener la ejecución si hay un error
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Armas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
            background-image: url('https://steamuserimages-a.akamaihd.net/ugc/2058741034012526093/D413A8F912EDED5B50A0B6A9DFFB2C3DBBFF76A2/');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color: white;">Listado de Armas</h2>
        
        <!-- Formulario de filtros -->
        <form method="GET" class="row justify-content-center mb-4">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="<?= htmlspecialchars($filtro_nombre) ?>">
            </div>
            <div class="col-md-3">
                <select name="tipo" class="form-control">
                    <option value="">Todos los tipos</option>
                    <option value="Espada recta" <?= $filtro_tipo == 'Espada recta' ? 'selected' : '' ?>>Espada recta</option>
                    <option value="Gran espada curva" <?= $filtro_tipo == 'Gran espada curva' ? 'selected' : '' ?>>Gran espada curva</option>
                    <option value="Catana" <?= $filtro_tipo == 'Catana' ? 'selected' : '' ?>>Catana</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Daño Base</th>
                        <th>Escalado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['tipo']) ?></td>
                            <td><?= htmlspecialchars($fila['daño_base']) ?></td>
                            <td><?= htmlspecialchars($fila['escalado']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">No hay armas registradas en la base de datos.</div>
        <?php endif; ?>
        
        <!-- Botón para volver al índice -->
        <div class="text-center mt-4">
            <a href="home.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conexion);
?>
