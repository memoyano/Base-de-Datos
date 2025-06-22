<?php
include '../conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo_p'];
    $tipo = $_POST['tipo_producto_p'];
    $descripcion = $_POST['descripcion_p'];
    $valor = $_POST['valor_unitario_p'];

    $sql = "INSERT INTO productos (codigo_p, tipo_producto_p, descripcion_p, valor_unitario_p) VALUES ('$codigo', '$tipo', '$descripcion', '$valor')";
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<h2>Agregar Producto</h2>
<form method="POST">
  Código: <input type="number" name="codigo_p" required><br><br>
  Tipo: <input type="text" name="tipo_producto_p" required><br><br>
  Descripción: <input type="text" name="descripcion_p" required><br><br>
  Valor unitario: <input type="number" step="0.01" name="valor_unitario_p" required><br><br>
  <input type="submit" value="Guardar">
</form>
<a href="index.php">Volver</a>