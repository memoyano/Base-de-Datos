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

if (!isset($_GET['codigo_v'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'Código de vendedor no especificado';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $vendedor = [
      "apellidos_m" => $_POST['apellidos_m'],
      "nombres_v" => $_POST['nombres_v'],
      "identificacion_m" => $_POST['identificacion_m'],
      "parroquia_domicilio_m" => $_POST['parroquia_domicilio_m'],
      "sexo_m" => $_POST['sexo_m'],
      "salario_m" => $_POST['salario_m'],
      "edad_m" => $_POST['edad_m'],
      "codigo_original" => $_GET['codigo_v']
    ];

    $consultaSQL = "UPDATE vendedores SET
        apellidos_m = :apellidos_m,
        nombres_v = :nombres_v,
        identificacion_m = :identificacion_m,
        parroquia_domicilio_m = :parroquia_domicilio_m,
        sexo_m = :sexo_m,
        salario_m = :salario_m,
        edad_m = :edad_m
      WHERE codigo_v = :codigo_original";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($vendedor);

    $resultado['mensaje'] = 'Vendedor actualizado con éxito';
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $codigo_v = $_GET['codigo_v'];
  $consultaSQL = "SELECT * FROM vendedores WHERE codigo_v = :codigo_v";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':codigo_v', $codigo_v, PDO::PARAM_INT);
  $sentencia->execute();

  $vendedor = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$vendedor) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se encontró el vendedor';
  }
} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php include 'templates/header.php'; ?>

<?php if ($resultado['mensaje']): ?>
  <div class="container mt-2">
    <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
      <?= $resultado['mensaje'] ?>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($vendedor) && $vendedor): ?>
  <div class="container">
    <h2 class="mt-4">Editar vendedor</h2>
    <hr>
    <form method="post">
      <div class="form-group">
        <label for="codigo_v">Código</label>
        <input type="number" name="codigo_v" id="codigo_v" value="<?= escapar($vendedor['codigo_v']) ?>" class="form-control" readonly>
      </div>
      <div class="form-group">
        <label for="apellidos_m">Apellido</label>
        <input type="text" name="apellidos_m" id="apellidos_m" value="<?= escapar($vendedor['apellidos_m']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="nombres_v">Nombre</label>
        <input type="text" name="nombres_v" id="nombres_v" value="<?= escapar($vendedor['nombres_v']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="identificacion_m">Identificación</label>
        <input type="text" name="identificacion_m" id="identificacion_m" value="<?= escapar($vendedor['identificacion_m']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="parroquia_domicilio_m">Parroquia</label>
        <input type="text" name="parroquia_domicilio_m" id="parroquia_domicilio_m" value="<?= escapar($vendedor['parroquia_domicilio_m']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="sexo_m">Sexo</label>
        <select name="sexo_m" id="sexo_m" class="form-control" required>
          <option value="">Seleccione...</option>
          <option value="Masculino" <?= $vendedor['sexo_m'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
          <option value="Femenino" <?= $vendedor['sexo_m'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
        </select>
      </div>
      <div class="form-group">
        <label for="salario_m">Salario</label>
        <input type="number" step="0.01" name="salario_m" id="salario_m" value="<?= escapar($vendedor['salario_m']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="edad_m">Edad</label>
        <input type="number" name="edad_m" id="edad_m" value="<?= escapar($vendedor['edad_m']) ?>" class="form-control" required>
      </div>
      <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
      <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
      <a class="btn btn-secondary" href="index.php">Volver</a>
    </form>
  </div>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>