<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo_v'];
    $apellidos = $_POST['apellidos_v'];
    $nombres = $_POST['nombres_v'];
    $identificacion = $_POST['identificacion_v'];
    $parroquia = $_POST['parroquia_domicilio_v'];
    $sexo = $_POST['sexo_v'];
    $salario = $_POST['salario_v'];
    $edad = $_POST['edad_v'];

    $sql = "INSERT INTO vendedores (codigo_v, apellidos_v, nombres_v, identificacion_v, parroquia_domicilio_v, sexo_v, salario_v, edad_v)
            VALUES ('$codigo', '$apellidos', '$nombres', '$identificacion', '$parroquia', '$sexo', '$salario', '$edad')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Agregar Vendedor</h2>
<form method="POST">
  Código: <input type="number" name="codigo_v" required><br><br>
  Apellidos: <input type="text" name="apellidos_v" required><br><br>
  Nombres: <input type="text" name="nombres_v" required><br><br>
  Identificación: <input type="text" name="identificacion_v" required><br><br>
  Parroquia: <input type="text" name="parroquia_domicilio_v"><br><br>
  Sexo: <input type="text" name="sexo_v"><br><br>
  Salario: <input type="number" step="0.01" name="salario_v"><br><br>
  Edad: <input type="number" name="edad_v"><br><br>
  <input type="submit" value="Guardar">
</form>
<a href="index.php">Volver</a>
