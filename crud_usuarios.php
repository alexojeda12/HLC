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

// Manejo de inserción de usuario
if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];
    
    $query = "INSERT INTO usuarios (nombre_usuario, email, contraseña, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssss", $nombre, $email, $contrasena, $rol);
    $stmt->execute();
    $stmt->close();
}

// Manejo de eliminación de usuario
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $id = $_POST['id'];
    $query = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de actualización de usuario
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    
    $query = "UPDATE usuarios SET nombre_usuario = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
    $stmt->execute();
    $stmt->close();
}

// Obtener lista de usuarios
$resultado = $conexion->query("SELECT * FROM usuarios");
$usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

// Obtener usuario a actualizar
$usuario_para_actualizar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $query = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario_para_actualizar = $resultado->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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
    <h2 class="text-center">Gestión de Usuarios</h2>
    <form method="POST" class="text-end">
        <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
    </form>

    <br>
    <form method="POST" action="admin.php" class="text-end">
    <button type="submit" class="btn btn-secondary">Volver a Admin</button>
</form>
    
    <button onclick="mostrarFormulario('form-insertar')" class="btn btn-primary mb-3">Insertar Usuario</button>
    
    <form id="form-insertar" action="" method="POST" style="display: none;" class="card p-3 mb-3">
        <input type="hidden" name="accion" value="insertar">
        <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_usuario" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email:</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Contraseña:</label><input type="password" name="contrasena" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Rol:</label>
            <select name="rol" class="form-select">
                <option value="usuario">Usuario</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>

    <?php if ($usuario_para_actualizar): ?>
        <form id="form-actualizar" action="" method="POST" class="card p-3 mb-3">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?php echo $usuario_para_actualizar['id']; ?>">
            <div class="mb-3"><label class="form-label">Nombre:</label><input type="text" name="nombre_usuario" class="form-control" value="<?php echo $usuario_para_actualizar['nombre_usuario']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Email:</label><input type="email" name="email" class="form-control" value="<?php echo $usuario_para_actualizar['email']; ?>" required></div>
            <div class="mb-3"><label class="form-label">Rol:</label>
                <select name="rol" class="form-select">
                    <option value="usuario" <?php echo ($usuario_para_actualizar['rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="admin" <?php echo ($usuario_para_actualizar['rol'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" onclick="return confirmarAccion('¿Deseas actualizar este usuario?')" class="btn btn-warning">Actualizar</button>
        </form>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre_usuario']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['rol']; ?></td>
                    <td>
                        <a href="?editar=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="submit" onclick="return confirmarAccion('¿Seguro que deseas eliminar este usuario?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
