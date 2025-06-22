<?php
include 'conexion.php';

// Consultas
$vendedores = $conn->query("SELECT * FROM vendedores");
$productos = $conn->query("SELECT * FROM productos");
$ventas = $conn->query("
    SELECT vt.codigo_vt, vt.fecha, vt.cantidad, vt.total,
           v.nombres_v, p.descripcion_p
    FROM ventas vt
    JOIN vendedores v ON vt.codigo_v = v.codigo_v
    JOIN productos p ON vt.codigo_p = p.codigo_p
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard de Ventas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <h1 class="mb-4">Panel de Control - Sistema de Ventas</h1>

  <!-- Sección Vendedores -->
  <div class="card mb-5">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Vendedores</h4>
      <a href="crud_vendedores/crear.php" class="btn btn-light btn-sm">Nuevo Vendedor</a>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Código</th><th>Apellidos</th><th>Nombres</th><th>Identificación</th>
            <th>Parroquia</th><th>Sexo</th><th>Salario</th><th>Edad</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while($v = $vendedores->fetch_assoc()): ?>
          <tr>
            <td><?= $v['codigo_v'] ?></td>
            <td><?= $v['apellidos_v'] ?></td>
            <td><?= $v['nombres_v'] ?></td>
            <td><?= $v['identificacion_v'] ?></td>
            <td><?= $v['parroquia_domicilio_v'] ?></td>
            <td><?= $v['sexo_v'] ?></td>
            <td>$<?= $v['salario_v'] ?></td>
            <td><?= $v['edad_v'] ?></td>
            <td>
              <a href="crud_vendedores/editar.php?codigo_v=<?= $v['codigo_v'] ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="crud_vendedores/borrar.php?codigo_v=<?= $v['codigo_v'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar vendedor?')">Borrar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Sección Productos -->
  <div class="card mb-5">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Productos</h4>
      <a href="crud_productos/crear.php" class="btn btn-light btn-sm">Nuevo Producto</a>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Código</th><th>Tipo</th><th>Descripción</th><th>Valor Unitario</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = $productos->fetch_assoc()): ?>
          <tr>
            <td><?= $p['codigo_p'] ?></td>
            <td><?= $p['tipo_producto_p'] ?></td>
            <td><?= $p['descripcion_p'] ?></td>
            <td>$<?= $p['valor_unitario_p'] ?></td>
            <td>
              <a href="crud_productos/editar.php?codigo_p=<?= $p['codigo_p'] ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="crud_productos/borrar.php?codigo_p=<?= $p['codigo_p'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">Borrar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Sección Ventas -->
  <div class="card mb-5">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Ventas</h4>
      <a href="crud_ventas/crear.php" class="btn btn-light btn-sm">Registrar Venta</a>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Código</th><th>Fecha</th><th>Vendedor</th><th>Producto</th><th>Cantidad</th><th>Total</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while($vt = $ventas->fetch_assoc()): ?>
          <tr>
            <td><?= $vt['codigo_vt'] ?></td>
            <td><?= $vt['fecha'] ?></td>
            <td><?= $vt['nombres_v'] ?></td>
            <td><?= $vt['descripcion_p'] ?></td>
            <td><?= $vt['cantidad'] ?></td>
            <td>$<?= $vt['total'] ?></td>
            <td>
              <a href="crud_ventas/editar.php?codigo_vt=<?= $vt['codigo_vt'] ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="crud_ventas/borrar.php?codigo_vt=<?= $vt['codigo_vt'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar venta?')">Borrar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

</body>
</html>
