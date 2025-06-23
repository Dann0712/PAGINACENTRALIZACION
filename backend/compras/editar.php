<?php
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['proveedor_nombre'] ?? '';
    $contacto = $_POST['contacto'] ?? '';
    $fecha = $_POST['fecha_compra'] ?? '';
    $monto = $_POST['monto'] ?? 0;

    $stmt = $pdo->prepare("UPDATE compras_proveedores SET proveedor_nombre = ?, contacto = ?, fecha_compra = ?, monto = ? WHERE id = ?");
    $stmt->execute([$nombre, $contacto, $fecha, $monto, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/compras.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM compras_proveedores WHERE id = ?");
    $stmt->execute([$id]);
    $registro = $stmt->fetch();

    if (!$registro) {
        header("Location: /centralizacion_pyme/frontend/modulos/compras.php");
        exit;
    }
} else {
    header("Location: /centralizacion_pyme/frontend/modulos/compras.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
</head>
<body>
<header>
    <h1>Editar Compra / Proveedor</h1>
    <a href="/centralizacion_pyme/frontend/modulos/compras.php">← Volver</a>
</header>
<main class="contenedor">
    <form method="POST">
        <input type="hidden" name="id" value="<?= $registro['id'] ?>">
        <input type="text" name="proveedor_nombre" value="<?= htmlspecialchars($registro['proveedor_nombre']) ?>" required>
        <textarea name="contacto" required><?= htmlspecialchars($registro['contacto']) ?></textarea>
        <input type="date" name="fecha_compra" value="<?= $registro['fecha_compra'] ?>" required>
        <input type="number" step="0.01" name="monto" value="<?= $registro['monto'] ?>" required>
        <button type="submit">Actualizar</button>
    </form>
</main>
</body>
</html>
