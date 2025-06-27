<?php
include "conexion.php";

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

$sql = "INSERT INTO vendedores (nombre, correo, telefono) VALUES ('$nombre', '$correo', '$telefono')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Registro agregado correctamente.";
} else {
    echo "❌ Error al agregar: " . $conn->error;
}

$conn->close();
?>
