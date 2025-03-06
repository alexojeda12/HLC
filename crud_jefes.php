<?php
session_start();
include 'conexion.php'; // Conexión a la BD

// Verificar si el usuario es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado");
}

// Cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Manejo de inserción de jefe
if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $requisito_historia = $_POST['requisito_historia'];
    
    $query = "INSERT INTO jefes (nombre, ubicacion, requisito_historia) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sss", $nombre, $ubicacion, $requisito_historia);
    $stmt->execute();
    $stmt->close();
}

// Manejo de eliminación de jefe
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $query = "DELETE FROM jefes WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de actualización de jefe
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $requisito_historia = $_POST['requisito_historia'];
    
    $query = "UPDATE jefes SET nombre = ?, ubicacion = ?, requisito_historia = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssi", $nombre, $ubicacion, $requisito_historia, $id);
    $stmt->execute();
    $stmt->close();
}

// Obtener lista de jefes
$resultado = $conexion->query("SELECT * FROM jefes");
$jefes = $resultado->fetch_all(MYSQLI_ASSOC);

// Obtener jefe a actualizar
$jefe_para_actualizar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $query = "SELECT * FROM jefes WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $jefe_para_actualizar = $resultado->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Jefes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function mostrarFormulario(id) {
            document.getElementById('form-insertar').style.display = 'block';  // Mostrar siempre el formulario de insertar
            document.getElementById('form-actualizar').style.display = 'none'; // Ocultar formulario de actualizar
        }

        function confirmarAccion(mensaje) {
            return confirm(mensaje);
        }
    </script>
</head>
<body class="container mt-4">
    <h2 class="text-center">Gestión de Jefes</h2>
    <form method="POST" class="text-end">
        <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
    </form>
    <br>
    <form method="POST" action="admin.php" class="text-end">
        <button type="submit" class="btn btn-secondary">Volver a Admin</button>
    </form>

    <button onclick="mostrarFormulario('form-insertar')" class="btn btn-primary mb-3">Insertar Jefe</button>
    
    <form id="form-insertar" action="" method="POST" style="display: none;" class="card p-3 mb-3">
        <input type="hidden" name="accion" value="insertar">
        <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Ubicación:</label><input type="text" name="ubicacion" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Requisito Historia:</label>
            <select name="requisito_historia" class="form-control" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>

    <?php if ($jefe_para_actualizar): ?>
        <form id="form-actualizar" action="" method="POST" class="card p-3 mb-3">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?php echo $jefe_para_actualizar['id']; ?>">
            <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre" class="form-control" value="<?php echo $jefe_para_actualizar['nombre']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Ubicación:</label><input type="text" name="ubicacion" class="form-control" value="<?php echo $jefe_para_actualizar['ubicacion']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Requisito Historia:</label>
                <select name="requisito_historia" class="form-control" required>
                    <option value="Sí" <?php echo $jefe_para_actualizar['requisito_historia'] == 'Sí' ? 'selected' : ''; ?>>Sí</option>
                    <option value="No" <?php echo $jefe_para_actualizar['requisito_historia'] == 'No' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <button type="submit" onclick="return confirmarAccion('¿Deseas actualizar este jefe?')" class="btn btn-warning">Actualizar</button>
        </form>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Ubicación</th><th>Requisito Historia</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($jefes as $jefe): ?>
                <tr>
                    <td><?php echo $jefe['id']; ?></td>
                    <td><?php echo $jefe['nombre']; ?></td>
                    <td><?php echo $jefe['ubicacion']; ?></td>
                    <td><?php echo $jefe['requisito_historia']; ?></td>
                    <td>
                        <a href="?editar=<?php echo $jefe['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $jefe['id']; ?>">
                            <button type="submit" onclick="return confirmarAccion('¿Seguro que deseas eliminar este jefe?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
