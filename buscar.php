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
    <title>Buscar Producto</title>
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
            <h1 class="text-center">Buscar Producto</h1>
            <form method="post" action="buscar.php">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-custom">Buscar</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nombre = $_POST['nombre'];

                $conn = new mysqli('localhost', 'root', '', 'farmacia');
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM inventario WHERE nombre LIKE '%$nombre%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table class='table mt-3'><thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Precio</th></tr></thead><tbody>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nombre"]. "</td><td>" . $row["descripcion"]. "</td><td>" . $row["cantidad"]. "</td><td>" . $row["precio"]. "</td></tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning text-center mt-3'>No se encontraron productos.</div>";
                }

                $conn->close();
            }
            ?>
            <button class="btn btn-secondary btn-block btn-custom btn-home" onclick="location.href='index.php'">Home</button>
        </div>
    </div>
</body>
</html>
