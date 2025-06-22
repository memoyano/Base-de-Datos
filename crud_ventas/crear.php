<?php
include '../conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_vt = $_POST['codigo_vt'];
    $codigo_v = $_POST['codigo_v'];
    $codigo_p = $_POST['codigo_p'];
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];

    $res = $conn->query("SELECT valor_unitario_p FROM productos WHERE codigo_p = $codigo_p");
    $prod = $res->fetch_assoc();
    $total = $prod['valor_unitario_p'] * $cantidad;

    $sql = "INSERT INTO ventas (codigo_vt, codigo_v, codigo_p, fecha, cantidad, total) 
            VALUES ('$codigo_vt', '$codigo_v', '$codigo_p', '$fecha', '$cantidad', '$total')";
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
$vendedores = $conn->query("SELECT * FROM vendedores");
$productos = $conn->query("SELECT * FROM productos");
?>
<h2>Registrar Venta</h2>
<form method="POST">
  Código Venta: <input type="number" name="codigo_vt" required><br><br>
  Fecha: <input type="date" name="fecha" required><br><br>
  Cantidad: <input type="number" name="cantidad" required><br><br>

  Vendedor:
  <select name="codigo_v">
    <?php while ($v = $vendedores->fetch_assoc()): ?>
      <option value="<?= $v['codigo_v'] ?>"><?= $v['nombres_v'] ?></option>
    <?php endwhile; ?>
  </select><br><br>

  Producto:
  <select name="codigo_p">
    <?php while ($p = $productos->fetch_assoc()): ?>
      <option value="<?= $p['codigo_p'] ?>"><?= $p['descripcion_p'] ?></option>
    <?php endwhile; ?>
  </select><br><br>

  <input type="submit" value="Guardar Venta">
</form>
<a href="index.php">Volver</a>