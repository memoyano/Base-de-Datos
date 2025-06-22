<?php
include 'funciones.php';

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id = $_GET['id'];
  $consultaSQL = "DELETE FROM vendedores WHERE id = :id";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
  $sentencia->execute();

  header('Location: index.php');
  exit;

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

<?php require "templates/footer.php"; ?>