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

// Manejo de inserción de armadura
if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
    $nombre = $_POST['nombre_armadura'];
    $tipo = $_POST['tipo'];
    $defensa_fisica = $_POST['defensa_fisica'];
    $peso = $_POST['peso'];
    
    $query = "INSERT INTO armaduras (nombre, tipo, defensa_fisica, peso) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdd", $nombre, $tipo, $defensa_fisica, $peso);
    $stmt->execute();
    $stmt->close();
}

// Manejo de eliminación de armadura
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $query = "DELETE FROM armaduras WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de actualización de armadura
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre_armadura'];
    $tipo = $_POST['tipo'];
    $defensa_fisica = $_POST['defensa_fisica'];
    $peso = $_POST['peso'];
    
    $query = "UPDATE armaduras SET nombre = ?, tipo = ?, defensa_fisica = ?, peso = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssddi", $nombre, $tipo, $defensa_fisica, $peso, $id);
    $stmt->execute();
    $stmt->close();
}

// Obtener lista de armaduras
$resultado = $conexion->query("SELECT * FROM armaduras");
$armaduras = $resultado->fetch_all(MYSQLI_ASSOC);

// Obtener armadura a actualizar
$armadura_para_actualizar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $query = "SELECT * FROM armaduras WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $armadura_para_actualizar = $resultado->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Armaduras</title>
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
    <h2 class="text-center">Gestión de Armaduras</h2>
    <form method="POST" class="text-end">
        <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
    </form>
    <br>
    <form method="POST" action="admin.php" class="text-end">
    <button type="submit" class="btn btn-secondary">Volver a Admin</button>
</form>


    <button onclick="mostrarFormulario('form-insertar')" class="btn btn-primary mb-3">Insertar Armadura</button>
    
    <form id="form-insertar" action="" method="POST" style="display: none;" class="card p-3 mb-3">
        <input type="hidden" name="accion" value="insertar">
        <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_armadura" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Tipo:</label>
            <select name="tipo" class="form-control" required>
                <option value="Ligera">Ligera</option>
                <option value="Media">Media</option>
                <option value="Pesada">Pesada</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Defensa Física:</label><input type="number" step="0.01" name="defensa_fisica" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Peso:</label><input type="number" step="0.01" name="peso" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>

    <?php if ($armadura_para_actualizar): ?>
        <form id="form-actualizar" action="" method="POST" class="card p-3 mb-3">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?php echo $armadura_para_actualizar['id']; ?>">
            <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_armadura" class="form-control" value="<?php echo $armadura_para_actualizar['nombre']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="Ligera" <?php echo $armadura_para_actualizar['tipo'] == 'Ligera' ? 'selected' : ''; ?>>Ligera</option>
                    <option value="Media" <?php echo $armadura_para_actualizar['tipo'] == 'Media' ? 'selected' : ''; ?>>Media</option>
                    <option value="Pesada" <?php echo $armadura_para_actualizar['tipo'] == 'Pesada' ? 'selected' : ''; ?>>Pesada</option>
                </select>
            </div>
            <div class="mb-3"><label class="form-label">Defensa Física:</label><input type="number" step="0.01" name="defensa_fisica" class="form-control" value="<?php echo $armadura_para_actualizar['defensa_fisica']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Peso:</label><input type="number" step="0.01" name="peso" class="form-control" value="<?php echo $armadura_para_actualizar['peso']; ?>" required></div>
            <button type="submit" onclick="return confirmarAccion('¿Deseas actualizar esta armadura?')" class="btn btn-warning">Actualizar</button>
        </form>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Defensa Física</th><th>Peso</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($armaduras as $armadura): ?>
                <tr>
                    <td><?php echo $armadura['id']; ?></td>
                    <td><?php echo $armadura['nombre']; ?></td>
                    <td><?php echo $armadura['tipo']; ?></td>
                    <td><?php echo $armadura['defensa_fisica']; ?></td>
                    <td><?php echo $armadura['peso']; ?></td>
                    <td>
                        <a href="?editar=<?php echo $armadura['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $armadura['id']; ?>">
                            <button type="submit" onclick="return confirmarAccion('¿Seguro que deseas eliminar esta armadura?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
