<?php
include '../conexion.php';
$codigo = $_GET['codigo_v'];

$sql = "DELETE FROM vendedores WHERE codigo_v=$codigo";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>
