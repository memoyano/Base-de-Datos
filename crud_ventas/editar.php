<?php
include '../conexion.php';

// Validar que se recibe el parámetro código_vt
if (!isset($_GET['codigo_vt'])) {
    die("Error: No se especificó el código de la venta.");
}

$codigo = $_GET['codigo_vt'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $codigo_v = $_POST['codigo_v'];
    $codigo_p = $_POST['codigo_p'];
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $valor_unitario = $_POST['valor_unitario'];
    $total = $cantidad * $valor_unitario;

    // Preparar y ejecutar consulta para actualizar
    $sql = "UPDATE ventas SET 
        codigo_v = ?,
        codigo_p = ?,
        fecha = ?,
        cantidad = ?,
        total = ?
        WHERE codigo_vt = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisidi", $codigo_v, $codigo_p, $fecha, $cantidad, $total, $codigo);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

} else {
    // Obtener datos de la venta a editar con prepared statement
    $sql = "SELECT * FROM ventas WHERE codigo_vt = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("No se encontró la venta con código $codigo");
    }

    // Obtener listas para selects
    $vendedores = $conn->query("SELECT codigo_v, nombres_v FROM vendedores");
    $productos = $conn->query("SELECT codigo_p, descripcion_p, valor_unitario_p FROM productos");
}
?>

<h2>Editar Venta</h2>

<form method="POST">
  <label>Vendedor:</label><br>
  <select name="codigo_v" required>
    <?php while ($v = $vendedores->fetch_assoc()) { ?>
      <option value="<?= $v['codigo_v'] ?>" <?= ($v['codigo_v'] == $row['codigo_v']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($v['nombres_v']) ?>
      </option>
    <?php } ?>
  </select><br><br>

  <label>Producto:</label><br>
  <select name="codigo_p" id="producto" onchange="actualizarValor()" required>
    <?php 
    $productos->data_seek(0);
    while ($p = $productos->fetch_assoc()) { 
      $selected = ($p['codigo_p'] == $row['codigo_p']) ? 'selected' : '';
    ?>
      <option value="<?= $p['codigo_p'] ?>" data-valor="<?= $p['valor_unitario_p'] ?>" <?= $selected ?>>
        <?= htmlspecialchars($p['descripcion_p']) ?>
      </option>
    <?php } ?>
  </select><br><br>

  <label>Fecha:</label><br>
  <input type="date" name="fecha" value="<?= $row['fecha'] ?>" required><br><br>

  <label>Cantidad:</label><br>
  <input type="number" name="cantidad" value="<?= $row['cantidad'] ?>" required><br><br>

  <label>Valor Unitario:</label><br>
  <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" value="<?= $row['total'] / $row['cantidad'] ?>" readonly><br><br>

  <input type="submit" value="Actualizar">
</form>

<a href="index.php">Volver</a>

<script>
function actualizarValor() {
    const producto = document.getElementById('producto');
    const selected = producto.options[producto.selectedIndex];
    document.getElementById('valor_unitario').value = selected.dataset.valor;
}
window.onload = actualizarValor;
</script>
