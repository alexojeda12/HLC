<?php
session_start();

// Destruir las variables de sesión
session_destroy();

// Eliminar cookies si existen
if (isset($_COOKIE['nombre_usuario'])) {
    setcookie('nombre_usuario', '', time() - 3600, "/");
}
if (isset($_COOKIE['rol'])) {
    setcookie('rol', '', time() - 3600, "/");
}

// Redirigir al home
header("Location: index.php");
exit;
?>
