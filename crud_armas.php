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

// Manejo de inserción de arma
if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
    $nombre = $_POST['nombre_arma'];
    $tipo = $_POST['tipo'];
    $daño_base = $_POST['daño_base'];
    $escalado = $_POST['escalado'];
    
    $query = "INSERT INTO armas (nombre, tipo, daño_base, escalado) VALUES ('$nombre', '$tipo', '$daño_base', '$escalado')";
    mysqli_query($conexion, $query);
}

// Manejo de eliminación de arma
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $query = "DELETE FROM armas WHERE id = $id";
    mysqli_query($conexion, $query);
}

// Manejo de actualización de arma
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre_arma'];
    $tipo = $_POST['tipo'];
    $daño_base = $_POST['daño_base'];
    $escalado = $_POST['escalado'];
    
    $query = "UPDATE armas SET nombre = '$nombre', tipo = '$tipo', daño_base = '$daño_base', escalado = '$escalado' WHERE id = $id";
    mysqli_query($conexion, $query);
}

// Obtener lista de armas
$resultado = mysqli_query($conexion, "SELECT * FROM armas");
$armas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Obtener arma a actualizar
$arma_para_actualizar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $query = "SELECT * FROM armas WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);
    $arma_para_actualizar = mysqli_fetch_assoc($resultado);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Armas</title>
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
    <h2 class="text-center">Gestión de Armas</h2>
    <form method="POST" class="text-end">
        <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
    </form>

    <br>
    
    <form method="POST" action="admin.php" class="text-end">
    <button type="submit" class="btn btn-secondary">Volver a Admin</button>
</form>
    
    <button onclick="mostrarFormulario('form-insertar')" class="btn btn-primary mb-3">Insertar Arma</button>
    
    <form id="form-insertar" action="" method="POST" style="display: none;" class="card p-3 mb-3">
        <input type="hidden" name="accion" value="insertar">
        <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_arma" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Tipo:</label>
            <select name="tipo" class="form-control" required>
                <option value="Espada">Espada</option>
                <option value="Lanza">Lanza</option>
                <option value="Hacha">Hacha</option>
                <option value="Daga">Daga</option>
                <option value="Arco">Arco</option>
                <option value="Catalizador">Catalizador</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Daño Base:</label><input type="number" step="0.01" name="daño_base" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Escalado:</label><input type="text" name="escalado" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>

    <?php if ($arma_para_actualizar): ?>
        <form id="form-actualizar" action="" method="POST" class="card p-3 mb-3">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?php echo $arma_para_actualizar['id']; ?>">
            <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_arma" class="form-control" value="<?php echo $arma_para_actualizar['nombre']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="Espada" <?php echo $arma_para_actualizar['tipo'] == 'Espada' ? 'selected' : ''; ?>>Espada</option>
                    <option value="Lanza" <?php echo $arma_para_actualizar['tipo'] == 'Lanza' ? 'selected' : ''; ?>>Lanza</option>
                    <option value="Hacha" <?php echo $arma_para_actualizar['tipo'] == 'Hacha' ? 'selected' : ''; ?>>Hacha</option>
                    <option value="Daga" <?php echo $arma_para_actualizar['tipo'] == 'Daga' ? 'selected' : ''; ?>>Daga</option>
                    <option value="Arco" <?php echo $arma_para_actualizar['tipo'] == 'Arco' ? 'selected' : ''; ?>>Arco</option>
                    <option value="Catalizador" <?php echo $arma_para_actualizar['tipo'] == 'Catalizador' ? 'selected' : ''; ?>>Catalizador</option>
                </select>
            </div>
            <div class="mb-3"><label class="form-label">Daño Base:</label><input type="number" step="0.01" name="daño_base" class="form-control" value="<?php echo $arma_para_actualizar['daño_base']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Escalado:</label><input type="text" name="escalado" class="form-control" value="<?php echo $arma_para_actualizar['escalado']; ?>" required></div>
            <button type="submit" onclick="return confirmarAccion('¿Deseas actualizar esta arma?')" class="btn btn-warning">Actualizar</button>
        </form>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Daño Base</th><th>Escalado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($armas as $arma): ?>
                <tr>
                    <td><?php echo $arma['id']; ?></td>
                    <td><?php echo $arma['nombre']; ?></td>
                    <td><?php echo $arma['tipo']; ?></td>
                    <td><?php echo $arma['daño_base']; ?></td>
                    <td><?php echo $arma['escalado']; ?></td>
                    <td>
                        <a href="?editar=<?php echo $arma['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $arma['id']; ?>">
                            <button type="submit" onclick="return confirmarAccion('¿Seguro que deseas eliminar esta arma?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
