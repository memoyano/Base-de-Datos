<?php
include '../conexion.php';
$codigo = $_GET['codigo_vt'];
$sql = "DELETE FROM ventas WHERE codigo_vt=$codigo";
if ($conn->query($sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>