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
$filtro_ubicacion = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : '';
$filtro_historia = isset($_GET['requisito_historia']) ? $_GET['requisito_historia'] : '';

// Construcción de la consulta con filtros
$query = "SELECT id, nombre, ubicacion, requisito_historia FROM jefes WHERE 1=1";

if (!empty($filtro_nombre)) {
    $query .= " AND nombre LIKE '%" . mysqli_real_escape_string($conexion, $filtro_nombre) . "%'";
}
if (!empty($filtro_ubicacion)) {
    $query .= " AND ubicacion LIKE '%" . mysqli_real_escape_string($conexion, $filtro_ubicacion) . "%'";
}
if (!empty($filtro_historia)) {
    $query .= " AND requisito_historia = '" . mysqli_real_escape_string($conexion, $filtro_historia) . "'";
}

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Jefes - Elden Ring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://steamuserimages-a.akamaihd.net/ugc/2058741034012527559/6D2D9F074AD78EB3FA8EDF990BF0664BD4F94F1E/');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        .table {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
        }
        .table th {
            background-color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Jefes Principales - Elden Ring</h2>
        
        <!-- Formulario de filtros -->
        <form method="GET" class="row justify-content-center mb-4">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="<?= htmlspecialchars($filtro_nombre) ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="ubicacion" class="form-control" placeholder="Buscar por ubicación" value="<?= htmlspecialchars($filtro_ubicacion) ?>">
            </div>
            <div class="col-md-3">
                <select name="requisito_historia" class="form-control">
                    <option value="">Requisito de historia</option>
                    <option value="Sí" <?= $filtro_historia == 'Sí' ? 'selected' : '' ?>>Sí</option>
                    <option value="No" <?= $filtro_historia == 'No' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <div class="col-md-2 text-center">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
        
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Requisito Historia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['id']) ?></td>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['ubicacion']) ?></td>
                            <td><?= htmlspecialchars($fila['requisito_historia']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">No se encontraron jefes con esos filtros.</div>
        <?php endif; ?>

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
