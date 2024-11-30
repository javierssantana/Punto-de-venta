<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    $conn = new mysqli('localhost', 'root', '', 'farmacia');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM inventario WHERE id=$producto_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        $producto['cantidad'] = $cantidad;
        $_SESSION['carrito'][] = $producto;
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>Producto no encontrado.</div>";
    }

    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar'])) {
    $conn = new mysqli('localhost', 'root', '', 'farmacia');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    foreach ($_SESSION['carrito'] as $producto) {
        $producto_id = $producto['id'];
        $cantidad = $producto['cantidad'];
        $total = $producto['precio'] * $cantidad;

        $sql = "INSERT INTO ventas (producto_id, cantidad, total) VALUES ($producto_id, $cantidad, $total)";
        if ($conn->query($sql) !== TRUE) {
            echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }

    $_SESSION['carrito'] = [];
    echo "<div class='alert alert-success text-center mt-3'>Venta registrada exitosamente</div>";

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta</title>
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
            <h1 class="text-center">Punto de Venta</h1>
            <form method="post" action="venta.php">
                <div class="form-group">
                    <label for="producto_id">ID del Producto</label>
                    <input type="number" class="form-control" id="producto_id" name="producto_id" required>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                </div>
                <button type="submit" name="agregar" class="btn btn-primary btn-block btn-custom">Agregar al Carrito</button>
            </form>
            <h2 class="text-center mt-5">Carrito de Compras</h2>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_general = 0;
                    foreach ($_SESSION['carrito'] as $producto) {
                        $total = $producto['precio'] * $producto['cantidad'];
                        $total_general += $total;
                        echo "<tr>
                                <td>{$producto['id']}</td>
                                <td>{$producto['nombre']}</td>
                                <td>{$producto['cantidad']}</td>
                                <td>{$producto['precio']}</td>
                                <td>$total</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h3 class="text-center">Total General: <?php echo $total_general; ?></h3>
            <form method="post" action="venta.php">
                <button type="submit" name="finalizar" class="btn btn-success btn-block btn-custom">Finalizar Venta</button>
            </form>
            <button class="btn btn-secondary btn-block btn-custom btn-home" onclick="location.href='index.php'">Home</button>
        </div>
    </div>
</body>
</html>


