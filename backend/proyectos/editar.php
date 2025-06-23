<?php
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $inversion = $_POST['inversion'];

    $stmt = $pdo->prepare("UPDATE proyectos SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?, inversion = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $fecha_inicio, $fecha_fin, $inversion, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/proyectos.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: /centralizacion_pyme/frontend/modulos/proyectos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->execute([$id]);
$proyecto = $stmt->fetch();

if (!$proyecto) {
    echo "Proyecto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
</head>
<body>
<header>
    <h1>Editar Proyecto</h1>
</header>

<main>
    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?= $proyecto['id'] ?>">
        <label>Nombre del proyecto:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($proyecto['nombre']) ?>" required>
        
        <label>Descripción:</label>
        <textarea name="descripcion" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
        
        <label>Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" value="<?= $proyecto['fecha_inicio'] ?>" required>
        
        <label>Fecha de fin:</label>
        <input type="date" name="fecha_fin" value="<?= $proyecto['fecha_fin'] ?>">
        
        <label>Inversión:</label>
        <input type="number" step="0.01" name="inversion" value="<?= $proyecto['inversion'] ?>" required>

        <button type="submit">Guardar Cambios</button>
        <a href="/centralizacion_pyme/frontend/modulos/proyectos.php">← Cancelar</a>
    </form>
</main>

</body>
</html>
