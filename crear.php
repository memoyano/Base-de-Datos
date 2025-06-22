<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El vendedor ' . escapar($_POST['nombres_v']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

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
    ];

    // Insert record
    $consultaSQL = "INSERT INTO vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m) 
      VALUES (:" . implode(", :", array_keys($vendedor)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($vendedor);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php
if (isset($resultado)) {
?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Agregar nuevo vendedor</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="apellidos_m">Apellido</label>
          <input type="text" name="apellidos_m" id="apellidos_m" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="nombres_v">Nombre</label>
          <input type="text" name="nombres_v" id="nombres_v" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="identificacion_m">Identificación</label>
          <input type="text" name="identificacion_m" id="identificacion_m" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="parroquia_domicilio_m">Parroquia</label>
          <input type="text" name="parroquia_domicilio_m" id="parroquia_domicilio_m" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="sexo_m">Sexo</label>
          <select name="sexo_m" id="sexo_m" class="form-control" required>
            <option value="">Seleccione...</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>
        </div>
        <div class="form-group">
          <label for="salario_m">Salario</label>
          <input type="number" step="0.01" name="salario_m" id="salario_m" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="edad_m">Edad</label>
          <input type="number" name="edad_m" id="edad_m" class="form-control" required>
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Guardar">
          <a class="btn btn-secondary" href="index.php">Lista de vendedores</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>