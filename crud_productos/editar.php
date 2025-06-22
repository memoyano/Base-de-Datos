<?php
include '../conexion.php';
$codigo = $_GET['codigo_p'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo_producto_p'];
    $descripcion = $_POST['descripcion_p'];
    $valor = $_POST['valor_unitario_p'];

    $sql = "UPDATE productos SET tipo_producto_p='$tipo', descripcion_p='$descripcion', valor_unitario_p='$valor' WHERE codigo_p=$codigo";
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $res = $conn->query("SELECT * FROM productos WHERE codigo_p=$codigo");
    $row = $res->fetch_assoc();
}
?>
<h2>Editar Producto</h2>
<form method="POST">
  Tipo: <input type="text" name="tipo_producto_p" value="<?= $row['tipo_producto_p'] ?>" required><br><br>
  Descripción: <input type="text" name="descripcion_p" value="<?= $row['descripcion_p'] ?>" required><br><br>
  Valor unitario: <input type="number" step="0.01" name="valor_unitario_p" value="<?= $row['valor_unitario_p'] ?>" required><br><br>
  <input type="submit" value="Actualizar">
</form>
<a href="index.php">Volver</a>