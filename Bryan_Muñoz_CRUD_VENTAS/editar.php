<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El vendedor no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $vendedor = [
      "id"       => $_GET['id'],
      "nombre"   => $_POST['nombre'],
      "correo"   => $_POST['correo'],
      "telefono" => $_POST['telefono']
    ];

    $consultaSQL = "UPDATE vendedores SET
      nombre = :nombre,
      correo = :correo,
      telefono = :telefono
      WHERE id = :id";

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($vendedor);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM vendedores WHERE id = " . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $vendedor = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$vendedor) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el vendedor';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php if ($resultado['error']): ?>
  <div class="container mt-2">
    <div class="alert alert-danger" role="alert">
      <?= $resultado['mensaje'] ?>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($_POST['submit']) && !$resultado['error']): ?>
  <div class="container mt-2">
    <div class="alert alert-success" role="alert">
      El vendedor ha sido actualizado correctamente
    </div>
  </div>
<?php endif; ?>

<?php if (isset($vendedor) && $vendedor): ?>
  <div class="container">
    <h2 class="mt-4">Editando al vendedor <?= escapar($vendedor['nombre']) ?></h2>
    <hr>
    <form method="post">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?= escapar($vendedor['nombre']) ?>" class="form-control">
      </div>
      <div class="form-group">
        <label for="correo">Correo</label>
        <input type="email" name="correo" id="correo" value="<?= escapar($vendedor['correo']) ?>" class="form-control">
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="<?= escapar($vendedor['telefono']) ?>" class="form-control">
      </div>
      <input name="csrf" type="hidden" value="<?= escapar($_SESSION['csrf']) ?>">
      <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
      <a class="btn btn-secondary" href="index.php">Regresar al inicio</a>
    </form>
  </div>
<?php endif; ?>

<?php require "templates/footer.php"; ?>