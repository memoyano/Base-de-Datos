<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Vendedores</title>
</head>
<body>
    <h2>Agregar Vendedor</h2>
    <form action="agregar.php" method="POST">
        Nombre: <input type="text" name="nombre"><br>
        Correo: <input type="email" name="correo"><br>
        Teléfono: <input type="text" name="telefono"><br>
        <input type="submit" value="Agregar">
    </form>

    <h2>Eliminar Vendedor</h2>
    <form action="eliminar.php" method="POST">
        ID del vendedor: <input type="number" name="id"><br>
        <input type="submit" value="Eliminar">
    </form>

    <hr>

    <h2>Lista de Vendedores</h2>

    <?php
    include "conexion.php";

    $sql = "SELECT * FROM vendedores";
    $resultado = $conn->query($sql);

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Teléfono</th></tr>";

    if ($resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["nombre"] . "</td>";
            echo "<td>" . $fila["correo"] . "</td>";
            echo "<td>" . $fila["telefono"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay registros</td></tr>";
    }

    echo "</table>";
    $conn->close();
    ?>
</body>
</html>
