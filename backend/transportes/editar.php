<?php
require_once(__DIR__ . '/../db/conexion.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /centralizacion_pyme/frontend/modulos/transportes.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'] ?? '';
    $servicios = $_POST['servicios'] ?? '';
    $mantenimiento = $_POST['mantenimiento'] ?? '';
    $fotografia = $_POST['fotografia_actual'] ?? null;

    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . '_' . $_FILES['fotografia']['name'];
        move_uploaded_file($_FILES['fotografia']['tmp_name'], "../../uploads/transportes/" . $nombreArchivo);
        $fotografia = $nombreArchivo;
    }

    $sql = "UPDATE transportes SET descripcion = ?, servicios = ?, mantenimiento = ?, fotografia = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$descripcion, $servicios, $mantenimiento, $fotografia, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/transportes.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM transportes WHERE id = ?");
$stmt->execute([$id]);
$transporte = $stmt->fetch();

if (!$transporte) {
    echo "Transporte no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Transporte</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_transportes.css">
</head>
<body>
    <header>
        <h1>Editar Transporte</h1>
        <a href="/centralizacion_pyme/frontend/modulos/transportes.php">← Volver al módulo</a>
    </header>
    <main class="contenedor">
        <form method="POST" enctype="multipart/form-data">
            <textarea name="descripcion" required><?= htmlspecialchars($transporte['descripcion']) ?></textarea>
            <textarea name="servicios" required><?= htmlspecialchars($transporte['servicios']) ?></textarea>
            <textarea name="mantenimiento" required><?= htmlspecialchars($transporte['mantenimiento']) ?></textarea>
            
            <label>Fotografía actual:</label><br>
            <?php if ($transporte['fotografia']): ?>
                <img src="/centralizacion_pyme/uploads/transportes/<?= $transporte['fotografia'] ?>" width="100"><br>
            <?php endif; ?>
            <input type="hidden" name="fotografia_actual" value="<?= $transporte['fotografia'] ?>">
            <label>Nueva fotografía (opcional):</label>
            <input type="file" name="fotografia">
            <button type="submit">Actualizar Transporte</button>
        </form>
    </main>
</body>
</html>
