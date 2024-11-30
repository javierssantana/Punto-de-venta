<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] != 'administrativo') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $id = $_POST['id'];

    $conn = new mysqli('localhost', 'root', '', 'farmacia');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM inventario WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>Producto no encontrado.</div>";
    }

    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $conn = new mysqli('localhost', 'root', '', 'farmacia');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "UPDATE inventario SET nombre='$nombre', descripcion='$descripcion', cantidad=$cantidad, precio=$precio WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center mt-3'>Producto modificado exitosamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
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
            <h1 class="text-center">Modificar Producto</h1>
            <form method="post" action="modificar.php">
                <div class="form-group">
                    <label for="id">ID del Producto</label>
                    <input type="number" class="form-control" id="id" name="id" required>
                </div>
                <button type="submit" name="buscar" class="btn btn-primary btn-block btn-custom">Buscar</button>
            </form>
            <?php if (isset($producto)): ?>
            <form method="post" action="modificar.php">
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $producto['descripcion']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                </div>
                <button type="submit" name="modificar" class="btn btn-warning btn-block btn-custom">Modificar</button>
            </form>
            <?php endif; ?>
            <button class="btn btn-secondary btn-block btn-custom btn-home" onclick="location.href='index.php'">Home</button>
        </div>
    </div>
</body>
</html>

