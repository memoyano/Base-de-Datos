<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El vendedor ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $vendedor = [
      "nombre"   => $_POST['nombre'],
      "correo"   => $_POST['correo'],
      "telefono" => $_POST['telefono'],
    ];

    $consultaSQL = "INSERT INTO vendedores (nombre, correo, telefono)";
    $consultaSQL .= " VALUES (:" . implode(", :", array_keys($vendedor)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($vendedor);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php if (isset($resultado)): ?>
  <div class="container mt-3">
    <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
      <?= $resultado['mensaje'] ?>
    </div>
  </div>
<?php endif; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Agregar nuevo vendedor</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="correo">Correo</label>
          <input type="email" name="correo" id="correo" class="form-control">
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" name="telefono" id="telefono" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <input type="submit" name="submit" class="btn btn-primary" value="Guardar">
        <a class="btn btn-secondary" href="index.php">Lista de vendedores</a>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>