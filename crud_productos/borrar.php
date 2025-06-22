<?php
include '../conexion.php';
$codigo = $_GET['codigo_p'];
$sql = "DELETE FROM productos WHERE codigo_p=$codigo";
if ($conn->query($sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>