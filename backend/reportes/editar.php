<?php
require_once(__DIR__ . '/../db/conexion.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: /centralizacion_pyme/frontend/modulos/reportes_analisis.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $modulo = $_POST['modulo'] ?? '';
    $estadisticas = $_POST['estadisticas'] ?? '';

    $stmt = $pdo->prepare("UPDATE reportes_analisis SET modulo = ?, estadisticas = ? WHERE id = ?");
    $stmt->execute([$modulo, $estadisticas, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/reportes_analisis.php");
    exit;
} else {
    $stmt = $pdo->prepare("SELECT * FROM reportes_analisis WHERE id = ?");
    $stmt->execute([$id]);
    $reporte = $stmt->fetch();

    if (!$reporte) {
        header("Location: /centralizacion_pyme/frontend/modulos/reportes_analisis.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reporte</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
</head>
<body>
    <h2>Editar Reporte</h2>
    <form method="POST">
        <input type="text" name="modulo" value="<?= htmlspecialchars($reporte['modulo']) ?>" required>
        <textarea name="estadisticas" rows="6"><?= htmlspecialchars($reporte['estadisticas']) ?></textarea>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
