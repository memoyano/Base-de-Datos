<?php
include '../conexion.php';
$sql = "SELECT vt.codigo_vt, vt.fecha, vt.cantidad, vt.total,
               v.nombres_v, p.descripcion_p
        FROM ventas vt
        JOIN vendedores v ON vt.codigo_v = v.codigo_v
        JOIN productos p ON vt.codigo_p = p.codigo_p";
$result = $conn->query($sql);
?>

<h2>Lista de Ventas</h2>
<a href="crear.php">Registrar venta</a><br><br>
<table border="1">
<tr>
  <th>Código</th><th>Fecha</th><th>Vendedor</th><th>Producto</th>
  <th>Cantidad</th><th>Total</th><th>Acciones</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['codigo_vt'] ?></td>
  <td><?= $row['fecha'] ?></td>
  <td><?= $row['nombres_v'] ?></td>
  <td><?= $row['descripcion_p'] ?></td>
  <td><?= $row['cantidad'] ?></td>
  <td><?= $row['total'] ?></td>
  <td>
    <a href="editar.php?codigo_vt=<?= $row['codigo_vt'] ?>">Editar</a> |
    <a href="borrar.php?codigo_vt=<?= $row['codigo_vt'] ?>" onclick="return confirm('Eliminar?')">Borrar</a></td>
</tr>
<?php endwhile; ?>
</table>
