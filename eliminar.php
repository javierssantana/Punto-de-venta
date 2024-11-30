<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $conn = new mysqli('localhost', 'root', '', 'farmacia');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Eliminar las ventas asociadas al producto
    $sql = "DELETE FROM ventas WHERE producto_id=$id";
    if ($conn->query($sql) !== TRUE) {
        echo "<div class='alert alert-danger text-center mt-3'>Error al eliminar ventas: " . $conn->error . "</div>";
    }

    // Eliminar el producto del inventario
    $sql = "DELETE FROM inventario WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center mt-3'>Producto eliminado exitosamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Error al eliminar producto: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            border-radius: 20px;
        }
        .btn-home {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mt-5">
            <h1 class="text-center">Eliminar Producto</h1>
            <form method="post" action="eliminar.php">
                <div class="form-group">
                    <label for="id">ID del Producto</label>
                    <input type="number" class="form-control" id="id" name="id" required>
                </div>
                <button type="submit" class="btn btn-danger btn-block btn-custom">Eliminar</button>
            </form>
            <button class="btn btn-secondary btn-block btn-custom btn-home" onclick="location.href='index.php'">Home</button>
        </div>
    </div>
</body>
</html>
