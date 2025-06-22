<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "ventas";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Función para ejecutar consultas y mostrar errores
function runQuery($conn, $sql) {
    try {
        $conn->query($sql);
    } catch (Exception $e) {
        die("Error en consulta SQL: " . $e->getMessage());
    }
}

// Cargar datos a editar si se recibe edit + table en GET
$editData = null;
$editTable = null;
if (isset($_GET['edit']) && isset($_GET['table'])) {
    $editId = intval($_GET['edit']);
    $editTable = $_GET['table'];

    if ($editTable === 'VENDEDORES') {
        $result = $conn->query("SELECT * FROM VENDEDORES WHERE Codigo_v = $editId");
        $editData = $result->fetch_assoc();
    } elseif ($editTable === 'PRODUCTOS') {
        $result = $conn->query("SELECT * FROM PRODUCTOS WHERE Codigo_p = $editId");
        $editData = $result->fetch_assoc();
    } elseif ($editTable === 'VENTAS') {
        $result = $conn->query("SELECT * FROM VENTAS WHERE Codigo_vt = $editId");
        $editData = $result->fetch_assoc();
    }
}

// Procesar acciones POST (crear o editar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($table === 'VENDEDORES') {
        $codigo = intval($_POST['Codigo_v']);
        $apellidos = $conn->real_escape_string($_POST['Apellidos_v']);
        $nombres = $conn->real_escape_string($_POST['Nombres_v']);
        $ident = $conn->real_escape_string($_POST['Identificacion_v']);
        $parroquia = $conn->real_escape_string($_POST['Parroquia_domicilio_v']);
        $sexo = $conn->real_escape_string($_POST['Sexo_v']);
        $salario = floatval($_POST['Salario_v']);
        $edad = intval($_POST['Edad_v']);

        if ($action === 'create') {
            $sql = "INSERT INTO VENDEDORES (Codigo_v, Apellidos_v, Nombres_v, Identificacion_v, Parroquia_domicilio_v, Sexo_v, Salario_v, Edad_v) 
                    VALUES ($codigo, '$apellidos', '$nombres', '$ident', '$parroquia', '$sexo', $salario, $edad)";
        } elseif ($action === 'edit') {
            $sql = "UPDATE VENDEDORES SET Apellidos_v='$apellidos', Nombres_v='$nombres', Identificacion_v='$ident', 
                    Parroquia_domicilio_v='$parroquia', Sexo_v='$sexo', Salario_v=$salario, Edad_v=$edad WHERE Codigo_v=$codigo";
        }
        runQuery($conn, $sql);

    } elseif ($table === 'PRODUCTOS') {
        $codigo = intval($_POST['Codigo_p']);
        $tipo = $conn->real_escape_string($_POST['Tipo_producto_p']);
        $descripcion = $conn->real_escape_string($_POST['Descripcion_p']);
        $valor = floatval($_POST['Valor_unitario_p']);

        if ($action === 'create') {
            $sql = "INSERT INTO PRODUCTOS (Codigo_p, Tipo_producto_p, Descripcion_p, Valor_unitario_p) 
                    VALUES ($codigo, '$tipo', '$descripcion', $valor)";
        } elseif ($action === 'edit') {
            $sql = "UPDATE PRODUCTOS SET Tipo_producto_p='$tipo', Descripcion_p='$descripcion', 
                    Valor_unitario_p=$valor WHERE Codigo_p=$codigo";
        }
        runQuery($conn, $sql);

    } elseif ($table === 'VENTAS') {
        $codigo = intval($_POST['Codigo_vt']);
        $cod_v = intval($_POST['Codigo_v']);
        $cod_p = intval($_POST['Codigo_p']);
        $fecha = $conn->real_escape_string($_POST['Fecha']);
        $cantidad = intval($_POST['Cantidad']);
        $total = floatval($_POST['Total']);

        if ($action === 'create') {
            $sql = "INSERT INTO VENTAS (Codigo_vt, Codigo_v, Codigo_p, Fecha, Cantidad, Total) 
                    VALUES ($codigo, $cod_v, $cod_p, '$fecha', $cantidad, $total)";
        } elseif ($action === 'edit') {
            $sql = "UPDATE VENTAS SET Codigo_v=$cod_v, Codigo_p=$cod_p, Fecha='$fecha', 
                    Cantidad=$cantidad, Total=$total WHERE Codigo_vt=$codigo";
        }
        runQuery($conn, $sql);
    }

    header("Location: index.php");
    exit;
}

