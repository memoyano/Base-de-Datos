<?php
include '../conexion.php';
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<h2>Lista de Productos</h2>
<a href="crear.php">Agregar producto</a><br><br>
<table border="1">
<tr>
  <th>Código</th><th>Tipo</th><th>Descripción</th><th>Valor</th><th>Acciones</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['codigo_p'] ?></td>
  <td><?= $row['tipo_producto_p'] ?></td>
  <td><?= $row['descripcion_p'] ?></td>
  <td><?= $row['valor_unitario_p'] ?></td>
  <td>
    <a href="editar.php?codigo_p=<?= $row['codigo_p'] ?>">Editar</a> |
    <a href="borrar.php?codigo_p=<?= $row['codigo_p'] ?>" onclick="return confirm('Eliminar?')">Borrar</a>
  </td>
</tr>
<?php endwhile; ?>
</table>