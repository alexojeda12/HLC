<?php
// Iniciar sesión y verificar si el usuario ha iniciado sesión
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
$query = "SELECT nombre, tipo, defensa_fisica, peso FROM armaduras WHERE 1=1";
if (!empty($filtro_nombre)) {
    $query .= " AND nombre LIKE '%" . mysqli_real_escape_string($conexion, $filtro_nombre) . "%'";
}
if (!empty($filtro_tipo)) {
    $query .= " AND tipo = '" . mysqli_real_escape_string($conexion, $filtro_tipo) . "'";
}

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Armaduras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
            background-image: url('https://steamuserimages-a.akamaihd.net/ugc/2058741034012526282/0D8DB3EEAF0AD23078CE9C6C6CCAEA128A4778FA/');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color: white;">Listado de Armaduras</h2>
        
        <!-- Formulario de filtros -->
        <form method="GET" class="row justify-content-center mb-4">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="<?= htmlspecialchars($filtro_nombre) ?>">
            </div>
            <div class="col-md-3">
                <select name="tipo" class="form-control">
                    <option value="">Todos los tipos</option>
                    <option value="Ligera" <?= $filtro_tipo == 'Ligera' ? 'selected' : '' ?>>Ligera</option>
                    <option value="Media" <?= $filtro_tipo == 'Media' ? 'selected' : '' ?>>Media</option>
                    <option value="Pesada" <?= $filtro_tipo == 'Pesada' ? 'selected' : '' ?>>Pesada</option>
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
                        <th>Defensa Física</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['nombre']) ?></td>
                            <td><?= htmlspecialchars($fila['tipo']) ?></td>
                            <td><?= htmlspecialchars($fila['defensa_fisica']) ?></td>
                            <td><?= htmlspecialchars($fila['peso']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">No hay armaduras registradas en la base de datos.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="home.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conexion);
?>
