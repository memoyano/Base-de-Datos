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

  if (isset($_GET['codigo_v'])) {
    $codigo_v = $_GET['codigo_v'];

    $consultaSQL = "DELETE FROM vendedores WHERE codigo_v = :codigo_v";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':codigo_v', $codigo_v, PDO::PARAM_INT);
    $sentencia->execute();

    header('Location: index.php');
    exit;
  } else {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Código de vendedor no proporcionado';
  }
} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php if ($resultado['error']): ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require "templates/footer.php"; ?>