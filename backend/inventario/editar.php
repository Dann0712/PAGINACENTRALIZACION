<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if (!isset($_GET['id'])) {
    header("Location: /centralizacion_pyme/frontend/modulos/inventario.php");
    exit;
}

$id = $_GET['id'];
$item = $pdo->query("SELECT * FROM inventario WHERE id = $id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    $imagen = $item['imagen'];
    if (!empty($_FILES['imagen']['name'])) {
        $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $rutaImagen = __DIR__ . '/../../uploads/inventario/' . $nombreImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
        $imagen = $nombreImagen;
    }

    $stmt = $pdo->prepare("UPDATE inventario SET nombre = ?, descripcion = ?, cantidad = ?, imagen = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $cantidad, $imagen, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/inventario.php");
    exit;
}
?>

<!-- Vista de edición -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Inventario</title>
</head>
<body>
    <h2>Editar producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" value="<?= htmlspecialchars($item['nombre']) ?>" required>
        <textarea name="descripcion" required><?= htmlspecialchars($item['descripcion']) ?></textarea>
        <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" required>
        <label>Imagen actual:</label>
        <img src="/centralizacion_pyme/uploads/inventario/<?= $item['imagen'] ?>" width="80"><br>
        <label>Reemplazar imagen:</label>
        <input type="file" name="imagen">
        <button type="submit">Actualizar</button>
    </form>
    <a href="/centralizacion_pyme/frontend/modulos/inventario.php">← Volver</a>
</body>
</html>
