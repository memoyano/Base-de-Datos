<?php
include "conexion.php";

$id = $_POST['id'];

$sql = "DELETE FROM vendedores WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "✅ Registro eliminado correctamente.";
} else {
    echo "❌ Error al eliminar: " . $conn->error;
}

$conn->close();
?>
