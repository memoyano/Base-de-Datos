<?php
include '../conexion.php';
$sql = "SELECT * FROM vendedores";
$result = $conn->query($sql);
?>

<h2>Listado de Vendedores</h2>
<a href="crear.php">Agregar nuevo vendedor</a><br><br>
<table border="1" cellpadding="10">
  <tr>
    <th>Código</th><th>Apellidos</th><th>Nombres</th><th>Identificación</th>
    <th>Parroquia</th><th>Sexo</th><th>Salario</th><th>Edad</th><th>Acciones</th>
  </tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= $row['codigo_v'] ?></td>
  <td><?= $row['apellidos_v'] ?></td>
  <td><?= $row['nombres_v'] ?></td>
  <td><?= $row['identificacion_v'] ?></td>
  <td><?= $row['parroquia_domicilio_v'] ?></td>
  <td><?= $row['sexo_v'] ?></td>
  <td><?= $row['salario_v'] ?></td>
  <td><?= $row['edad_v'] ?></td>
  <td>
    <a href="editar.php?codigo_v=<?= $row['codigo_v'] ?>">Editar</a> |
    <a href="borrar.php?codigo_v=<?= $row['codigo_v'] ?>" onclick="return confirm('¿Estás seguro?')">Borrar</a>
  </td>
</tr>
<?php endwhile; ?>
</table>
