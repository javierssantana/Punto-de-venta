<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario de Farmacia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            border-radius: 20px;
            margin: 5px;
        }
        .btn-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">Gestión de Inventario de Farmacia</h1>
        <p class="text-center">Bienvenido, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['rol']; ?>)</p>
        <div class="btn-container mt-3">
            <?php if ($_SESSION['rol'] == 'administrativo'): ?>
                <button class="btn btn-primary btn-custom" onclick="location.href='agregar.php'">Agregar</button>
                <button class="btn btn-secondary btn-custom" onclick="location.href='buscar.php'">Buscar</button>
                <button class="btn btn-warning btn-custom" onclick="location.href='modificar.php'">Modificar</button>
                <button class="btn btn-danger btn-custom" onclick="location.href='eliminar.php'">Eliminar</button>
                <button class="btn btn-info btn-custom" onclick="location.href='stock.php'">Stock</button>
                <button class="btn btn-dark btn-custom" onclick="location.href='ventas.php'">Ventas</button>
            <?php endif; ?>
            <button class="btn btn-success btn-custom" onclick="location.href='venta.php'">Punto de Venta</button>
            <button class="btn btn-dark btn-custom" onclick="location.href='logout.php'">Cerrar Sesión</button>
        </div>
    </div>
</body>
</html>

