<?php
// Incluir el archivo de conexión
include('conexion.php'); // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio o ajusta la ruta

// Obtener el nombre desde la URL (si existe)
$curso = isset($_GET['curso']) ? $_GET['curso'] : '';

// Consulta para filtrar los datos de la tabla "alumnos" por nombre
$query = "SELECT id, nombre, edad, curso FROM alumnos WHERE nombre LIKE ?";
$stmt = mysqli_prepare($conexion, $query);

// Para realizar la búsqueda parcial, agregamos el comodín "%" al inicio y al final del nombre
$searchTerm = "%" . $curso . "%";
mysqli_stmt_bind_param($stmt, "s", $searchTerm);

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Obtener el resultado
$resultado = mysqli_stmt_get_result($stmt);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Resultados Filtrados por Nombre</h2>
        
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['edad']; ?></td>
                            <td><?php echo $row['curso']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($nombre); ?>"</p>
        <?php endif; ?>

        <a href="opciones.php" class="btn btn-secondary">Volver a las Opciones</a>
    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
