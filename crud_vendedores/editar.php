<?php
include '../conexion.php';
$codigo = $_GET['codigo_v'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apellidos = $_POST['apellidos_v'];
    $nombres = $_POST['nombres_v'];
    $identificacion = $_POST['identificacion_v'];
    $parroquia = $_POST['parroquia_domicilio_v'];
    $sexo = $_POST['sexo_v'];
    $salario = $_POST['salario_v'];
    $edad = $_POST['edad_v'];

    $sql = "UPDATE vendedores SET 
        apellidos_v='$apellidos',
        nombres_v='$nombres',
        identificacion_v='$identificacion',
        parroquia_domicilio_v='$parroquia',
        sexo_v='$sexo',
        salario_v='$salario',
        edad_v='$edad'
        WHERE codigo_v=$codigo";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM vendedores WHERE codigo_v=$codigo";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<h2>Editar Vendedor</h2>
<form method="POST">
  Apellidos: <input type="text" name="apellidos_v" value="<?= $row['apellidos_v'] ?>" required><br><br>
  Nombres: <input type="text" name="nombres_v" value="<?= $row['nombres_v'] ?>" required><br><br>
  Identificación: <input type="text" name="identificacion_v" value="<?= $row['identificacion_v'] ?>" required><br><br>
  Parroquia: <input type="text" name="parroquia_domicilio_v" value="<?= $row['parroquia_domicilio_v'] ?>"><br><br>
  Sexo: <input type="text" name="sexo_v" value="<?= $row['sexo_v'] ?>"><br><br>
  Salario: <input type="number" step="0.01" name="salario_v" value="<?= $row['salario_v'] ?>"><br><br>
  Edad: <input type="number" name="edad_v" value="<?= $row['edad_v'] ?>"><br><br>
  <input type="submit" value="Actualizar">
</form>
<a href="index.php">Volver</a>
