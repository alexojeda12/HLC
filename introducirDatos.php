<?php
// incluir conexión a la bbdd
include('conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Formulario de Registro</h4>
                    </div>
                    <div class="card-body">
                        <form action="introducir.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="edad" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad" required>
                            </div>
                            <div class="mb-3">
                                <label for="curso" class="form-label">Curso</label>
                                <select class="form-select" id="curso" name="curso" required>
                                    <option value="ASIR">ASIR2</option>
                                    <option value="DAW">DAW2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="promociona" class="form-label">Promociona</label>
                                <select class="form-select" id="promociona" name="promociona" required>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Insertar Alumno</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>