// Procesar eliminación
if (isset($_GET['delete']) && isset($_GET['table'])) {
    $id = intval($_GET['delete']);
    $table = $_GET['table'];

    if ($table === 'VENDEDORES') {
        runQuery($conn, "DELETE FROM VENDEDORES WHERE Codigo_v=$id");
    } elseif ($table === 'PRODUCTOS') {
        runQuery($conn, "DELETE FROM PRODUCTOS WHERE Codigo_p=$id");
    } elseif ($table === 'VENTAS') {
        runQuery($conn, "DELETE FROM VENTAS WHERE Codigo_vt=$id");
    }
    header("Location: index.php");
    exit;
}

// Cargar datos para mostrar tablas
$vendedores = $conn->query("SELECT * FROM VENDEDORES ORDER BY Codigo_v");
$productos = $conn->query("SELECT * FROM PRODUCTOS ORDER BY Codigo_p");
$ventas = $conn->query("SELECT V.Codigo_vt, V.Codigo_v, Ve.Nombres_v, V.Codigo_p, P.Descripcion_p, V.Fecha, V.Cantidad, V.Total
    FROM VENTAS V
    JOIN VENDEDORES Ve ON V.Codigo_v = Ve.Codigo_v
    JOIN PRODUCTOS P ON V.Codigo_p = P.Codigo_p
    ORDER BY V.Codigo_vt");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Ventas Mejorado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1.title {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }
        .table thead {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="text-center title"><i class="fas fa-store"></i> Gestión de Ventas </h1>

    <!-- Vendedores -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Vendedores</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-4">
                <form method="POST">
                    <input type="hidden" name="table" value="VENDEDORES">
                    <input type="hidden" name="action" value="<?= ($editData && $editTable === 'VENDEDORES') ? 'edit' : 'create' ?>">
                    
                    <input class="form-control mb-2" name="Codigo_v" placeholder="Código" 
                           value="<?= $editData['Codigo_v'] ?? '' ?>" 
                           <?= ($editData && $editTable === 'VENDEDORES') ? 'readonly' : '' ?>>

                    <input class="form-control mb-2" name="Apellidos_v" placeholder="Apellidos" 
                           value="<?= $editData['Apellidos_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Nombres_v" placeholder="Nombres" 
                           value="<?= $editData['Nombres_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Identificacion_v" placeholder="Identificación" 
                           value="<?= $editData['Identificacion_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Parroquia_domicilio_v" placeholder="Parroquia" 
                           value="<?= $editData['Parroquia_domicilio_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Sexo_v" placeholder="Sexo" 
                           value="<?= $editData['Sexo_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Salario_v" placeholder="Salario" type="number" step="0.01" 
                           value="<?= $editData['Salario_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Edad_v" placeholder="Edad" type="number" 
                           value="<?= $editData['Edad_v'] ?? '' ?>">

                    <button class="btn btn-primary w-100">
                        <i class="fas fa-<?= ($editData && $editTable === 'VENDEDORES') ? 'save' : 'plus' ?>"></i> 
                        <?= ($editData && $editTable === 'VENDEDORES') ? 'Guardar Cambios' : 'Agregar' ?>
                    </button>
                </form>
                <?php if ($editData && $editTable === 'VENDEDORES'): ?>
                    <a href="index.php" class="btn btn-secondary mt-2">Cancelar edición</a>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Código</th><th>Apellidos</th><th>Nombres</th><th>Identificación</th><th>Parroquia</th><th>Sexo</th><th>Salario</th><th>Edad</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($v = $vendedores->fetch_assoc()): ?>
                        <tr>
                            <td><?= $v['Codigo_v'] ?></td>
                            <td><?= $v['Apellidos_v'] ?></td>
                            <td><?= $v['Nombres_v'] ?></td>
                            <td><?= $v['Identificacion_v'] ?></td>
                            <td><?= $v['Parroquia_domicilio_v'] ?></td>
                            <td><?= $v['Sexo_v'] ?></td>
                            <td><?= $v['Salario_v'] ?></td>
                            <td><?= $v['Edad_v'] ?></td>
                            <td>
                                <a href="?edit=<?= $v['Codigo_v'] ?>&table=VENDEDORES" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="?delete=<?= $v['Codigo_v'] ?>&table=VENDEDORES" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar vendedor?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Productos -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Productos</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-4">
                <form method="POST">
                    <input type="hidden" name="table" value="PRODUCTOS">
                    <input type="hidden" name="action" value="<?= ($editData && $editTable === 'PRODUCTOS') ? 'edit' : 'create' ?>">
                    
                    <input class="form-control mb-2" name="Codigo_p" placeholder="Código" 
                           value="<?= $editData['Codigo_p'] ?? '' ?>" 
                           <?= ($editData && $editTable === 'PRODUCTOS') ? 'readonly' : '' ?>>

                    <input class="form-control mb-2" name="Tipo_producto_p" placeholder="Tipo de producto" 
                           value="<?= $editData['Tipo_producto_p'] ?? '' ?>">
                    <input class="form-control mb-2" name="Descripcion_p" placeholder="Descripción" 
                           value="<?= $editData['Descripcion_p'] ?? '' ?>">
                    <input class="form-control mb-2" name="Valor_unitario_p" placeholder="Valor unitario" type="number" step="0.01" 
                           value="<?= $editData['Valor_unitario_p'] ?? '' ?>">

                    <button class="btn btn-success w-100">
                        <i class="fas fa-<?= ($editData && $editTable === 'PRODUCTOS') ? 'save' : 'plus' ?>"></i> 
                        <?= ($editData && $editTable === 'PRODUCTOS') ? 'Guardar Cambios' : 'Agregar' ?>
                    </button>
                </form>
                <?php if ($editData && $editTable === 'PRODUCTOS'): ?>
                    <a href="index.php" class="btn btn-secondary mt-2">Cancelar edición</a>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr><th>Código</th><th>Tipo</th><th>Descripción</th><th>Valor</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                    <?php while ($p = $productos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $p['Codigo_p'] ?></td>
                            <td><?= $p['Tipo_producto_p'] ?></td>
                            <td><?= $p['Descripcion_p'] ?></td>
                            <td><?= $p['Valor_unitario_p'] ?></td>
                            <td>
                                <a href="?edit=<?= $p['Codigo_p'] ?>&table=PRODUCTOS" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="?delete=<?= $p['Codigo_p'] ?>&table=PRODUCTOS" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ventas -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Ventas</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-4">
                <form method="POST">
                    <input type="hidden" name="table" value="VENTAS">
                    <input type="hidden" name="action" value="<?= ($editData && $editTable === 'VENTAS') ? 'edit' : 'create' ?>">
                    
                    <input class="form-control mb-2" name="Codigo_vt" placeholder="Código de venta" 
                           value="<?= $editData['Codigo_vt'] ?? '' ?>" 
                           <?= ($editData && $editTable === 'VENTAS') ? 'readonly' : '' ?>>

                    <input class="form-control mb-2" name="Codigo_v" placeholder="Código vendedor" type="number" 
                           value="<?= $editData['Codigo_v'] ?? '' ?>">
                    <input class="form-control mb-2" name="Codigo_p" placeholder="Código producto" type="number" 
                           value="<?= $editData['Codigo_p'] ?? '' ?>">
                    <input class="form-control mb-2" name="Fecha" type="date" 
                           value="<?= $editData['Fecha'] ?? '' ?>">
                    <input class="form-control mb-2" name="Cantidad" placeholder="Cantidad" type="number" 
                           value="<?= $editData['Cantidad'] ?? '' ?>">
                    <input class="form-control mb-2" name="Total" placeholder="Total" type="number" step="0.01" 
                           value="<?= $editData['Total'] ?? '' ?>">

                    <button class="btn btn-info w-100">
                        <i class="fas fa-<?= ($editData && $editTable === 'VENTAS') ? 'save' : 'plus' ?>"></i> 
                        <?= ($editData && $editTable === 'VENTAS') ? 'Guardar Cambios' : 'Registrar' ?>
                    </button>
                </form>
                <?php if ($editData && $editTable === 'VENTAS'): ?>
                    <a href="index.php" class="btn btn-secondary mt-2">Cancelar edición</a>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr><th>Código</th><th>Vendedor</th><th>Producto</th><th>Fecha</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                   <?php while ($vta = $ventas->fetch_assoc()): ?>
    <tr>
        <td><?= $vta['Codigo_vt'] ?></td>
        <td><?= $vta['Nombres_v'] ?></td>
        <td><?= $vta['Descripcion_p'] ?></td>
        <td><?= $vta['Fecha'] ?></td>
        <td><?= $vta['Cantidad'] ?></td>
        <td><?= $vta['Total'] ?></td>
        <td>
            <a href="?edit=<?= $vta['Codigo_vt'] ?>&table=VENTAS" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <a href="?delete=<?= $vta['Codigo_vt'] ?>&table=VENTAS" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar venta?')"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>