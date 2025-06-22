<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';
$vendedores = [];

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Búsqueda por apellido
  if (isset($_POST['apellidos_m']) && $_POST['apellidos_m'] !== '') {
    $consultaSQL = "SELECT * FROM vendedores WHERE apellidos_m LIKE :apellido ORDER BY apellidos_m";
    $sentencia = $conexion->prepare($consultaSQL);
    $param = "%" . $_POST['apellidos_m'] . "%";
    $sentencia->bindParam(':apellido', $param, PDO::PARAM_STR);
    $sentencia->execute();
  } else {
    $consultaSQL = "SELECT * FROM vendedores ORDER BY apellidos_m";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  }

  $vendedores = $sentencia->fetchAll();
} catch (PDOException $error) {
  $error = $error->getMessage();
}

$titulo = isset($_POST['apellidos_m']) && $_POST['apellidos_m'] !== '' ? 'Lista de vendedores (' . escapar($_POST['apellidos_m']) . ')' : 'Lista de vendedores';
?>

<?php include "templates/header.php"; ?>

<?php if ($error): ?>
  <div class="container mt-2">
    <div class="alert alert-danger" role="alert">
      <?= $error ?>
    </div>
  </div>
<?php endif; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crear.php" class="btn btn-primary mt-4">Nuevo vendedor</a>
      <hr>
      <form method="post" class="form-inline mb-3">
        <input type="text" name="apellidos_m" placeholder="Buscar por apellido" class="form-control mr-2" value="<?= isset($_POST['apellidos_m']) ? escapar($_POST['apellidos_m']) : '' ?>">
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Buscar</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <h2><?= $titulo ?></h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Identificación</th>
        <th>Parroquia</th>
        <th>Sexo</th>
        <th>Salario</th>
        <th>Edad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($vendedores && count($vendedores) > 0): ?>
        <?php foreach ($vendedores as $fila): ?>
          <tr>
            <td><?= escapar($fila["codigo_v"]) ?></td>
            <td><?= escapar($fila["nombres_v"]) ?></td>
            <td><?= escapar($fila["apellidos_m"]) ?></td>
            <td><?= escapar($fila["identificacion_m"]) ?></td>
            <td><?= escapar($fila["parroquia_domicilio_m"]) ?></td>
            <td><?= escapar($fila["sexo_m"]) ?></td>
            <td><?= number_format($fila["salario_m"], 2) ?></td>
            <td><?= escapar($fila["edad_m"]) ?></td>
            <td>
              <a href="borrar.php?codigo_v=<?= escapar($fila["codigo_v"]) ?>" onclick="return confirm('¿Seguro que quieres eliminar este vendedor?')">🗑️Eliminar</a> |
              <a href="editar.php?codigo_v=<?= escapar($fila["codigo_v"]) ?>">✏️Editar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="9">No hay vendedores registrados.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include "templates/footer.php"; ?>