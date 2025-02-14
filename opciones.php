<?php
// Asegúrate de tener configurado Bootstrap en tu proyecto o agrega el siguiente link en la cabecera:
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Opciones de Lectura</h2>

        <!-- Card con las opciones -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Elige una opción</h5>
                <p class="card-text">Selecciona una opción para leer los datos o introducir nuevos.</p>
                
                <!-- Botón para leer todos los datos -->
                <a href="leertodo.php" class="btn btn-primary btn-lg btn-block mb-3">Leer Todos los Datos</a>
                
                <!-- Formulario para filtrar por nombre -->
                <form action="leerfiltro.php" method="get">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Filtrar por Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce el nombre" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Filtrar por Nombre</button>
                </form>

                    <!-- Formulario para filtrar por curso -->
                    <form action="leerfiltro2.php" method="get">
                    <div class="mb-3">
                        <label for="curso" class="form-label">Filtrar por Curso</label>
                        <input type="text" class="form-control" id="curso" name="curso" placeholder="Introduce el curso" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Filtrar por curso</button>
                </form>

                    <!-- Formulario para filtrar por promociona -->
                    <form action="leerfiltro3.php" method="get">
                    <div class="mb-3">
                        <label for="promociona" class="form-label">Filtrar por Promociona</label>
                        <select class="form-select" id="promociona" name="promociona" required>
                                <option value=1>Si</option>
                                <option value=0>No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Filtrar por curso</button>
                </form>
                
                
                <!-- Botón para introducir nuevos datos -->
                <a href="introducirDatos.php" class="btn btn-warning btn-lg btn-block mt-3">Introducir Nuevos Datos</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estudiantes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $curso = $_POST["curso"];
    $promociona = $_POST["promociona"];

    if ($edad < 16 || $edad > 99) {
        echo "Edad fuera de rango.";
    } else {
        $stmt = $conn->prepare("INSERT INTO alumnos (nombre, edad, curso, promociona) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $nombre, $edad, $curso, $promociona);
        
        if ($stmt->execute()) {
            echo "Registro insertado correctamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Introducir Datos del Alumno</h2>
        <div class="card">
            <div class="card-body">
                <form action="introducirDatos.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" min="16" max="99" required>
                    </div>
                    <div class="mb-3">
                        <label for="curso" class="form-label">Curso:</label>
                        <input type="text" class="form-control" id="curso" name="curso" required>
                    </div>
                    <div class="mb-3">
                        <label for="promociona" class="form-label">Promociona:</label>
                        <select class="form-control" id="promociona" name="promociona">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
