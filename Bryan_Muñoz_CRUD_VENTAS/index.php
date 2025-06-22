<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';
$vendedores = '';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Listar registros
  $consultaSQL = "SELECT * FROM vendedores ORDER BY nombre";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $vendedores = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error = $error->getMessage();
}

$titulo = 'Lista de vendedores';
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
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($vendedores && $sentencia->rowCount() > 0): ?>
            <?php foreach ($vendedores as $fila): ?>
              <tr>
                <td><?= escapar($fila["id"]) ?></td>
                <td><?= escapar($fila["nombre"]) ?></td>
                <td><?= escapar($fila["correo"]) ?></td>
                <td><?= escapar($fila["telefono"]) ?></td>
                <td>
                  <a href="borrar.php?id=<?= escapar($fila["id"]) ?>">🗑️Eliminar</a>
                  <a href="editar.php?id=<?= escapar($fila["id"]) ?>">✏️Editar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>